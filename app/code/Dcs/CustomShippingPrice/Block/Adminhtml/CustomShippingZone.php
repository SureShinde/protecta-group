<?php
/**
 * Adminhtml customshippingzone list block
 *
 */
namespace Dcs\CustomShippingPrice\Block\Adminhtml;

class CustomShippingZone extends \Magento\Backend\Block\Widget\Grid\Container
{
	
    /**
     * Constructor
     *
     * @return void
     */
    protected function _construct()
    {
		
        $this->_controller = 'adminhtml_customshippingzone';
        $this->_blockGroup = 'Dcs_CustomShippingPrice';
        $this->_headerText = __('CustomShippingZone');
        $this->_addButtonLabel = __('Add New Zone'); 
		
        parent::_construct();		
        if ($this->_isAllowedAction('Dcs_CustomShippingZone::save')) {
            $this->buttonList->update('add', 'label', __('Add New Zone'));
        } else {
            $this->buttonList->remove('add');
        }			
    }
    
    /**
     * Check permission for passed action
     *
     * @param string $resourceId
     * @return bool
     */
    protected function _isAllowedAction($resourceId)
    {
        return $this->_authorization->isAllowed($resourceId);
    }
}
