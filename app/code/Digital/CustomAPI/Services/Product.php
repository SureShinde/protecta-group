<?php

namespace Digital\CustomAPI\Services;

use Digital\CustomAPI\Helper\CustomLogger;

class Product {

    public function createProduct($data) {
       return $this->insertOrUpdateProduct($data);
    }

    public function updateProduct( $product, $data ) {
        return $this->insertOrUpdateProduct($product, $data);
    }

    public function insertOrUpdateProduct($data, $product = null) {
        CustomLogger::webo_custom_logger('update_product', $data);
        if(!$product) {
            $objectManager = \Magento\Framework\App\ObjectManager::getInstance();
            $product = $objectManager->create('\Magento\Catalog\Model\Product');
        }

        $product->setSku($data['sku']);
        $product->setName($data['name']);
        $product->setAttributeSetId(4);
        $product->setStatus($data['status']);
        $product->setVisibility(4);
        $product->setTaxClassId(2);
        $product->setTypeId('simple');
        $product->setPrice($data['price']);
        $product->setWebsiteIds(array(1));
        $product->setUrlKey($data['sku']);
        $product->setWeight($data['weight']);
        $product->setDescription($data['description']);
        $product->setShortDescription($data['short_description']);
        $product->setStockData(
            array(
                'use_config_manage_stock' => 0,
                'manage_stock' => 1,
                'is_in_stock' => $data['quantity'] != 0 ? true: false,
                'qty' => $data['quantity']
            )
        );

        if(isset($data['category_ids'])) {
            $product->setCategoryIds($data['category_ids']);
        }

        if(isset($data['tier_prices'])) {
            $product->setTierPrice($data['tier_prices']);
        }

        foreach($data['customAttributes'] as $key => $value) {
            $product->setCustomAttribute($key, $value);
        }

        if($data['displayImage']) {
            $product = $this->addProductImage($data, $product);
        }

        // $product->save();
        $product->getResource()->save($product);
        return $product;
    }

    public function addProductImage( $data,  $product) {
        try {
            $objectManager = \Magento\Framework\App\ObjectManager::getInstance();
            $productGallery = $objectManager->create('Magento\Catalog\Model\ResourceModel\Product\Gallery');

            // Unset existing images
            $images = $product->getMediaGalleryImages();
            if(count($images) > 0) {
                foreach($images as $child) {
                    $productGallery->deleteGallery($child->getValueId());
                }
                $product->setMediaGalleryEntries([]);
            }

            $image_url  = $data['displayImage'];
            $image_type = '.png';
            $filename   = $data['sku'].$image_type;
            $filepath   = './pub/media/'.$filename;
            file_put_contents($filepath, file_get_contents(trim($image_url)));

            $product->addImageToMediaGallery($filename, array('image', 'small_image', 'thumbnail'), false, false);

            if(is_file($filepath)) {
                unlink($filepath);
            }

        } catch (\Exception $e) {
            CustomLogger::webo_custom_logger('add_image_exception', $e->getMessage());
        }

        return $product;
    }

    public static function getProductBySku( $sku )
    {
        try {
            $objectManager = \Magento\Framework\App\ObjectManager::getInstance();

            $productRepository = $objectManager->get('\Magento\Catalog\Model\ProductRepository');

            $productObj = $productRepository->get($sku);
            // load product by sku in edit mode from global store and force relod
            $productObj = $productRepository->get($sku, true, 0, true);
            // return $productObj;
        } catch (\Throwable $th) {

            return false;
        }
    }

}
