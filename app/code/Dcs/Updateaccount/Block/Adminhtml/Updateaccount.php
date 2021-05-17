<?php
/**
 * Adminhtml updateaccount list block
 *
 */
namespace Dcs\Updateaccount\Block\Adminhtml;

class Updateaccount extends \Magento\Backend\Block\Widget\Grid\Container
{
    /**
     * Constructor
     *
     * @return void
     */
    protected function _construct()
    {
        $this->_controller = 'adminhtml_updateaccount';
        $this->_blockGroup = 'Dcs_Updateaccount';
        $this->_headerText = __('Updateaccount');
        $this->_addButtonLabel = __('Add New Updateaccount Information'); 
        parent::_construct();
        if ($this->_isAllowedAction('Dcs_Updateaccount::save')) {
            $this->buttonList->update('add', 'label', __('Add New Updateaccount Information'));
        } else {
            $this->buttonList->remove('add');
        }$this->buttonList->remove('add');
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
