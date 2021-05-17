<?php

namespace Dcs\Productenquiry\Controller\Index;

class Add extends \Magento\Framework\App\Action\Action
{
	protected $_resultJsonFactory;
    
    protected $_dataObjectFactory;
    
    protected $_jsonHelper;
    
    protected $_checkoutSession;
    
	protected $_urlBuilder;
	
    public function __construct(
        \Magento\Framework\App\Action\Context $context,
        \Magento\Framework\Json\Helper\Data $jsonHelper,
     	\Magento\Framework\Controller\Result\JsonFactory $resultJsonFactory,
        \Magento\Framework\DataObjectFactory $dataObjectFactory,
		\Magento\Checkout\Model\Session $checkoutSession,
		\Magento\Framework\UrlInterface $urlBuilder
        
	) {
       
        parent::__construct($context);
        $this->_dataObjectFactory = $dataObjectFactory;
        $this->_jsonHelper = $jsonHelper;
		$this->_resultJsonFactory = $resultJsonFactory;
		$this->_checkoutSession = $checkoutSession;
		$this->_urlBuilder = $urlBuilder;
    }
	
    public function execute()
    {
		$result = array();
		
    	$prod_id = $this->getRequest()->getParam('prod_id');
    	$parentid = $this->getRequest()->getParam('parentid');
    	$prod_qty = $this->getRequest()->getParam('prod_qty');
    	$name = $this->getRequest()->getParam('name');
    	$parenturl = $this->getRequest()->getParam('parenturl');
    	$sku = $this->getRequest()->getParam('sku');
        
		try
		{
			if($prod_id!='' && $parentid!='')
			{		
					if($this->_checkoutSession->getEnquiryQuote())
					{
						$newQuoteProductsArray = $this->_checkoutSession->getEnquiryQuote();
					}
					else
					{
						$newQuoteProductsArray = array();
					}

					if (array_key_exists($prod_id.$parentid,$newQuoteProductsArray))
					{
							$getData = $newQuoteProductsArray[$prod_id.$parentid];
							$getData['qty'] += $prod_qty;
							$newQuoteProductsArray[$prod_id.$parentid] = $getData;
					}
					else
					{
						$newQuoteProductsArray[$prod_id.$parentid] = 
														array(
																'product_id' => $prod_id,
																'parentid' =>$parentid,
																'qty'=> $prod_qty,
																'name'=> $name,
																'parenturl'=> $parenturl,
																'sku'=> $sku
															 );
					}

					if(count($newQuoteProductsArray))
					{
					   $this->_checkoutSession->setEnquiryQuote($newQuoteProductsArray);
					}
					//$result = $this->_urlBuilder->getUrl().'productenquiry/index/index';
				
					$message = __(
                            'You added %1 to your enquiry.',
                            $name
                        );
				
					$result = [
						'status' => 'success',
						'message' => $message,
					];
			}
			else
			{
					$result = [
						'status' => 'error',
						'message' => 'error',
					];
			}
		}
		catch (\Exception $e)
		{
               $result = [
					'status' => 'error',
					'message' => 'error',
				];
          }
		$resultJson = $this->_resultJsonFactory->create();
        return $resultJson->setData($result);
    }
	
}
