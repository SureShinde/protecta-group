<?php

namespace Digital\CustomAPI\Model;

use Digital\CustomAPI\Services\Product;
use Digital\CustomAPI\Helper\CustomLogger;
use Digital\CustomAPI\Services\Categories;
use Digital\CustomAPI\Services\NetSuiteServices;
use Digital\CustomAPI\Services\ProductLocationQuantity;

class UpdateProduct implements \Digital\CustomAPI\Api\UpdateProductInterface
{
    protected $productCategories;

    public function __construct(\Magento\Eav\Model\Config $eavConfig) {
        $this->productCategories = [];
        $this->eavConfig = $eavConfig;
    }
    /**
     * Update Products
     *
     * @api
     * @param mixed $params
     * @return string
     */
    public function updateproduct($params)
    {
        try {
            $attribute = $this->eavConfig->getAttribute('catalog_product', 'pg_product_profile');
            $eavOptions = $attribute->getSource()->getAllOptions();

            $this->productCategories= (new Categories)->getCategories();

            $categoryIds = [];

            $items = $params['items'];
            foreach($items as $key => $item) {
                $data['sku'] = $item['itemID'];
                $data['name'] = $item['storedisplayname'] != '' ? $item['storedisplayname'] : $item['itemID'];
                $data['price'] = $item['baseprice'];
                $data['quantity'] = $item['quantityAvailable'] ?? 0;
                $data['description'] = $item['description'];
                $data['short_description'] = $item['storeDetailedDescription'];
                $data['internalid'] = $item['internalID'];
                $data['displayImage'] = $item['displayImage'];
                $data['weight'] = $item['weight'];
                $data['status'] = $item['isonline'] ? 1 : 2;
                $data['cat_class'] = $item['productClass'] ? $item['productClass'] :  '';
                $data['cat_group'] = $item['productGroup'] ? $item['productGroup'] : '';
                $data['cat_subgroup'] = $item['productSubGroup'] ? $item['productSubGroup'] : '';

                array_push($categoryIds,  $this->getProductCategory($data['cat_class'], $data['cat_group'], $data['cat_subgroup']));
                if(isset($items[$key+1]) && ($item['internalID'] == $items[$key+1]['internalID'])) {
                    continue;
                }

                $data['category_ids'] = $categoryIds;
                $productProfile = '';
                foreach($eavOptions as $eavOption) {
                    if($item['profile'] == $eavOption['label']) {
                        $productProfile = $eavOption['value'];
                        break;
                    }
                }
                $customAttributes = [
                    "pg_volume" => $item['volume'],
                    "pg_product_profile" => $productProfile,
                    "pg_weight" => $item['weight'],
                    "pg_weight_unit" => $item['weightunit'],
                    "short_description" => $item['storeDetailedDescription'],
                    "description" => $item['storeDetailedDescription'],
                    "pg_internal_id" => $item['internalID'],
                    "pg_featured_description" => $item['featuredDescription'],
                ];
                $data['customAttributes'] = $customAttributes;

                // get product price matrix
                if(isset($params['priceMatrix'])) {
                    $tirePrices = [];
                    foreach($params['priceMatrix'] as $priceMatrix) {
                        $price = [
                            "cust_group" => $this->getCustomerGroupId($priceMatrix['name']),
                            "price_qty" => $priceMatrix['mincount'] == 0 ? 1 : $priceMatrix['mincount'],
                            "price" => $priceMatrix['unitprice'],
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

                $product = Product::getProductBySku($data['sku']);
                if(!$product) {
                   $product = (new Product)->createProduct($data);
                }else {
                    $product = (new Product)->updateProduct($data, $product);
                }
            }

            return [[
                'product' => $product->getData(),
                'success' => true
            ]];
        } catch (\Exception $e) {
            CustomLogger::webo_custom_logger('update_product', $e->getMessage());
            return [[ 'message' => $e->getMessage(), 'success' => false]];
        }
    }

    public function getCustomerGroupId( $groupName ) {

        $customerGroup = $this->getAllCustomerGroup();
        if($customerGroup) {
            foreach($customerGroup as $customerGroup) {
                if(strtolower($customerGroup['label']) == strtolower($groupName)) {
                    return $customerGroup['value'];
                }
            }
        }

        return 3; //base price group id
    }

    public function getAllCustomerGroup() {
        $objectManager = \Magento\Framework\App\ObjectManager::getInstance();
        $groupOptions = $objectManager->get('\Magento\Customer\Model\ResourceModel\Group\Collection')->toOptionArray();

        return $groupOptions;
    }

    public function getProductCategory($class, $group, $subgroup) {
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
}
