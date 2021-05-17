<?php

namespace Digital\Contactus\Block\Adminhtml;

class Contactus extends \Magento\Backend\Block\Widget\Grid\Container
{
    protected function _construct()
    {
        $this->_controller = 'adminhtml_contactus';
        $this->_blockGroup = 'Digital_Contactus';
        $this->_headerText = __('Contact Us');
        $this->_addButtonLabel = __('Add New Contact Us');
        parent::_construct();
        if ($this->_isAllowedAction('Digital_Contactus::save')) {
            $this->buttonList->update('add', 'label', __('Add New Contact Us'));
        } else {
            $this->buttonList->remove('add');
        }
		$this->buttonList->remove('add');
    }
    
    
    protected function _isAllowedAction($resourceId)
    {
        return $this->_authorization->isAllowed($resourceId);
    }
}
