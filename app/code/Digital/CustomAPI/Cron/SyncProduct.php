<?php

namespace Digital\CustomAPI\Cron;

use Digital\CustomAPI\Services\Product;
use Digital\CustomAPI\Helper\CustomLogger;
use Digital\CustomAPI\Services\Categories;
use Digital\CustomAPI\Services\NetSuiteServices;
use Magento\Catalog\Api\ProductRepositoryInterface;
use Digital\CustomAPI\Services\ProductLocationQuantity;
class SyncProduct
{
    protected $productCategories;
    protected $customerGroups;
    protected $_nsService;
    protected $eavConfig;

    public function __construct(\Magento\Eav\Model\Config $eavConfig) {
        $this->customerGroups = [];
        $this->_nsService = new NetSuiteServices();
        $this->eavConfig = $eavConfig;
    }

    private function getProductCategory($class, $group, $subgroup) {
        if(!$class) return;
        foreach($this->productCategories as $category) {
            if($category['name'] == 'Products') {
                foreach($category['children_data'] as $ns_class) {
                    if(strtolower($ns_class['name']) == strtolower($class)) {
                        foreach($ns_class['children_data'] as $ns_group) {
                            if(strtolower($ns_group['name']) == strtolower($group)) {
                                return $ns_group['id'];
                                // foreach($ns_group['children_data'] as $sub_group) {
                                //     if(strtolower($sub_group['name']) == strtolower($subgroup)) {
                                //         return $sub_group['id'];
                                //     }
                                // }
                            }
                        }
                    }
                }
            }
        }

        return;
    }

	public function execute() {
        try {
            $attribute = $this->eavConfig->getAttribute('catalog_product', 'pg_product_profile');
            $eavOptions = $attribute->getSource()->getAllOptions();

            (new Categories)->execute();
            /**
             * Get all categories from database
             */
            $this->productCategories = (new Categories)->getCategories();

            /**
             * Get customer groups from database
             */
            $this->getAllCustomerGroup();

            /**
             *  Get all active items from NetSuite
             */
            $products = $this->_nsService->getProducts();

            $categoryIds = [];
            foreach($products as $key => $product) {
                $data['sku'] = $product->itemID;
                $data['name'] = $product->storedisplayname != '' ? $product->storedisplayname : $product->itemID;
                $data['price'] = $product->baseprice;
                $data['quantity'] = $product->quantityAvailable ?? 0;
                $data['description'] = $product->description;
                $data['short_description'] = $product->storeDetailedDescription;
                $data['internalid'] = $product->internalID;
                $data['displayImage'] = $product->displayImage;
                $data['status'] = $product->isonline ? 1 : 2;
                $data['weight'] = $product->weight;

                $data['cat_class'] = $product->productClass ? $product->productClass :  '';
                $data['cat_group'] = $product->productGroup ? $product->productGroup : '';
                $data['cat_subgroup'] = $product->productSubGroup ? $product->productSubGroup : '';

                array_push($categoryIds,  $this->getProductCategory($data['cat_class'], $data['cat_group'], $data['cat_subgroup']));
                if(isset($products[$key+1]) && ($product->internalID == $products[$key+1]->internalID)) {
                    continue;
                }

                $data['category_ids'] = $categoryIds;
                $productProfile = '';
                foreach($eavOptions as $eavOption) {
                    if($product->profile == $eavOption['label']) {
                        $productProfile = $eavOption['value'];
                        break;
                    }
                }
                $customAttributes = [
                    "pg_volume" => $product->volume,
                    "pg_product_profile" => $productProfile,
                    "pg_weight" => $product->weight,
                    "pg_weight_unit" => $product->weightunit,
                    "short_description" => $product->storeDetailedDescription,
                    "description" => $product->storeDetailedDescription,
                    "pg_internal_id" => $product->internalID,
                    "pg_featured_description" => $product->featuredDescription
                ];
                $data['customAttributes'] = $customAttributes;

                // get product price matrix
                $priceMatrices = $this->_nsService->getPriceMatrices( $product->internalID );
                if($priceMatrices != false ) {
                    $tirePrices = [];
                    foreach($priceMatrices as $priceMatrix) {
                        $cust_group = $this->getCustomerGroupId($priceMatrix->name);
                        if(!$cust_group) continue;
                        $price = [
                            "cust_group" => $cust_group,
                            "price_qty" => $priceMatrix->mincount == 0 ? 1 : $priceMatrix->mincount,
                            "price" => $priceMatrix->unitprice,
                            "percentage_value" => NULL,
                            "website_id" => 0
                        ];
                        array_push($tirePrices, $price);
                    }
                    $data['tier_prices'] = $tirePrices;
                }

                $zoneQty = (new ProductLocationQuantity)->getProductLocationQuantity($data['internalid']);
                if(!empty($zoneQty)) {
                    $data['customAttributes'] = array_merge($data['customAttributes'], $zoneQty);
                }

                $prod = Product::getProductBySku($data['sku']);
                if(!$prod) {
                   (new Product)->createProduct($data);
                }else {
                    (new Product)->updateProduct($data, $prod);
                }
                $categoryIds = [];
            }
        } catch (\Exception $e) {
            CustomLogger::webo_custom_logger('product_sync', $e->getMessage());
        }
    }

    private function getCustomerGroupId( $groupName ) {

        foreach($this->customerGroups as $customerGroup) {
            if(strtolower($customerGroup['label']) == strtolower($groupName)) {
                return $customerGroup['value'];
            }
        }
        return false;
        // return "3"; //base price group id
    }

    private function getAllCustomerGroup() {
        $objectManager = \Magento\Framework\App\ObjectManager::getInstance();
        $groupOptions = $objectManager->get('\Magento\Customer\Model\ResourceModel\Group\Collection')->toOptionArray();

        $this->customerGroups = $groupOptions;
    }
}
