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

namespace Magedelight\Customerprice\Helper;

use Magento\Framework\Pricing\PriceCurrencyInterface;

class Data extends \Magento\Framework\App\Helper\AbstractHelper
{
    const XML_PATH_GENERAL_ENABLED = 'customerprice/general/enable';

    /**
     * @var \Magento\Framework\App\Config\ScopeConfigInterface
     */
    protected $scopeConfig;
    
    protected $_customerSession;

    /**
     * Customer Group factory.
     *
     * @var \Magento\Customer\Model\GroupFactory
     */
    protected $_customerGroupFactory;

    /**
     * @var PriceCurrencyInterface
     */
    protected $priceCurrency;

    /**
     * @var \Magento\Catalog\Helper\Data
     */
    protected $_catalogData;
    
    protected $_optionHelper;

    /**
     * @param \Magento\Framework\App\Helper\Context $context
     * @param \Magento\Customer\Model\GroupFactory $customerGroupFactory
     * @param PriceCurrencyInterface $priceCurrency
     * @param \Magento\Store\Model\StoreManagerInterface $storeManager
     * @param \Magento\Catalog\Helper\Data $catalogData
     * @param \Magento\Customer\Model\Session $customerSession
     */
    public function __construct(
        \Magento\Framework\App\Helper\Context $context, 
        \Magento\Customer\Model\GroupFactory $customerGroupFactory, 
        PriceCurrencyInterface $priceCurrency, 
        \Magento\Store\Model\StoreManagerInterface $storeManager, 
        \Magento\Catalog\Helper\Data $catalogData, 
        \Magento\Catalog\Helper\Product\Configuration $optionHelper, 
        \Magento\Customer\Model\Session $customerSession
    ) {
        $this->scopeConfig = $context->getScopeConfig();
        $this->_customerGroupFactory = $customerGroupFactory;
        $this->priceCurrency = $priceCurrency;
        $this->_storeManager = $storeManager;
        $this->_catalogData = $catalogData;
        $this->_optionHelper = $optionHelper;
        $this->_customerSession = $customerSession;
        parent::__construct($context);
    }

    public function isEnabled()
    {
        $storeScope = \Magento\Store\Model\ScopeInterface::SCOPE_STORE;

        return $this->scopeConfig->getValue(self::XML_PATH_GENERAL_ENABLED, $storeScope);
    }
    
    public function getDomainName($domain){
        $string = '';
        
        $withTrim = str_replace(array("www.","http://","https://"),'',$domain);
        
        /* finding the first position of the slash  */
        $string = $withTrim;
        
        $slashPos = strpos($withTrim,"/",0);
        
        if($slashPos != false){
            $parts = explode("/",$withTrim);
            $string = $parts[0];
        }
        return $string;
    }

    public function getWebsites()
    {
        $websites = $this->_storeManager->getWebsites();
        $websiteUrls = array();
        foreach($websites as $website)
        {
            foreach($website->getStores() as $store){
                $wedsiteId = $website->getId();
                $storeObj = $this->_storeManager->getStore($store);
                $storeId = $storeObj->getId();
                $url = $storeObj->getBaseUrl(\Magento\Framework\UrlInterface::URL_TYPE_WEB);
                $parsedUrl = parse_url($url);
                $websiteUrls[] = str_replace(array('www.', 'http://', 'https://'), '', $parsedUrl['host']);
            }
        }

        return $websiteUrls;
    }

    public function getConfig($config_path)
    {
        return $this->scopeConfig->getValue(
            $config_path,
            \Magento\Store\Model\ScopeInterface::SCOPE_STORE
        );
    }

    public function getFinalPrice($pid, $cusId, $isBundleProduct = false)
    {
        $objectManager = \Magento\Framework\App\ObjectManager::getInstance();
        $pricePerCustomer = $objectManager->create('\Magedelight\Customerprice\Model\Customerprice')
                ->getCollection()
                ->addFieldToSelect('*')
                ->addFieldToFilter('product_id', array('eq' => $pid))
                ->addFieldToFilter('customer_id', array('eq' => $cusId));

        if ($isBundleProduct == true) {
            return $pricePerCustomer;
        } else {
            if (count($pricePerCustomer) == 1) {
                foreach ($pricePerCustomer as $key => $value) {
                    $qtyArray[] = $value['qty'];
                    if (in_array(1, $qtyArray)) {
                        return $value['new_price'];
                    } else {
                        return $pricePerCustomer;
                    }
                }
            }

            if (count($pricePerCustomer) > 1) {
                return $pricePerCustomer;
            }
        }
    }
    
   /* public function getFinalPriceForCategory($categoryIds, $cusId, $finalPrice, $isBundleProduct = false)
    {   
        $objectManager = \Magento\Framework\App\ObjectManager::getInstance();
        $pricePerCustomer = $objectManager->create('\Magedelight\Customerprice\Model\Categoryprice')
                ->getCollection()
                ->addFieldToSelect('*')
                ->addFieldToFilter('category_id', array('in' => $categoryIds))
                ->addFieldToFilter('customer_id', array('eq' => $cusId));
        $pricePerCustomer->getSelect()
                    ->columns(array('MAX(main_table.discount) AS maxdiscount'));
        //echo "<pre>";print_r($pricePerCustomer->getData()); exit;
        if ($isBundleProduct == true) {
            return $pricePerCustomer;
        } else {
            if (count($pricePerCustomer) == 1) {
                foreach ($pricePerCustomer as $key => $value) {
                    return $finalPrice - ($finalPrice * ($value['maxdiscount'] / 100));
                }
            }
            if (count($pricePerCustomer) > 1) {
                return $pricePerCustomer;
            }
        }
    } */

