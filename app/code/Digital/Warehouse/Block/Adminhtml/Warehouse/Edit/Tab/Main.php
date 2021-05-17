<?php
namespace Digital\Warehouse\Block\Adminhtml\Warehouse\Edit\Tab;

/**
 * Cms page edit form main tab
 */
class Main extends \Magento\Backend\Block\Widget\Form\Generic implements \Magento\Backend\Block\Widget\Tab\TabInterface
{
    /**
     * @var \Magento\Store\Model\System\Store
     */
    protected $_systemStore;

    /**
     * @param \Magento\Backend\Block\Template\Context $context
     * @param \Magento\Framework\Registry $registry
     * @param \Magento\Framework\Data\FormFactory $formFactory
     * @param \Magento\Store\Model\System\Store $systemStore
     * @param array $data
     */
    public function __construct(
        \Magento\Backend\Block\Template\Context $context,
        \Magento\Framework\Registry $registry,
        \Magento\Framework\Data\FormFactory $formFactory,
        \Magento\Store\Model\System\Store $systemStore,
        array $data = []
    ) {
        $this->_systemStore = $systemStore;
        parent::__construct($context, $registry, $formFactory, $data);
    }

    /**
     * Prepare form
     *
     * @return $this
     */
    protected function _prepareForm()
    {
        /* @var $model \Magento\Cms\Model\Page */
        $model = $this->_coreRegistry->registry('warehouse');

        /*
         * Checking if user have permissions to save information
         */
        if ($this->_isAllowedAction('Digital_Warehouse::save')) {
            $isElementDisabled = false;
			$isDisabled = false;
        } else {
            $isElementDisabled = true;
			$isDisabled = false;
        }

        /** @var \Magento\Framework\Data\Form $form */
        $form = $this->_formFactory->create();

        $form->setHtmlIdPrefix('warehouse_main_');

        $fieldset = $form->addFieldset('base_fieldset', ['legend' => __('Warehouse Information')]);

        if ($model->getId()) {
            $fieldset->addField('warehouse_id', 'hidden', ['name' => 'warehouse_id']);
        }

        $fieldset->addField(
            'warehouse_code',
            'text',
            [
                'name' => 'warehouse_code',
                'label' => __('Warehouse Code'),
                'title' => __('Warehouse Code'),
				'required' => true,                
            ]
        	);
		
		$fieldset->addField(
            'warehouse_name',
            'text',
            [
                'name' => 'warehouse_name',
                'label' => __('Warehouse Name'),
                'title' => __('Warehouse Name'),
				'required' => true,                
            ]
        	);
		
		$fieldset->addField(
            'lng',
            'text',
            [
                'name' => 'lng',
                'label' => __('Longitude'),
                'title' => __('Longitude'),
				'required' => true,                
            ]
        	);
		
		$fieldset->addField(
            'lat',
            'text',
            [
                'name' => 'lat',
                'label' => __('Latitude'),
                'title' => __('Latitude'),
				'required' => true,                
            ]
        	);
		
		
       
		
				
		
		$this->_eventManager->dispatch('adminhtml_warehouse_edit_tab_main_prepare_form', ['form' => $form]);

        $form->setValues($model->getData());
        $this->setForm($form);

        return parent::_prepareForm();
    }

    /**
     * Prepare label for tab
     *
     * @return string
     */
    public function getTabLabel()
    {
        return __('Warehouse Information');
    }

    /**
     * Prepare title for tab
     *
     * @return string
     */
    public function getTabTitle()
    {
        return __('Warehouse Information');
    }

    /**
     * {@inheritdoc}
     */
    public function canShowTab()
    {
        return true;
    }

    /**
     * {@inheritdoc}
     */
    public function isHidden()
    {
        return false;
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
