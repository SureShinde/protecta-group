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

namespace Magedelight\Customerprice\Block\Adminhtml\Customer\Price\Items;

use Magento\CatalogInventory\Api\StockRegistryInterface;
use Magento\CatalogInventory\Api\StockStateInterface;
use Magento\Framework\Pricing\PriceCurrencyInterface;
use Magento\Framework\ObjectManagerInterface;

/**
 * Adminhtml sales order create items grid block.
 *
 * @SuppressWarnings(PHPMD.CouplingBetweenObjects)
 */
class Grid extends \Magento\Sales\Block\Adminhtml\Order\Create\AbstractCreate
{
    /**
     * Flag to check can items be move to customer storage.
     *
     * @var bool
     */
    protected $_moveToCustomerStorage = true;

    /**
     * Tax data.
     *
     * @var \Magento\Tax\Helper\Data
     */
    protected $_taxData;

    /**
     * Wishlist factory.
     *
     * @var \Magento\Wishlist\Model\WishlistFactory
     */
    protected $_wishlistFactory;

    /**
     * Gift message save.
     *
     * @var \Magento\GiftMessage\Model\Save
     */
    protected $_giftMessageSave;

    /**
     * Tax config.
     *
     * @var \Magento\Tax\Model\Config
     */
    protected $_taxConfig;

    /**
     * Message helper.
     *
     * @var \Magento\GiftMessage\Helper\Message
     */
    protected $_messageHelper;

    /**
     * @var StockRegistryInterface
     */
    protected $stockRegistry;

    /**
     * @var StockStateInterface
     */
    protected $stockState;

    /**
     * @param \Magento\Backend\Block\Template\Context $context
     * @param \Magento\Backend\Model\Session\Quote    $sessionQuote
     * @param \Magento\Sales\Model\AdminOrder\Create  $orderCreate
     * @param PriceCurrencyInterface                  $priceCurrency
     * @param \Magento\Wishlist\Model\WishlistFactory $wishlistFactory
     * @param \Magento\GiftMessage\Model\Save         $giftMessageSave
     * @param \Magento\Tax\Model\Config               $taxConfig
     * @param \Magento\Tax\Helper\Data                $taxData
     * @param \Magento\GiftMessage\Helper\Message     $messageHelper
     * @param StockRegistryInterface                  $stockRegistry
     * @param StockStateInterface                     $stockState
     * @param array                                   $data
     * @SuppressWarnings(PHPMD.ExcessiveParameterList)
     */
    public function __construct(
    \Magento\Backend\Block\Template\Context $context, \Magento\Backend\Model\Session\Quote $sessionQuote, \Magento\Sales\Model\AdminOrder\Create $orderCreate, PriceCurrencyInterface $priceCurrency, \Magento\Wishlist\Model\WishlistFactory $wishlistFactory, \Magento\GiftMessage\Model\Save $giftMessageSave, \Magento\Tax\Model\Config $taxConfig, \Magento\Tax\Helper\Data $taxData, \Magento\GiftMessage\Helper\Message $messageHelper, StockRegistryInterface $stockRegistry, StockStateInterface $stockState, ObjectManagerInterface $objectManager, array $data = []
    ) {
        $this->_messageHelper = $messageHelper;
        $this->_wishlistFactory = $wishlistFactory;
        $this->_giftMessageSave = $giftMessageSave;
        $this->_taxConfig = $taxConfig;
        $this->_taxData = $taxData;
        $this->stockRegistry = $stockRegistry;
        $this->stockState = $stockState;
        $this->_objectManager = $objectManager;
        parent::__construct($context, $sessionQuote, $orderCreate, $priceCurrency, $data);
    }

    /**
     * Constructor.
     */
    protected function _construct()
    {
        parent::_construct();
        $this->setId('customer_product_grid');
    }

    public function getOptionValues()
    {
        $customerId = $this->getRequest()->getParam('id');

        $objectManager = \Magento\Framework\App\ObjectManager::getInstance();
        $optionCollection = $objectManager->create('\Magedelight\Customerprice\Model\Customerprice')
                ->getCollection()
                ->addFieldToSelect('*')->addFieldToFilter('customer_id', array('eq' => $customerId))
                ->setOrder('product_id');

        $finaldata = array();
        $k = 0;
        $productObj = array();
        foreach ($optionCollection as $key => $option) {
            if (!isset($productObj[$option['product_id']])) {
                $productObj[$option['product_id']] = $objectManager->get('Magento\Catalog\Model\Product')->load(trim($option['product_id']))->getTypeId();
            }
            $finaldata[$key]['id'] = $key;
            $finaldata[$key]['pname'] = htmlspecialchars($option['product_name']);
            $finaldata[$key]['pid'] = $option['product_id'];
            $finaldata[$key]['price'] = $option['price'];
            $finaldata[$key]['newprice'] = $option['log_price'];
            $finaldata[$key]['logprice'] = $option['log_price'];
            $finaldata[$key]['qty'] = $option['qty'];
            $finaldata[$key]['css_class'] = '';
            $finaldata[$key]['sign'] = '';
            if ($productObj[$option['product_id']] == 'bundle') {
                $finaldata[$key]['css_class'] = 'validate-greater-than-zero validate-percents';
                $finaldata[$key]['sign'] = '%';
            }
            ++$k;
        }

        return json_encode($finaldata);
    }

    public function getDiscountByCustomerId($customerId)
    {
        $discount = $this->_objectManager->create('Magedelight\Customerprice\Model\Discount')->getCollection()
                ->addFieldToFilter('customer_id', array('eq' => $customerId))
                ->getFirstItem();
        if ($discount->getId()) {
            return $discount;
        } else {
            return;
        }
    }
}
