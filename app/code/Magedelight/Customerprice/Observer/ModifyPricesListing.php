<?php

/**
 * Magedelight
 * Copyright (C) 2017 Magedelight <info@magedelight.com>
 *
 * @category Magedelight
 * @package Magedelight_Customerprice
 * @copyright Copyright (c) 2017 Mage Delight (http://www.magedelight.com/)
 * @license http://opensource.org/licenses/gpl-3.0.html GNU General Public License,version 3 (GPL-3.0)
 * @author Magedelight <info@magedelight.com>
 */

namespace Magedelight\Customerprice\Observer;

use Magento\Framework\Event\ObserverInterface;

class ModifyPricesListing implements ObserverInterface {

    protected $logger;
    
    protected $customerSession;
    
    protected $helper;
    
    /**
     * @param \Psr\Log\LoggerInterface $logger
     * @param \Magedelight\Customerprice\Helper\Data $helper
     * @param \Magento\Customer\Model\SessionFactory $customerSession
     */
    public function __construct(
        \Psr\Log\LoggerInterface $logger, 
        \Magedelight\Customerprice\Helper\Data $helper, 
        \Magento\Customer\Model\SessionFactory $customerSession
    ) {
        $this->logger = $logger;
        $this->helper = $helper;
        $this->customerSession = $customerSession;
    }

    /**
     * @param \Magento\Framework\Event\Observer $observer
     */
    public function execute(\Magento\Framework\Event\Observer $observer) {
        $ObjectManager = \Magento\Framework\App\ObjectManager::getInstance();
        $context = $ObjectManager->get('Magento\Framework\App\Http\Context');
        $isLoggedIn = $context->getValue(\Magento\Customer\Model\Context::CONTEXT_AUTH);

        if ($isLoggedIn && $this->helper->isEnabled()) {
            $cusId = $this->customerSession->create()->getCustomer()->getId();
            $discountModel = $this->getDiscountByCustomerId($cusId);
            $Allproducts = $observer->getCollection();
            foreach ($Allproducts as $product) {
                if ($product->getTypeId() != 'grouped') {
                    $pid = $product->getId();
                    $finalPrice = $this->helper->getFinalPrice($pid, $cusId);
                    $categoryIds = $product->getCategoryIds();
                    $priceExists = false;
                    if ($finalPrice) {
                        if (gettype($finalPrice) != 'object') {
                            $priceExists = true;
                            /* if ($finalPrice > $product->getFinalPrice() || $finalPrice < 0) {
                              $finalPrice = $product->getFinalPrice();
                              } */
                            $product->setFinalPrice($finalPrice);
                            $product->setSpecialPrice($finalPrice);
                        } else {
                            $this->helper->setProductTierPrice($product, $finalPrice);
                            $priceExists = true;
                        }
                    }
                    if (!$priceExists) {
                        if ($product->getTypeId() == 'configurable') {
                            continue;
                        }
                        $discountModelCategory = $this->getFinalPriceForCategory($cusId, $categoryIds);
                        if (!is_null($discountModelCategory) && $discountModelCategory) {
                            $priceExists = true;
                            if ($product->getTypeId() != 'bundle' && $product->getTypeId() != 'configurable') {
                                $newPrice = $product->getPrice() - ($product->getPrice() * ($discountModelCategory['maxdiscount'] / 100));
                                /* if ($newPrice > $product->getFinalPrice() || $newPrice < 0) {
                                  $newPrice = $product->getFinalPrice();
                                  } */
                                $product->setFinalPrice($newPrice);
                                $product->setSpecialPrice($newPrice);
                            }
                        }
                    }
                    if (!$priceExists) {
                        if (!is_null($discountModel) && $discountModel->getId()) {
                            $newPrice = $product->getPrice() - ($product->getPrice() * ($discountModel->getValue() / 100));
                            $product->setFinalPrice($newPrice);
                            $product->setSpecialPrice($newPrice);
                        }
                    }
                }
            }
        }
    }

    public function getDiscountByCustomerId($customerId) {
        $objectManager = \Magento\Framework\App\ObjectManager::getInstance();
        $discount = $objectManager->create('Magedelight\Customerprice\Model\Discount')->getCollection()
                ->addFieldToFilter('customer_id', array('eq' => $customerId))
                ->getFirstItem();
        if ($discount->getId()) {
            return $discount;
        } else {
            return;
        }
    }

    public function getFinalPriceForCategory($customerId, $categoryIds) {  //echo "<pre>"; print_r($categoryIds); exit;
        $objectManager = \Magento\Framework\App\ObjectManager::getInstance();
        $pricePerCustomer = $objectManager->create('\Magedelight\Customerprice\Model\Categoryprice')
                ->getCollection()
                ->addFieldToSelect('*')
                ->addFieldToFilter('category_id', array('in' => $categoryIds))
                ->addFieldToFilter('customer_id', array('eq' => $customerId));
        $pricePerCustomer->getSelect()
                ->columns(array('MAX(main_table.discount) AS maxdiscount'));
        $pricePerCustomerCategory = $pricePerCustomer->getData()[0];
        if ($pricePerCustomerCategory['categoryprice_id']) {
            return $pricePerCustomerCategory;
        } else {
            return;
        }
    }

}
