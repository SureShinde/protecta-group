<?php
namespace Zdcs\Digital\Helper;
class Data extends \Magento\Framework\App\Helper\AbstractHelper{
    protected $scopeConfig;
    const XML_PATH_FACEBOOK_URL = 'zdcs/view/facebook_link';
	const XML_PATH_TWITTER_URL = 'zdcs/view/twitter_link';
	const XML_PATH_GPLUS_URL = 'zdcs/view/googleplus_link';
	const XML_PATH_INSTRAGRAM_URL = 'zdcs/view/instagram_link';
    const XML_PATH_LINKEDIN_URL = 'zdcs/view/linked_in';
    
    
    
    

	public function __construct(
        \Magento\Store\Model\StoreManagerInterface $storeInterface,
        \Magento\Framework\App\Config\ScopeConfigInterface $scopeConfig        
    ){
		$this->_storeInterface = $storeInterface;
        $this->scopeConfig = $scopeConfig;        
	}
   

	/*Get Store Config Path*/
    public function getStoreScope(){
        $storeScope = \Magento\Store\Model\ScopeInterface::SCOPE_STORE;
        return $storeScope;
    }
    /*Get Store Config Path*/
    

    /*Get Social Links*/
    public function getSocialLinks(){
        $storeScope = $this->getStoreScope();
        return array(            
            'facebook' => $this->scopeConfig->getValue(self::XML_PATH_FACEBOOK_URL, $storeScope),
            'twitter' => $this->scopeConfig->getValue(self::XML_PATH_TWITTER_URL, $storeScope),
			'googleplus' => $this->scopeConfig->getValue(self::XML_PATH_GPLUS_URL, $storeScope),
			'instagram' => $this->scopeConfig->getValue(self::XML_PATH_INSTRAGRAM_URL, $storeScope),
			'linkedin' => $this->scopeConfig->getValue(self::XML_PATH_LINKEDIN_URL, $storeScope)         
            
        );        
    }
    /*Get Social Links*/
}
?>