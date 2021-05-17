<?php

namespace Digital\Warehouse\Block\Cart;

class Crosssell extends \Magento\Checkout\Block\Cart\Crosssell
{

  /**
    * Crosssell constructor.
    * @param \Magento\Catalog\Block\Product\Context $context
    * @param \Magento\Checkout\Model\Session $checkoutSession
    * @param \Magento\Catalog\Model\Product\Visibility $productVisibility
    * @param \Magento\Catalog\Model\Product\LinkFactory $productLinkFactory
    * @param \Magento\Quote\Model\Quote\Item\RelatedProducts $itemRelationsList
    * @param \Magento\CatalogInventory\Helper\Stock $stockHelper
    * @param array $data
    */
   public function __construct(
       \Magento\Catalog\Block\Product\Context $context,
       \Magento\Checkout\Model\Session $checkoutSession,
       \Magento\Catalog\Model\Product\Visibility $productVisibility,
       \Magento\Catalog\Model\Product\LinkFactory $productLinkFactory,
       \Magento\Quote\Model\Quote\Item\RelatedProducts $itemRelationsList,
       \Magento\CatalogInventory\Helper\Stock $stockHelper,
       array $data = []
   ) {
       parent::__construct(
           $context,
           $checkoutSession,
           $productVisibility,
           $productLinkFactory,
           $itemRelationsList,
           $stockHelper,
           $data
       );       
   }
   
   
   protected function _getCollection()
    {
		
		$visibility_array = array(2,4,3);
		
        /** @var \Magento\Catalog\Model\ResourceModel\Product\Link\Product\Collection $collection */
        $collection = $this->_productLinkFactory->create()->useCrossSellLinks()->getProductCollection()->setStoreId(
            $this->_storeManager->getStore()->getId()
        )->addStoreFilter()->setPageSize(
            $this->_maxItemCount
        )->setVisibility(
            //$this->_productVisibility->getVisibleInCatalogIds()
			$visibility_array
        );

        $this->_addProductAttributesAndPrices($collection);

        return $collection;
    }
   
}