    public function setProductTierPrice($product, $priceCustomer)
    {
        $res = array();
        if (is_null($product)) {
            return $res;
        }

        $product->setData('tier_price', '');

        $prices = $priceCustomer;

        if (count($prices) > 0) {
            foreach ($prices as $price) {
                $price['price_qty'] = $price['qty'] * 1;
                $price['price'] = $price['new_price'];
                $price['website_price'] = $price['new_price'];
                $price['value'] = $price['new_price'];

                $price['customer_group_id'] = $this->_customerSession->getCustomerGroupId();

                $group = $this->_customerGroupFactory->create()->getCollection()->addFieldToFilter('customer_group_id', array('eq' => $price['customer_group_id']))->getFirstItem();

                if ($group->getCustomerGroupId()) {
                    $price['cust_group_name'] = $group->getCustomerGroupCode();
                }

                $productPrice = $product->getPrice();
                
                if ($product->getTypeId() != 'bundle') {
                    if ($price['price'] < $productPrice) {
                        $price['savePercent'] = ceil(100 - ((100 / $productPrice) * $price['price']));

                        $tierPrice = $this->convertPrice(
                                $this->_catalogData->getTaxPrice($product, $price['website_price'])
                        );
                        $price['formated_price'] = $tierPrice;

                        $res[] = $price;
                    }
                } else {
                    $price['savePercent'] = ceil(100 - $price['price']);

                    $tierPrice = $this->convertPrice(
                            $this->_catalogData->getTaxPrice($product, $price['website_price'])
                    );
                    $price['formated_price'] = $this->formatPrice($tierPrice);
                    $priceInclTax = $this->convertPrice(
                            $this->_catalogData->getTaxPrice($product, $price['website_price'])
                    );
                    $price['formated_price_incl_tax'] = $priceInclTax;
                    $res[] = $price;
                }
            }
        }

        $g = array();
        foreach ($res as $re) {
            $g[] = $re;
        }

        $product->setTierPrices($g);

        return $product;
    }

    /**
     * @param float $price
     * @param bool  $format
     *
     * @return float
     */
    public function convertPrice($price, $format = true)
    {
        return $format ? $this->priceCurrency->convertAndFormat($price) : $this->priceCurrency->convert($price);
    }

    /**
     * @param float $price
     *
     * @return string
     */
    public function formatPrice($price)
    {
        return $this->priceCurrency->format(
                        $price, true, PriceCurrencyInterface::DEFAULT_PRECISION, $this->_storeManager->getStore()
        );
    }

    public function getCustomOptionPrice($item, $t)
    {
        
        $CustomOptionprice = 0;
        
        $productOptions = $item->getProduct()->getTypeInstance(true)->getOrderOptions($item->getProduct());

        if (isset($productOptions['options'])) {
            foreach ($productOptions['options'] as $key => $value) {
                $optionType = $value['option_type'];
                if ($optionType == 'drop_down' || $optionType == 'multiple' || $optionType == 'radio' || $optionType == 'checkbox' || $optionType == 'multiple') {
                    $this->_resources = \Magento\Framework\App\ObjectManager::getInstance()
                            ->get('Magento\Framework\App\ResourceConnection');
                    $connection = $this->_resources->getConnection();

                    $optionValue = explode(',', $value['option_value']);
                    for ($count = 0; $count < count($optionValue); ++$count) {
                        $select = $connection->select()
                                ->from(
                                        ['o' => $this->_resources->getTableName('catalog_product_option_type_price')]
                                )
                                ->where('o.option_type_id=?', $optionValue[$count]);

                        $result = $connection->fetchAll($select);
                        if (isset($result)) {
                            if ($result[0]['price_type'] == 'fixed') {
                                $CustomOptionprice += $result[0]['price'];
                            } else {
                                $CustomOptionprice += ($t * ($result[0]['price'] / 100));
                            }
                        }
                    }
                } else {
                    $this->_resources = \Magento\Framework\App\ObjectManager::getInstance()
                            ->get('Magento\Framework\App\ResourceConnection');
                    $connection = $this->_resources->getConnection();

                    $select = $connection->select()
                            ->from(
                                    ['o' => $this->_resources->getTableName('catalog_product_option_price')]
                            )
                            ->where('o.option_id=?', $value['option_id']);

                    $result = $connection->fetchAll($select);
                    if (isset($result)) {
                        if ($result[0]['price_type'] == 'fixed') {
                            $CustomOptionprice += $result[0]['price'];
                        } else {
                            $CustomOptionprice += ($t * ($result[0]['price'] / 100));
                        }
                    }
                }
            }
        }
        return $CustomOptionprice;
    }
}
