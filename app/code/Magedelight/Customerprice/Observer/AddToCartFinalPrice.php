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

class AddToCartFinalPrice implements ObserverInterface
{
    protected $logger;
    protected $customerSession;
    protected $helper;
    protected $_priceModel;

    /**
     * @var \Magento\CatalogRule\Model\RuleFactory
     */
    protected $ruleFactory;

    /**
     * @param \Psr\Log\LoggerInterface                  $logger
     * @param \Magedelight\Customerprice\Helper\Data             $helper
     * @param \Magento\Checkout\Model\Session           $session
     * @param \Magento\Catalog\Model\Product\Type\Price $priceModel
     * @param \Magento\Customer\Model\Session           $customerSession
     */
    public function __construct(
    \Psr\Log\LoggerInterface $logger, \Magedelight\Customerprice\Helper\Data $helper, \Magento\Checkout\Model\Session $session, \Magento\Catalog\Model\Product\Type\Price $priceModel, \Magento\Customer\Model\Session $customerSession, \Magento\CatalogRule\Model\RuleFactory $ruleFactory
    ) {
        $this->logger = $logger;
        $this->helper = $helper;
        $this->session = $session;
        $this->_priceModel = $priceModel;
        $this->customerSession = $customerSession;
        $this->ruleFactory = $ruleFactory;
    }

