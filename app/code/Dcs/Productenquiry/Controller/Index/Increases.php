<?php

namespace Dcs\Productenquiry\Controller\Index;

class Increases extends \Magento\Framework\App\Action\Action
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
    	$enquiryid = $this->getRequest()->getParam('products');
		if($this->_checkoutSession->getEnquiryQuote())
		{
			$newQuoteProductsArray = $this->_checkoutSession->getEnquiryQuote();
			
			if (array_key_exists($enquiryid,$newQuoteProductsArray))
			{
		 		$getData = $newQuoteProductsArray[$enquiryid];
				$getData['qty'] += 1;
				$newQuoteProductsArray[$enquiryid] = $getData;
			}
			if(count($newQuoteProductsArray))
			{
			   $this->_checkoutSession->setEnquiryQuote($newQuoteProductsArray);
			   $result = $this->_urlBuilder->getUrl().'productenquiry/index/index';
			}
			else
			{
				$result = $this->_urlBuilder->getUrl();
			}
		}
   		$resultJson = $this->_resultJsonFactory->create();
        return $resultJson->setData($result);
    }
	
}
