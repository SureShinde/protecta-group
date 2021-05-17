<?php
namespace Digital\Restrictproducts\Block\Adminhtml;
class Restrictproducts extends \Magento\Backend\Block\Widget\Container {
    /**
     * @var string
     */
    protected $_template = 'restrictproducts/restrictproducts.phtml';
    /**
     * @param \Magento\Backend\Block\Widget\Context $context
     * @param array $data
     */
    public function __construct(\Magento\Backend\Block\Widget\Context $context,array $data = []) {
        parent::__construct($context, $data);
    }
    /**
     * Prepare button and grid
     *
     * @return \Magento\Catalog\Block\Adminhtml\Product
     */
    protected function _prepareLayout() {
        /*$addButtonProps = [
            'id' => 'add_new',
            'label' => __('Add'),
            'class' => 'add',
            'button_class' => '',
            'class_name' => 'Magento\Backend\Block\Widget\Button\SplitButton',
            'options' => $this->_getAddButtonOptions(),
        ];*/
        $addButtonProps = [
            'label' => __('Add Items'),
            'on_click' => sprintf("location.href = '%s';", $this->_getCreateUrl()),
            'class' => 'action-default1 primary add',
        ];
        $this->buttonList->add('add_new', $addButtonProps);
        $this->setChild(
            'grid',
            $this->getLayout()->createBlock('Digital\Restrictproducts\Block\Adminhtml\Restrictproducts\Grid', 'Digital.restrictproducts.grid')
        );
        return parent::_prepareLayout();
    }
	
    /**
     *
     *
     * @return array
     */
    protected function _getAddButtonOptions() {
        $splitButtonOptions[] = [
            'label' => __('Add Items'),
            'onclick' => "setLocation('" . $this->_getCreateUrl() . "')"
        ];
        return $splitButtonOptions;
    }
    /**
     *
     *
     * @param string $type
     * @return string
     */
    protected function _getCreateUrl() {
        return $this->getUrl(
            'restrictproducts/*/new'
        );
    }
    /**
     * Render grid
     *
     * @return string
     */
    public function getGridHtml() {
        return $this->getChildHtml('grid');
    }
}