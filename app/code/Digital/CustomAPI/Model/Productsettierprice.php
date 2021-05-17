<?php
namespace Digital\CustomAPI\Model;

class Productsettierprice implements \Digital\CustomAPI\Api\ProductsettierpriceInterface
{	
	/**
      * setproducttierprice function
      *
      * @api
      * @param mixed $param
      * @return array
     */
    
    public function setproducttierprice($param)
    {				
		$result = array();
		$product_id = trim($param['itemId']);
		$product_sku = $param['itemSku'];
		$item_data = $param['data'];	
		
		$tiers = $item_data;
		$website_id = 0;
		
		$objectManager = \Magento\Framework\App\ObjectManager::getInstance();
		
		if($product_id > 0 && $product_sku !='' && count($tiers)>0)
		{			
			$product = $objectManager->create('Magento\Catalog\Model\Product')->load($product_id);
			if($product->getId()>0)
			{
				
					$resource = $objectManager->get('Magento\Framework\App\ResourceConnection');
					$connection = $resource->getConnection();
					$tableName = $resource->getTableName('catalog_product_entity_tier_price');
					
					//Delete old records from table....
					$delete_sql = "Delete FROM " . $tableName." Where entity_id=".$product_id;					
					$connection->query($delete_sql);
				
					foreach($tiers as $item)
					{
						$customerGroupId = trim($item['customerGroupId']);
						$qty = trim($item['qty']);
						$price = trim($item['price']);

						//Insert new records into table...						
						$insert_sql = "INSERT INTO `catalog_product_entity_tier_price` (`value_id`, `entity_id`, `all_groups`, `customer_group_id`, `qty`, `value`, `percentage_value`, `website_id`) VALUES (NULL, '$product_id', '0', '$customerGroupId', '$qty', '$price', NULL, '$website_id')";						
						$connection->query($insert_sql);
					}
				
					$result['status'] = 'success';
			}
			else
			{
				$result['status'] = 'error';	
			}
			
		}
		else
		{
			$result['status'] = 'error';
		}				
		return $result;	
    }	
}