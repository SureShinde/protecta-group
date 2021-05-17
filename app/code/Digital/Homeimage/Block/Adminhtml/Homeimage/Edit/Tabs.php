<?php
namespace Digital\Homeimage\Block\Adminhtml\Homeimage\Edit;
/**
 * Admin page left menu
 */
class Tabs extends \Magento\Backend\Block\Widget\Tabs {
    /**
     * @return void
     */
    protected function _construct() {
        parent::_construct();
        $this->setId('homeimage_tabs');
        $this->setDestElementId('edit_form');
        $this->setTitle(__('Home Image Information'));
    }
}