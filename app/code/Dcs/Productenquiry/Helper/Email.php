<?php
namespace Dcs\Productenquiry\Helper;
 
class Email extends \Magento\Framework\App\Helper\AbstractHelper
{
    
    const XML_PATH_EMAIL_TEMPLATE_FIELD_CUSTOMER  = 'productenquiry/view/email_template';
	const XML_PATH_EMAIL_TEMPLATE_FIELD_ADMIN  = 'productenquiry/view/admin_email';

	protected $_scopeConfig;
 
	protected $_storeManager;
 
    protected $inlineTranslation;
 
    protected $_transportBuilder;
     
    protected $temp_id;
 
    public function __construct(
        \Magento\Framework\App\Helper\Context $context,
        \Magento\Store\Model\StoreManagerInterface $storeManager,
        \Magento\Framework\Translate\Inline\StateInterface $inlineTranslation,
        \Magento\Framework\Mail\Template\TransportBuilder $transportBuilder
    ) {
        $this->_scopeConfig = $context;
        parent::__construct($context);
        $this->_storeManager = $storeManager;
        $this->inlineTranslation = $inlineTranslation;
        $this->_transportBuilder = $transportBuilder; 
    }
 
    
    public function getConfigValue($path, $storeId)
    {
        return $this->scopeConfig->getValue(
            $path,
            \Magento\Store\Model\ScopeInterface::SCOPE_STORE,
            $storeId
        );
    }
   
    public function getStore()
    {
        return $this->_storeManager->getStore();
    }
 
    public function getTemplateId($xmlPath)
    {
        return $this->getConfigValue($xmlPath, $this->getStore()->getStoreId());
    }
 
    public function generateTemplate($emailTemplateVariables,$senderInfo,$receiverInfo)
    {
		$template =  $this->_transportBuilder->setTemplateIdentifier($this->temp_id)
                ->setTemplateOptions(array('area' => \Magento\Framework\App\Area::AREA_FRONTEND,'store' => $this->_storeManager->getStore()->getId()))
                ->setTemplateVars(['data' => $emailTemplateVariables])
                ->setFrom($senderInfo)
                ->addTo($receiverInfo['email'],$receiverInfo['name']);
        return $this;        
    }
 
    public function adminEnquiryMailSendMethod($emailTemplateVariables,$senderInfo,$receiverInfo)
    {
		$this->temp_id = $this->getTemplateId(self::XML_PATH_EMAIL_TEMPLATE_FIELD_ADMIN);
        $this->inlineTranslation->suspend();    
        $this->generateTemplate($emailTemplateVariables,$senderInfo,$receiverInfo);    
        $transport = $this->_transportBuilder->getTransport(); 
        $transport->sendMessage();
        $this->inlineTranslation->resume();
    }
	public function customerMailSendMethod($emailTemplateVariables,$senderInfo,$receiverInfo)
    {
		$this->temp_id = $this->getTemplateId(self::XML_PATH_EMAIL_TEMPLATE_FIELD_CUSTOMER);
        $this->inlineTranslation->suspend();    
        $this->generateTemplate($emailTemplateVariables,$senderInfo,$receiverInfo);    
        $transport = $this->_transportBuilder->getTransport();
        $transport->sendMessage();
        $this->inlineTranslation->resume();
    }
}
