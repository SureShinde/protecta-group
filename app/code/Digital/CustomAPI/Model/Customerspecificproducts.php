<?php
namespace Digital\CustomAPI\Model;

class Customerspecificproducts implements \Digital\CustomAPI\Api\CustomerspecificproductsInterface
{	
	/**
      * setcustomerspecificproducts function
      *
      * @api
      * @param mixed $param
      * @return array
     */
    
    public function setcustomerspecificproducts($param)
    {				
		$result = array();
		$product_id = '';
		$customerIds = '';
		if(isset($param['productId']))
		{
			$product_id = trim($param['productId']);
		}
		if(isset($param['customerIds']))
		{
			$customerIds = trim($param['customerIds']);
		}

		$objectManager = \Magento\Framework\App\ObjectManager::getInstance();

		if($product_id > 0 && $customerIds !='')
		{
			$resource = $objectManager->get('Magento\Framework\App\ResourceConnection');
			$connection = $resource->getConnection();
			$tableName = $resource->getTableName('restrictproducts');

			//Delete old records from table....
			$delete_sql = "Delete FROM " . $tableName." Where product_id=".$product_id;					
			$connection->query($delete_sql);

			//Insert new record into table...		
			$insert_sql = "INSERT INTO `restrictproducts` (`product_id`, `customers_id`) VALUES ('$product_id', '$customerIds')";						
			$connection->query($insert_sql);
			$result['status'] = 'success';			
		}
		else
		{
			$result['status'] = 'error';			
		}								
		return $result;	
    }	
}