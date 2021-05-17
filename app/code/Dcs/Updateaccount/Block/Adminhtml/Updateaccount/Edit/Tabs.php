<?php
namespace Dcs\Updateaccount\Block\Adminhtml\Updateaccount\Edit;

/**
 * Admin updateaccount left menu
 */
class Tabs extends \Magento\Backend\Block\Widget\Tabs
{
    /**
     * @return void
     */
    protected function _construct()
    {
        parent::_construct();
        $this->setId('page_tabs');
        $this->setDestElementId('edit_form');
        $this->setTitle(__('Account Update Request Information'));
    }
}
