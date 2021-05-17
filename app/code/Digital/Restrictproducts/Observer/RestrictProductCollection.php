<?php
namespace Digital\Restrictproducts\Observer;

use Magento\Framework\Event\ObserverInterface;

class RestrictProductCollection implements ObserverInterface
{
	private $_objectManager;

	public function __construct(			
			\Digital\Restrictproducts\Helper\Data $helper,
			\Magento\Framework\ObjectManagerInterface $_objectManager
		) {
			$this->restricthelper = $helper;
			$this->_objectManager = $_objectManager;		
	}
	public function execute(\Magento\Framework\Event\Observer $observer)
    {

    	$restricts_products = array();
		$resource = $this->_objectManager->get('Magento\Framework\App\ResourceConnection');
		$connection = $resource->getConnection();
		$tableName = $resource->getTableName('restrictproducts');
		$product_sql = "SELECT product_id FROM " . $tableName;
		$product_result = $connection->fetchAll($product_sql);		
		if(count($product_result)>0)
		{
			foreach ($product_result as $product_record) {
				$restricts_products[] = $product_record['product_id'];
			} 
            $childaddtoParent=$this->getGroupCollection($restricts_products,false);
                if(count($childaddtoParent)>0){
                    foreach ($childaddtoParent as $i) {
                            $restricts_products[] = $i;
                    }
                }     
		}        
		$collection = $observer->getEvent()->getCollection();
		$customer_id = $this->restricthelper->LoginCustomerId();
    	if($customer_id > 0) /// login
    	{
    		$cust_sql = "SELECT product_id FROM " . $tableName. " Where FIND_IN_SET(".$customer_id.",customers_id)";
			$cust_result = $connection->fetchAll($cust_sql);
    		if(count($cust_result)>0)
    		{
    			//$login_prod_rest = $childaddtoParent;
                $login_prod_rest = array();               
    			foreach ($cust_result as $cust_record) {
    				$login_prod_rest[] = $cust_record['product_id'];		
    			}
                $newchildaddtoParent=$this->getGroupCollection($login_prod_rest,false);                 
                
                if(count($newchildaddtoParent)>0){                                                
                       foreach ($newchildaddtoParent as $i) {
                            $login_prod_rest[] = $i;               
                        }    
                }else{
                        $snewchildaddtoParent=$this->getGroupCollection($login_prod_rest,true);                        
                        foreach ($snewchildaddtoParent as $i) {
                            $login_prod_rest[] = $i;               
                        }
                }         
                
                $customer_final_array = array_diff($restricts_products, $login_prod_rest);   
                //exit;                            
                 /*echo "<pre>";
                print_r($childaddtoParent);
                print_r($login_prod_rest);
                print_r($restricts_products);
                print_r($customer_final_array);
                print_r($newchildaddtoParent);
                
                exit;*/
    			if(count($customer_final_array)>0)
    			{    
    				$collection->addAttributeToFilter('entity_id', ['nin' => $customer_final_array]);
    			}           
    			
    		}
    		else  //// not found customer id in table
    		{
                
    			if(count($restricts_products)>0)
    			{
    				$collection->addAttributeToFilter('entity_id', ['nin' => $restricts_products]);
    			}
    		}
    	}
    	else  ///// not login
    	{ 
    		if(count($restricts_products)>0)
    		{
                $collection->addAttributeToFilter('entity_id', ['nin' => $restricts_products]);                
    		}
    	}        
        return $this;
    }
    public function getGroupCollection($restricts_products,$customer)
    {
        /*Group Product Secection*/          
        $groupQuery = "SELECT product_id FROM `catalog_product_link` Where link_type_id=3 AND linked_product_id IN (".implode(',',$restricts_products).") Group By product_id";
        $resource = $this->_objectManager->get('Magento\Framework\App\ResourceConnection');
        $connection = $resource->getConnection();           
        $groupQuery_result = $connection->fetchAll($groupQuery);            
        $childaddtoParent=array();
        if(count($groupQuery_result)>0){
            foreach ($groupQuery_result as $product_records) {
            $group_product[] = $product_records['product_id'];                
        }            
            $childgroupQuery = "SELECT * FROM `catalog_product_link` Where link_type_id=3 AND product_id IN (".implode(',',$group_product).")";        
            $childgroupQuery_result = $connection->fetchAll($childgroupQuery);
            // var_dump($childgroupQuery_result);
            // die();
            if(count($childgroupQuery_result)>0)
            {
                foreach ($childgroupQuery_result as $chproduct_records) {
                    $chgroup_product[$chproduct_records['product_id']][] = $chproduct_records['linked_product_id'];            
                }
                if($customer){
                    foreach ($chgroup_product as $key => $value) {                             
                        $result=array_intersect($chgroup_product[$key],$restricts_products);
                        if(count($chgroup_product[$key])!=count($result)){
                            $childaddtoParent[]=$key;
                        }
                    }
                }else{
                    foreach ($chgroup_product as $key => $value) {                             
                        $result=array_intersect($chgroup_product[$key],$restricts_products);
                        if(count($chgroup_product[$key])==count($result)){
                            $childaddtoParent[]=$key;
                        }
                    }
                }                       
            }
        }        
        return   $childaddtoParent;
    }
}