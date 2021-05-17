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

class ProcessFinalPrice implements ObserverInterface
{
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
     *
     * @return \Magedelight\Customerprice\Observer\ProcessFinalPrice
     */
    public function execute(\Magento\Framework\Event\Observer $observer)
    {
        $product = $observer->getEvent()->getProduct();
        $isBundleProduct = ($product->getTypeId() == 'bundle') ? true : false;

        $ObjectManager= \Magento\Framework\App\ObjectManager::getInstance();
        $context = $ObjectManager->get('Magento\Framework\App\Http\Context');
        $isLoggedIn = $context->getValue(\Magento\Customer\Model\Context::CONTEXT_AUTH);
        
        if ($isLoggedIn && $this->helper->isEnabled()) {
            $pid = $product->getId();
            $cusId = $this->customerSession->create()->getCustomer()->getId();
            
            if(is_null($cusId)) {
                $datamy = $ObjectManager->create('Magento\Customer\Helper\Session\CurrentCustomer');
                $cusId  = $datamy->getCustomer()->getId();
            }
            
            $finalPrice = $this->helper->getFinalPrice($pid, $cusId, $isBundleProduct);                    
            $priceExists = false;
            $categoryIds = $product->getCategoryIds();
            if ($finalPrice) {
                if (gettype($finalPrice) == 'object') {
                    $priceExists = true;
                    $this->helper->setProductTierPrice($product, $finalPrice);                    
                } else {
                    $priceExists = true;
                    /*if ($finalPrice > $product->getFinalPrice() || $finalPrice < 0) {
                        $finalPrice = $product->getFinalPrice();
                    }*/
                    $product->setSpecialPrice($finalPrice);
                    $product->setFinalPrice($finalPrice);
                }
            }
            
            if (!$priceExists) {
                $discountModelCategory = $this->getFinalPriceForCategory($cusId, $categoryIds);
                    if (!is_null($discountModelCategory) && $discountModelCategory) {
                        if ($product->getTypeId() != 'bundle') {
                            $priceExists = true;
                            $newPrice = $product->getPrice() - ($product->getPrice() * ($discountModelCategory['maxdiscount'] / 100));      
                        /*if ($newPrice > $product->getFinalPrice() || $newPrice < 0) {
                            $newPrice = $product->getFinalPrice();
                        }*/
                        $product->setFinalPrice($newPrice);
                        $product->setSpecialPrice($newPrice);
                    }       
                }
            }
            
            if (!$priceExists) {
                $discountModel = $this->getDiscountByCustomerId($cusId);

                if (!is_null($discountModel) && $discountModel->getId()) {
                    $newPrice = $product->getPrice() - ($product->getPrice() * ($discountModel->getValue() / 100));
                    $product->setFinalPrice($newPrice);
                    $product->setSpecialPrice($newPrice);
                }
            }

            return $this;
        }
    }

    public function getDiscountByCustomerId($customerId)
    {
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
    public function getFinalPriceForCategory($customerId, $categoryIds)
    {
        $objectManager = \Magento\Framework\App\ObjectManager::getInstance();
        $pricePerCustomer = $objectManager->create('\Magedelight\Customerprice\Model\Categoryprice')
                ->getCollection()
                ->addFieldToSelect('*')
                ->addFieldToFilter('category_id', array('in' => $categoryIds))
                ->addFieldToFilter('customer_id', array('eq' => $customerId));
        $pricePerCustomer->getSelect()
                    ->columns(array('MAX(main_table.discount) AS maxdiscount'));
        $pricePerCustomerCategory = $pricePerCustomer->getData()[0];
        //echo "<pre>"; print_r($pricePerCustomerCategory); exit;
        if ($pricePerCustomerCategory['categoryprice_id']) {
            return $pricePerCustomerCategory;
        } else {
            return;
        }
    }
}
