<?php
namespace Dcs\Updateaccount\Block\Adminhtml\Updateaccount\Edit\Tab;

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
        $model = $this->_coreRegistry->registry('updateaccount');

        /*
         * Checking if user have permissions to save information
         */
        if ($this->_isAllowedAction('Dcs_Updateaccount::save')) {
            $isElementDisabled = false;	
        } else {
            $isElementDisabled = true;
        }

        /** @var \Magento\Framework\Data\Form $form */
        $form = $this->_formFactory->create();

        $form->setHtmlIdPrefix('updateaccount_main_');

        $fieldset = $form->addFieldset('base_fieldset', ['legend' => __('Account Update Request Information')]);

        if ($model->getId()) {
            $fieldset->addField('updateaccount_id', 'hidden', ['name' => 'updateaccount_id']);
        }
		$fieldset->addField(
            'customer_name',
            'label',
            [
                'name' => 'customer_name',
                'label' => __('Customer Name :'),
                'title' => __('Customer Name :'),
                'disabled' => $isElementDisabled
            ]
        );
        $fieldset->addField(
            'customer_company',
            'label',
            [
                'name' => 'customer_company',
                'label' => __('Company Name :'),
                'title' => __('Company Name :'),
                'disabled' => $isElementDisabled
            ]
        );
        
		/*$fieldset->addField(
            'customer_code',
            'label',
            [
                'name' => 'customer_code',
                'label' => __('Customer Code :'),
                'title' => __('Customer Code :'),
                'disabled' => $isElementDisabled
            ]
        );*/

        

        $fieldset->addField(
            'customer_email',
            'label',
            [
                'name' => 'customer_email',
                'label' => __('Customer Email :'),
                'title' => __('Customer Email :'),
                'disabled' => $isElementDisabled
            ]
        );
        $fieldset->addField(
            'request_type',
            'label',
            [
                'name' => 'request_type',
                'label' => __('Enquiry Type :'),
                'title' => __('Enquiry Type:'),
                'disabled' => $isElementDisabled
            ]
        );
        
        $fieldset->addField(
            'request_content',
            'label',
            [
                'name' => 'request_content',
                'label' => __('New Information :'),
                'title' => __('New Information:'),
                'disabled' => $isElementDisabled
            ]
        );
        /*$fieldset->addField(
            'action_required',
            'label',
            [
                'name' => 'action_required',
                'label' => __('Action :'),
                'title' => __('Action :'),
                'options' => \Dcs\Updateaccount\Block\Adminhtml\Updateaccount\Grid::getOptionArray3(),
                'disabled' => $isElementDisabled
            ]
        );*/
        $this->_eventManager->dispatch('adminhtml_updateaccount_edit_tab_main_prepare_form', ['form' => $form]);

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
        return __('Account Update Request Information');
    }

    /**
     * Prepare title for tab
     *
     * @return string
     */
    public function getTabTitle()
    {
        return __('Account Update Request Information');
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
