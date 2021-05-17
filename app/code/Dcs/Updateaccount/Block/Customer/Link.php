<?php
namespace Dcs\Updateaccount\Block\Customer;
class Link extends \Magento\Framework\View\Element\Html\Link\Current
{
	public function __construct(
        \Magento\Framework\View\Element\Template\Context $context,
        \Magento\Framework\App\DefaultPathInterface $defaultPath,        
        \Magento\Customer\Model\Session $customerSession,
        array $data = []
     ) {         
         $this->_customerSession = $customerSession;
         parent::__construct($context, $defaultPath, $data);
     }

    protected function _toHtml()
    {
       	$customer = $this->_customerSession->getCustomer();
		//if($customer->getGroupId() == 4)
        if($customer->getGroupId() > 0)
		{
            return parent::_toHtml(); 
        }
		else
		{
             return; 
        }
        return;
    }
}
?>
