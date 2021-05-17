<?php
namespace Digital\Homebanner\Block\Adminhtml\Homebanner\Edit;

/**
 * Admin page left menu
 */
class Tabs extends \Magento\Backend\Block\Widget\Tabs
{
    /**
     * @return void
     */
    protected function _construct()
    {
        parent::_construct();
        $this->setId('homebanner_tabs');
        $this->setDestElementId('edit_form');
        $this->setTitle(__('Home Banner Information'));
    }
}