<?php
namespace Digital\Restrictproducts\Observer;

use Magento\Framework\Event\ObserverInterface;

class RestrictProductView implements ObserverInterface
{
	private $_objectManager;
	protected $_responseFactory;
    protected $_url;

	public function __construct(			
		\Digital\Restrictproducts\Helper\Data $helper,
		\Magento\Framework\ObjectManagerInterface $_objectManager,
		\Magento\Framework\App\ResponseFactory $responseFactory,
    	\Magento\Framework\UrlInterface $url,
    	\Magento\Framework\Controller\Result\ForwardFactory $forwardFactory
	) {
		$this->restricthelper = $helper;
		$this->_objectManager = $_objectManager;
		$this->_responseFactory = $responseFactory;
    	$this->_url = $url;
    	$this->_forwardFactory = $forwardFactory;	
	}

	public function execute(\Magento\Framework\Event\Observer $observer)
    {     	    	
        $_product = $observer->getProduct();        
        $product_id = $_product->getId();

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
		}
		$customer_id = $this->restricthelper->LoginCustomerId();		
		if($_product->getTypeId() == "grouped"):
			$productsid = $_product->getTypeInstance(true)->getAssociatedProducts($_product);
				$groupids=array();
        		foreach($productsid as $p):
            		$groupids[] = $p->getId();
        		endforeach;        		
        		if(count($groupids)<=0){        			
        			$resultForward = $this->_forwardFactory->create();
				    $resultForward->setController('index');
				    $resultForward->forward('defaultNoRoute');
				    return $resultForward;
        		}     			
        endif;
		
		
		/*echo $customer_id;
		echo '<pre>'; echo $product_id;
		echo '<pre>'; print_r($restricts_products); exit;*/
		
		if (in_array($product_id, $restricts_products)) 
		{
			if($customer_id > 0) //// login
			{
				$cust_product_sql = "SELECT * FROM " . $tableName. " Where FIND_IN_SET(".$customer_id.",customers_id) AND product_id=".$product_id."";
				$cust_product_result = $connection->fetchAll($cust_product_sql);
				if(count($cust_product_result)>0)
	    		{
	    			return $this;
	    		}
	    		else
	    		{
	    			$resultForward = $this->_forwardFactory->create();
				    $resultForward->setController('index');
				    $resultForward->forward('defaultNoRoute');
				    return $resultForward;
	    		}	
			}
			else
	    	{
    			$resultForward = $this->_forwardFactory->create();
			    $resultForward->setController('index');
			    $resultForward->forward('defaultNoRoute');
			    return $resultForward;
	    	}	
			
		}
		/*else
		{
			echo 'else'; exit;
		}	*/
        return $this;
    }
}