    /**
     * @param \Magento\Framework\Event\Observer $observer
     *
     * @return bool
     */
    public function execute(\Magento\Framework\Event\Observer $observer)
    {
        $ObjectManager= \Magento\Framework\App\ObjectManager::getInstance();
        $context = $ObjectManager->get('Magento\Framework\App\Http\Context');
        $isLoggedIn = $context->getValue(\Magento\Customer\Model\Context::CONTEXT_AUTH);
        
        if ($isLoggedIn && $this->helper->isEnabled()) {
            $quote = $this->session->getQuote();
            $cartItems = $quote->getAllItems();
            $cusId = $this->customerSession->getId();
            if(is_null($cusId)) {
                $datamy = $ObjectManager->get('Magento\Customer\Helper\Session\CurrentCustomer');
                $cusId  = $datamy->getCustomer()->getId();
            }
            $discountModel = $this->getDiscountByCustomerId($cusId);
            foreach ($cartItems as $item) {
                $pid = $item->getProductId();
                $product = $item->getProduct();

                $finalPrice = $this->helper->getFinalPrice($pid, $cusId);
                $categoryIds = $product->getCategoryIds();
                $discountModelCategory = $this->getFinalPriceForCategory($cusId, $categoryIds);
                
                $priceExists = false;
                if ($finalPrice) {
                    if (gettype($finalPrice) == 'object') {
                        $priceExists = true;
                        $h = $this->helper->setProductTierPrice($product, $finalPrice);
                        if ($item->getParentItem()) {
                            $parent_item = $item->getParentItem();
                            if ($parent_item->getProduct()->getTypeId() == 'bundle') {
                                $qty = $item->getQty();
                            } else {
                                $qty = $parent_item->getQty();
                            }
                        } else {
                            $qty = $item->getQty();
                        }
                        $t = $this->_priceModel->getTierPrice($qty, $h);
                        $productFinalPrice = $product->getFinalPrice();

                        $customOptionPrice = $this->helper->getCustomOptionPrice($item, $t);
                        if ($customOptionPrice > 0) {
                            $productFinalPrice = $productFinalPrice - $customOptionPrice;
                        }
                        $t = min($t, $productFinalPrice);
                        $t = $t + $customOptionPrice;

                        $item->getProduct()->setSpecialPrice($t);
                        $item->setCustomPrice($t);

                        $item->setOriginalCustomPrice($t);
                        $item->getProduct()->setIsSuperMode(true);
                        if ($item->getParentItem()) {
                            $item = $item->getParentItem();
                            $item->setCustomPrice($t);
                            $item->setOriginalCustomPrice($t);
                            $item->getProduct()->setIsSuperMode(true);
                        }
                    } else {
                        $priceExists = true;

                        if ($finalPrice > $product->getFinalPrice() || $finalPrice < 0) {
                            $finalPrice = $product->getFinalPrice();
                        }
                        if ($item->getParentItem()) {
                            $parent_item = $item->getParentItem();
                            if ($parent_item->getProduct()->getTypeId() == 'bundle') {
                                $qty = $item->getQty();
                            } else {
                                $qty = $parent_item->getQty();
                            }
                        } else {
                            $qty = $item->getQty();
                        }
                        $t = $this->_priceModel->getTierPrice($qty, $product);
                        if ($item->getParentItem()) {
                            $parent_item = $item->getParentItem();
                            $customOptionPrice = $this->helper->getCustomOptionPrice($parent_item, $finalPrice);
                            if ($customOptionPrice > 0) {
                                $finalPrice = $product->getFinalPrice();
                            }
                            $finalPrice = $finalPrice + $customOptionPrice;
                        } else {
                            $customOptionPrice = $this->helper->getCustomOptionPrice($item, $finalPrice);
                            if ($customOptionPrice > 0) {
                                $finalPrice = $product->getFinalPrice();
                            }
                            $finalPrice = $finalPrice + $customOptionPrice;
                        
                            $finalPrice = min($t, $finalPrice);
                        
                        }
                        
                        $finalPrice = min($t, $finalPrice);
                        $item->getProduct()->setSpecialPrice($finalPrice);
                        $item->setCustomPrice($finalPrice);
                        $item->setOriginalCustomPrice($finalPrice);
                        $item->getProduct()->setIsSuperMode(true);
                        if ($item->getParentItem()) {
                            $item = $item->getParentItem();
                            $item->setCustomPrice($finalPrice);
                            $item->setOriginalCustomPrice($finalPrice);
                            $item->getProduct()->setIsSuperMode(true);
                        }
                    }
                }
                
                if (!$priceExists) {
                    if($product->getTypeId() == 'configurable'){
                            continue;
                    }
                    if (!is_null($discountModelCategory) && $discountModelCategory) {
                        $priceExists = true;
                        
                        if ($product->getTypeId() != 'bundle') {
                        $newPrice = $product->getPrice() - ($product->getPrice() * ($discountModelCategory['maxdiscount'] / 100));  
                        if ($newPrice > $product->getFinalPrice() || $newPrice < 0) {
                            $newPrice = $product->getFinalPrice();
                        }
                        /*$customOptionPrice = $this->helper->getCustomOptionPrice($item, $newPrice);
                        $newPrice = $newPrice + $customOptionPrice; */
                        
                        if ($item->getParentItem()) {
                            $parent_item = $item->getParentItem();
                            if ($parent_item->getProduct()->getTypeId() == 'bundle') {
                                $qty = $item->getQty();
                            } else {
                                $qty = $parent_item->getQty();
                            }
                        } else {
                            $qty = $item->getQty();
                        }
                        $t = $this->_priceModel->getTierPrice($qty, $product);
                        if ($item->getParentItem()) {
                            $parent_item = $item->getParentItem();
                            $customOptionPrice = $this->helper->getCustomOptionPrice($parent_item, $newPrice);
                            if ($customOptionPrice > 0) {
                                $newPrice = $product->getFinalPrice();
                            }
                            $newPrice = $newPrice + $customOptionPrice;
                        } else {
                            $customOptionPrice = $this->helper->getCustomOptionPrice($item, $newPrice);
                            if ($customOptionPrice > 0) {
                                $newPrice = $product->getFinalPrice();
                            }
                            $newPrice = $newPrice + $customOptionPrice;
                        
                            $newPrice = min($t, $newPrice);
                        
                        }
                        
                        $item->getProduct()->setSpecialPrice($newPrice);
                        $item->setCustomPrice($newPrice);
                        $item->setOriginalCustomPrice($newPrice);
                        $item->getProduct()->setIsSuperMode(true);
                       
                        if ($item->getParentItem()) {
                            $parent_item = $item->getParentItem();
                            $type = $parent_item->getProduct()->getTypeId();
                            if($type!='bundle')
                            {
                                $item = $item->getParentItem();
                                $item->setCustomPrice($newPrice);
                                $item->setOriginalCustomPrice($newPrice);
                                $item->getProduct()->setIsSuperMode(true);

                            }
                        }
                    }
                    }
                } 
                
                if (!$priceExists) {
                    if (!is_null($discountModel) && $discountModel->getId()) {
                        $newPrice = $product->getPrice() - ($product->getPrice() * ($discountModel->getValue() / 100));
                        $item->getProduct()->setSpecialPrice($newPrice);
                        $item->setCustomPrice($newPrice);
                        $item->setOriginalCustomPrice($newPrice);
                        $item->getProduct()->setIsSuperMode(true);
                        if ($item->getParentItem()) {
                            $item = $item->getParentItem();
                            $item->setCustomPrice($newPrice);
                            $item->setOriginalCustomPrice($newPrice);
                            $item->getProduct()->setIsSuperMode(true);
                        }
                    }
                }
            }

            return true;
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
        if ($pricePerCustomerCategory['categoryprice_id']) {
            return $pricePerCustomerCategory;
        } else {
            return;
        }
    }
}
