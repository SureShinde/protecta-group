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

class AddToWishlistFinalPrice implements ObserverInterface
{
    protected $logger;
    protected $customerSession;
    protected $helper;
    protected $_priceModel;

    /**
     * @param \Psr\Log\LoggerInterface                  $logger
     * @param \Magedelight\Customerprice\Helper\Data             $helper
     * @param \Magento\Checkout\Model\Session           $session
     * @param \Magento\Catalog\Model\Product\Type\Price $priceModel
     * @param \Magento\Wishlist\Model\WishlistFactory   $wishlistFactory
     * @param \Magento\Customer\Model\Session           $customerSession
     */
    public function __construct(
    \Psr\Log\LoggerInterface $logger, \Magedelight\Customerprice\Helper\Data $helper, \Magento\Checkout\Model\Session $session, \Magento\Catalog\Model\Product\Type\Price $priceModel, \Magento\Wishlist\Model\WishlistFactory $wishlistFactory, \Magento\Customer\Model\Session $customerSession
    ) {
        $this->logger = $logger;
        $this->helper = $helper;
        $this->session = $session;
        $this->_priceModel = $priceModel;
        $this->wishlistFactory = $wishlistFactory;
        $this->customerSession = $customerSession;
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
            $cusId = $this->customerSession->getId();
            $wishList = $this->wishlistFactory->create()->loadByCustomerId($cusId, true);

            $wishListItemCollection = $wishList->getItemCollection();
            foreach ($wishListItemCollection as $item) {
                $pid = $item->getProductId();
                if ($item->getProduct()->getTypeId() == 'bundle') {
                    continue;
                }
                $cusId = $this->customerSession->getId();
                $priceExists = false;
                $finalPrice = $this->helper->getFinalPrice($pid, $cusId);
                $categoryIds = $item->getProduct()->getCategoryIds();
                $discountModelCategory = $this->getFinalPriceForCategory($cusId, $categoryIds);
                if ($finalPrice) {
                    $priceExists = true;
                    if (gettype($finalPrice) == 'object') {
                        $h = $this->helper->setProductTierPrice($item->getProduct(), $finalPrice);
                        $t = $this->_priceModel->getTierPrice($item->getQty(), $h);
                        $item->getProduct()->setSpecialPrice($t);
                        $item->setCustomPrice($t);
                        $item->setOriginalCustomPrice($t);
                        $item->getProduct()->setIsSuperMode(true);
                    } else {
                        $item->getProduct()->setSpecialPrice($finalPrice);
                        $item->setCustomPrice($finalPrice);
                        $item->setOriginalCustomPrice($finalPrice);
                        $item->getProduct()->setIsSuperMode(true);
                    }
                }
                if (!$priceExists) {
                        if (!is_null($discountModelCategory) && $discountModelCategory) {
                            $newPrice = $product->getPrice() - ($product->getPrice() * ($discountModelCategory['maxdiscount'] / 100));  
                            if ($newPrice > $product->getFinalPrice() || $newPrice < 0) {
                                $newPrice = $product->getFinalPrice();
                            }
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
