<?php
namespace Digital\Contactus\Block;

class Contactus extends \Magento\Framework\View\Element\Template
{
   
    protected $_dataHelper;
	
	protected $customerSession;
    
    protected function _prepareLayout(){
        return parent::_prepareLayout();
    }
    
    public function __construct(
        \Magento\Framework\View\Element\Template\Context $context,
        \Digital\Contactus\Helper\Data $dataHelper,
		\Magento\Customer\Model\Session $customerSession,
        array $data = []
    ) {
        $this->_dataHelper = $dataHelper;
		$this->customerSession = $customerSession;
        parent::__construct(
            $context,
            $data
        );
    }
	public function isEnabledModule()
    {
		 return $this->_dataHelper->isEnabled();
    }
    
    public function getHelper()
    {
		 return $this->_dataHelper;
    }
	
	public function getFullname()
	{
		return trim($this->customerSession->getCustomer()->getName());
	}
	public function getEmailaddress()
	{
		return trim($this->customerSession->getCustomer()->getEmail());
	}
    
    
}
