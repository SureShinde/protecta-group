<?php

namespace Digital\Warehouse\Block\Adminhtml;

class Warehouse extends \Magento\Backend\Block\Widget\Grid\Container
{
    protected function _construct()
    {
        $this->_controller = 'adminhtml_warehouse';
        $this->_blockGroup = 'Digital_Warehouse';
        $this->_headerText = __('Warehouse');
        $this->_addButtonLabel = __('Add New Warehouse');
        parent::_construct();
        if ($this->_isAllowedAction('Digital_Warehouse::save')) {
            $this->buttonList->update('add', 'label', __('Add New Warehouse'));
        } else {
            //$this->buttonList->remove('add');
        }
		$this->buttonList->remove('add');
    }
    
    
    protected function _isAllowedAction($resourceId)
    {
        return $this->_authorization->isAllowed($resourceId);
    }
}
