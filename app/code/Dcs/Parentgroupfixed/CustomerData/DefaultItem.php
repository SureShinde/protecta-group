<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */

namespace Dcs\Parentgroupfixed\CustomerData;

use Magento\Customer\CustomerData\SectionSourceInterface;

/**
 * Default item
 */
class DefaultItem extends  \Magento\Checkout\CustomerData\DefaultItem
{
    protected function doGetItemData()
    {
  		$objectManager = \Magento\Framework\App\ObjectManager::getInstance();
		$resource = $objectManager->get('Magento\Framework\App\ResourceConnection');
		$connection = $resource->getConnection();
		$sql = "SELECT parent_id FROM `catalog_product_relation` where `child_id` =".$this->item->getProduct()->getId();
		$result = $connection->fetchAll($sql);
		if(isset($result[0]['parent_id']) && (int)$result[0]['parent_id'] > 0 )
		{
			$parentProduct = $objectManager->create('Magento\Catalog\Model\Product')->load($result[0]['parent_id']);
			$parentUrl	   = $parentProduct->getUrlModel()->getUrl($parentProduct);
			$imageHelper = $this->imageHelper->init($this->getProductForThumbnail(), 'mini_cart_product_thumbnail');
		}
		else
		{
			$parentUrl	   = $this->getProductUrl();
			$imageHelper = $this->imageHelper->init($this->getProductForThumbnail(), 'mini_cart_product_thumbnail');
		}
        return [
            'options' => $this->getOptionList(),
            'qty' => $this->item->getQty() * 1,
            'item_id' => $this->item->getId(),
            'configure_url' => $this->getConfigureUrl(),
            'is_visible_in_site_visibility' => $this->item->getProduct()->isVisibleInSiteVisibility(),
            'product_id' => $this->item->getProduct()->getId(),
            'product_name' => $this->item->getProduct()->getName(),
            'product_sku' => $this->item->getProduct()->getSku(),
            'product_url' => $parentUrl,
            'product_has_url' => $this->hasProductUrl(),
            'product_price' => $this->checkoutHelper->formatPrice($this->item->getCalculationPrice()),
            'product_price_value' => $this->item->getCalculationPrice(),
            'product_image' => [
                'src' => $imageHelper->getUrl(),
                'alt' => $imageHelper->getLabel(),
                'width' => $imageHelper->getWidth(),
                'height' => $imageHelper->getHeight(),
            ],
            'canApplyMsrp' => $this->msrpHelper->isShowBeforeOrderConfirm($this->item->getProduct())
                && $this->msrpHelper->isMinimalPriceLessMsrp($this->item->getProduct()),
        ];
    }
}
