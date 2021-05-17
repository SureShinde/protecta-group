<?php

namespace Dcs\Productenquiry\Helper;

use Magento\Framework\App\Filesystem\DirectoryList;
use Magento\Store\Model\ScopeInterface;

class Data extends \Magento\Framework\App\Helper\AbstractHelper
{
	protected $httpFactory;
    protected $_storeManager;	
	protected $customerSession;	
	protected $inlineTranslation;
    protected $formKey;
    
	const XML_PATH_ENABLE 	  = "productenquiry/view/enabled";
	const XML_PATH_RECIPIENT_EMAIL = "productenquiry/view/recipient_email";
	const XML_PATH_GENERAL_NAME = 'trans_email/ident_general/name';
    const XML_PATH_GENERAL_EMAIL = 'trans_email/ident_general/email';
	
	public function __construct(
        \Magento\Framework\App\Helper\Context $context,
        \Magento\Framework\App\Config\ScopeConfigInterface $scopeConfig,    
        \Magento\Framework\Data\Form\FormKey $formKey,
        \Magento\Framework\HTTP\Adapter\FileTransferFactory $httpFactory,        
        \Magento\Store\Model\StoreManagerInterface $storeManager,		
        \Magento\Customer\Model\Session $customerSession,
		\Magento\Checkout\Model\Session $checkoutSession,
		\Magento\Framework\Translate\Inline\StateInterface $inlineTranslation        
    ) {
        $this->_scopeConfig = $scopeConfig;        
        $this->formKey = $formKey;        
        $this->httpFactory = $httpFactory;        
        $this->_storeManager = $storeManager;        
		$this->_customerSession = $customerSession;
		$this->_checkoutSession = $checkoutSession;
		$this->inlineTranslation = $inlineTranslation;
        parent::__construct($context);
    }
    
	public function getCountTotalEnquiryQty()
	{		
			$qty = 0;
			if($this->_checkoutSession->getEnquiryQuote())
			{
				$newQuoteProductsArray = $this->_checkoutSession->getEnquiryQuote();
				if(count($newQuoteProductsArray)>0)
				{
					foreach($newQuoteProductsArray as $key => $val)
					{
						
						$item = $val;						
						$qty += $item['qty'];
					}
					return $qty;
				}
				else
				{
					return $qty;
				}
			}
			else
			{
				return $qty;
			}
	}
	public function getConfig($config_path)
    {
        return $this->scopeConfig->getValue(
            $config_path,
            \Magento\Store\Model\ScopeInterface::SCOPE_STORE
        );
    }
	
	public function Recipientemail()
    {		
		$storeScope = \Magento\Store\Model\ScopeInterface::SCOPE_STORE;
		return $this->scopeConfig->getValue(self::XML_PATH_RECIPIENT_EMAIL,$storeScope);
    }
	
	public function GeneralName()
	{
		$storeScope = \Magento\Store\Model\ScopeInterface::SCOPE_STORE;
 		return $this->scopeConfig->getValue(self::XML_PATH_GENERAL_NAME, $storeScope);
    }
	
	public function GeneralEmail()
	{
		$storeScope = \Magento\Store\Model\ScopeInterface::SCOPE_STORE;
 		return $this->scopeConfig->getValue(self::XML_PATH_GENERAL_EMAIL, $storeScope);
    }
	
	public function isCustomerLoggedIn()
	{
		 return $this->_customerSession;
	}
}
