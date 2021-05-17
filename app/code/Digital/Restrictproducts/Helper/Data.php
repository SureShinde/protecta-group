<?php 
namespace Digital\Restrictproducts\Helper;
 
class Data extends \Magento\Framework\App\Helper\AbstractHelper
{ 
     
    protected $customerSession;
    
    public function __construct(
        \Magento\Framework\App\Helper\Context $context,        
        \Magento\Customer\Model\Session $customerSession        
    ) {
        $this->_customerSession = $customerSession;        
        parent::__construct($context);
    }

    public function LoginCustomerId()
    {   
        return trim($this->_customerSession->getCustomer()->getId());        
    }
    

    
}