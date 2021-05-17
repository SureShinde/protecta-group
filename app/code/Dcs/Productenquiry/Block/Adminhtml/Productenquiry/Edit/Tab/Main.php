<?php
namespace Dcs\Productenquiry\Block\Adminhtml\Productenquiry\Edit\Tab;

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
        $model = $this->_coreRegistry->registry('productenquiry');

        /*
         * Checking if user have permissions to save information
         */
        if ($this->_isAllowedAction('Dcs_Productenquiry::save')) {
            $isElementDisabled = false;	
        } else {
            $isElementDisabled = true;
        }

        /** @var \Magento\Framework\Data\Form $form */
        $form = $this->_formFactory->create();

        $form->setHtmlIdPrefix('productenquiry_main_');

        $fieldset = $form->addFieldset('base_fieldset', ['legend' => __('Product Enquiry')]);

        if ($model->getId()) {
            $fieldset->addField('enquiry_id', 'hidden', ['name' => 'enquiry_id']);
        }
		
		if ($model->getFullname()) {
		$fieldset->addField(
            'fullname',
            'label',
            [
                'name' => 'fullname',
                'label' => __('Full Name :'),
                'title' => __('Full Name :'),
                'disabled' => $isElementDisabled
            ]
        );
		}
		
		if ($model->getCompany()) {
		$fieldset->addField(
            'company',
            'label',
            [
                'name' => 'company',
                'label' => __('Company :'),
                'title' => __('Company :'),
                'disabled' => $isElementDisabled
            ]
        );
		}
		
		if ($model->getEmail()) {
		$fieldset->addField(
            'email',
            'label',
            [
                'name' => 'email',
                'label' => __('Email :'),
                'title' => __('Email :'),
                'disabled' => $isElementDisabled
            ]
        );
		}
        
		if ($model->getPhone()) {
		$fieldset->addField(
            'phone',
            'label',
            [
                'name' => 'phone',
                'label' => __('Phone :'),
                'title' => __('Phone :'),
                'disabled' => $isElementDisabled
            ]
        );
		}
		
		
		if ($model->getProducts()) {
		$fieldset->addType(
            'htmldata',
            '\Dcs\Productenquiry\Block\Adminhtml\Productenquiry\Renderer\Productsedit'
        );
		
		$fieldset->addField(
            'products',
            'htmldata',
            [
                'name' => 'products',
                'label' => __('Products :'),
                'title' => __('Products :'),
                'disabled' => $isElementDisabled
            ]
        );
		}	
			
		if ($model->getComment()) {
		$fieldset->addField(
            'comment',
            'label',
            [
                'name' => 'comment',
                'label' => __('Comment :'),
                'title' => __('Comment :'),
                'disabled' => $isElementDisabled
            ]
        );
		}
		
        
        $this->_eventManager->dispatch('adminhtml_productenquiry_edit_tab_main_prepare_form', ['form' => $form]);

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
        return __('Product Enquiry Details');
    }

    /**
     * Prepare title for tab
     *
     * @return string
     */
    public function getTabTitle()
    {
        return __('Product Enquiry Details');
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
