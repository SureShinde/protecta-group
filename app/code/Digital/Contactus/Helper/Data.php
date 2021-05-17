<?php

/**
 * Contactus data helper
 */
namespace Digital\Contactus\Helper;

use Magento\Framework\App\Filesystem\DirectoryList;
use Magento\Store\Model\ScopeInterface;

class Data extends \Magento\Framework\App\Helper\AbstractHelper
{
    /**
     * Path to store config where count of contactus posts per page is stored
     *
     * @var string
     */
    
	const XML_PATH_ENABLE 	  = "contactus/view/enabled";
	const XML_PATH_SITEKEY   = "contactus/view/recapcha_sitekey";
	const XML_PATH_SECRETKEY = "contactus/view/recapcha_secretkey";
	const XML_PATH_RECIPIENT_EMAIL = "contactus/view/recipient_email";
	const XML_PATH_GENERAL_NAME = 'trans_email/ident_general/name';
    const XML_PATH_GENERAL_EMAIL = 'trans_email/ident_general/email';
	
    protected $httpFactory;
    protected $_storeManager;	
	protected $customerSession;	
	protected $inlineTranslation;
    protected $formKey;
   // protected $_helper;
    
    /**
     * @param \Magento\Framework\App\Helper\Context $context
     */
    public function __construct(
        \Magento\Framework\App\Helper\Context $context,
        \Magento\Framework\App\Config\ScopeConfigInterface $scopeConfig,    
        \Magento\Framework\Data\Form\FormKey $formKey,
        \Magento\Framework\HTTP\Adapter\FileTransferFactory $httpFactory,        
        \Magento\Store\Model\StoreManagerInterface $storeManager,		
        \Magento\Customer\Model\Session $customerSession,
		\Magento\Framework\Translate\Inline\StateInterface $inlineTranslation,
		\Magento\Store\Model\StoreManagerInterface $storeInterface
		//\Digital\Contactus\Helper\Data $helper     
    ) {
        $this->_scopeConfig = $scopeConfig;        
        $this->formKey = $formKey;        
        $this->httpFactory = $httpFactory;        
        $this->_storeManager = $storeManager;        
		$this->_customerSession = $customerSession;
		$this->inlineTranslation = $inlineTranslation;
		$this->_storeInterface = $storeInterface;
		//$this->_helper = $helper;
        parent::__construct($context);
    }
    
   
    public function getFormKey()
	{
		return $this->formKey->getFormKey();
	}
    
	public function isEnabled()
    {		
		$storeScope = \Magento\Store\Model\ScopeInterface::SCOPE_STORE;
		return $this->scopeConfig->isSetFlag(self::XML_PATH_ENABLE,$storeScope);
    }
	public function Sitekey()
    {		
		$storeScope = \Magento\Store\Model\ScopeInterface::SCOPE_STORE;
		return $this->scopeConfig->getValue(self::XML_PATH_SITEKEY,$storeScope);
    }
	public function Secretkey()
    {		
		$storeScope = \Magento\Store\Model\ScopeInterface::SCOPE_STORE;
		return $this->scopeConfig->getValue(self::XML_PATH_SECRETKEY,$storeScope);
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
	
	public function CustomerEmail()
    {	
		return trim($this->_customerSession->getCustomer()->getEmail());		
    }   
    
    public function getCustomerPhone()
    {	
		return trim($this->_customerSession->getCustomer()->getPhone());		
    }	
	
	public function getBaseUrl()
    { 
        $storeId = $this->_storeManager->getDefaultStoreView()->getStoreId();
    	$url = $this->_storeManager->getStore($storeId)->getUrl();
		return $url;
    }
    public function setMessage($status,$message)
	{
		$this->_customerSession->setContactMessageStatus($status);
		 $this->_customerSession->setContactMessage($message);
	}
	public function getContactMessage()
	{
		 return $this->_customerSession->getContactMessage();
	}
	public function getContactMessageStatus()
	{
		 return $this->_customerSession->getContactMessageStatus();
	}
    public function resetSessionMessage(){
		$this->_customerSession->setContactMessageStatus('');
		 $this->_customerSession->setContactMessage('');
	}

	public function getContactusImage(){
        $media_dir =  $this->_storeInterface
            ->getStore()
            ->getBaseUrl(\Magento\Framework\UrlInterface::URL_TYPE_MEDIA);

        return $media_dir.'/Digital/Contactbanner/'.$this->getImageName();
    } 

	public function getImageName(){
        return $this->scopeConfig->getValue('contactus/view/admin_image', \Magento\Store\Model\ScopeInterface::SCOPE_STORE);
    }
}
