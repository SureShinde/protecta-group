<?php
/**
 * Adminhtml downloadcatalogue list block
 *
 */
namespace Dcs\Downloadcatalogue\Block\Adminhtml;

class Downloadcatalogue extends \Magento\Backend\Block\Widget\Grid\Container
{
    /**
     * Constructor
     *
     * @return void
     */
    protected function _construct()
    {
        $this->_controller = 'adminhtml_downloadcatalogue';
        $this->_blockGroup = 'Dcs_Downloadcatalogue';
        $this->_headerText = __('Downloadcatalogue');
        $this->_addButtonLabel = __('Add New Resource');
        parent::_construct();
        if ($this->_isAllowedAction('Dcs_Downloadcatalogue::save')) {
            $this->buttonList->update('add', 'label', __('Add New Resource'));
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
