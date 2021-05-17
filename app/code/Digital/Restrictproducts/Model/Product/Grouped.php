<?php
namespace Digital\Restrictproducts\Model\Product;
use Magento\Catalog\Api\ProductRepositoryInterface;
class Grouped extends \Magento\GroupedProduct\Model\Product\Type\Grouped
{

	public function getAssociatedProducts($product)
    {
        if (!$product->hasData($this->_keyAssociatedProducts)) {
            $associatedProducts = [];

            $this->setSaleableStatus($product);

            $collection = $this->getAssociatedProductCollection(
                $product
            )->addAttributeToSelect(
                ['name', 'price', 'special_price', 'special_from_date', 'special_to_date', 'tax_class_id', 'image']
            )->addFilterByRequiredOptions()->setPositionOrder()->addStoreFilter(
                $this->getStoreFilter($product)
            )->addAttributeToFilter(
                'status',
                ['in' => $this->getStatusFilters($product)]
            );
            /* custom code heree*/
            $groupids=array();
            foreach ($collection as $item) {
            	$groupids[]=$item->getId();
            }
            $objectManager = \Magento\Framework\App\ObjectManager::getInstance();

            $helper=$objectManager->get('Digital\Restrictproducts\Helper\Data');
            $customer_id = $helper->LoginCustomerId();
            if(!$customer_id){
            	$customer_id=0;
            }
            /*echo "<pre>";
            print_r($groupids);
            die();*/
            if(count($groupids)>0){
                $resource = $objectManager->get('Magento\Framework\App\ResourceConnection');
                $connection = $resource->getConnection();
    			$tableName = $resource->getTableName('restrictproducts');
    			$product_sql = "SELECT product_id FROM " . $tableName. " where product_id IN (".implode(',',$groupids).")";			
    			$product_result = $connection->fetchAll($product_sql);	
    			$restricts_products=array();			
    			if(count($product_result)>0)
    			{				
    				if($customer_id>0){
                        $cust_product_sql = "SELECT * FROM " . $tableName. " Where FIND_IN_SET(".$customer_id.",customers_id) AND product_id IN (".implode(',',$groupids).")";
                        $cust_product_result = $connection->fetchAll($cust_product_sql);
                        foreach ($cust_product_result as $product_record) {
                            $restricts_products[] = $product_record['product_id'];
                        }	
                        if(count($restricts_products)>0){
                            foreach ($collection as $item) {                                                    
                                //if (!in_array($item->getId(), $restricts_products)){
                                 $associatedProducts[] = $item;
                                //}
                            }

                        }else{								
        					foreach ($product_result as $product_record) {
                                $grestricts_products[] = $product_record['product_id'];
                            }                           
                            foreach ($collection as $item) {                                                    
                                if (!in_array($item->getId(), $grestricts_products)){
                                 $associatedProducts[] = $item;
                                }
                            }
                        }
    				}else{		
    					foreach ($product_result as $product_record) {
    						$grestricts_products[] = $product_record['product_id'];
    					}							
    					foreach ($collection as $item) {  							  						
    						if (!in_array($item->getId(), $grestricts_products)){
    	                		$associatedProducts[] = $item;
    	                	}
    	            	}	
    				}	
    			}else{
    				foreach ($collection as $item) {       						
                    	$associatedProducts[] = $item;            	
                	}	
    			}
        }else{
            foreach ($collection as $item) {                            
                $associatedProducts[] = $item;              
            }
        }        
            $product->setData($this->_keyAssociatedProducts, $associatedProducts);
        }
        return $product->getData($this->_keyAssociatedProducts);
    }
}