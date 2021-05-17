<?php
/**
 * Adminhtml customshippingprice list block
 *
 */
namespace Dcs\CustomShippingPrice\Block\Adminhtml;

class CustomShippingPrice extends \Magento\Backend\Block\Widget\Grid\Container
{
    /**
     * Constructor
     *
     * @return void
     */
    protected function _construct()
    {
		
        $this->_controller = 'adminhtml_customshippingprice';
        $this->_blockGroup = 'Dcs_CustomShippingPrice';
        $this->_headerText = __('CustomShippingPrice');
        $this->_addButtonLabel = __('Add New'); 
		
        parent::_construct();
        if ($this->_isAllowedAction('Dcs_CustomShippingPrice::save')) {
            $this->buttonList->update('add', 'label', __('Sync Freight Cost Matrix'));
        } else {
            $this->buttonList->remove('add');
        }
		//$this->buttonList->remove('add');		
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
