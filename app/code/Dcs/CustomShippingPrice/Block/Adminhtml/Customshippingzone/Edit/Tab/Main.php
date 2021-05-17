<?php
namespace Dcs\CustomShippingPrice\Block\Adminhtml\Customshippingzone\Edit\Tab;

/**
 * Cms page edit form main tab
 */
class Main extends \Magento\Backend\Block\Widget\Form\Generic implements \Magento\Backend\Block\Widget\Tab\TabInterface
{
    /**
     * @var \Magento\Store\Model\System\Store
     */
    protected $_systemStore;
	protected $urlBuider;

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
		\Magento\Framework\UrlInterface $urlBuilder,
        array $data = []
    ) {
        $this->_systemStore = $systemStore;
		$this->urlBuilder = $urlBuilder;
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
        $model = $this->_coreRegistry->registry('customshippingzone');

       

        /** @var \Magento\Framework\Data\Form $form */
        $form = $this->_formFactory->create();

        $form->setHtmlIdPrefix('customshippingzone_main_');

        $fieldset = $form->addFieldset('base_fieldset', ['legend' => __('Digital Shipping Zone Information')]);

        if ($model->getId()) {
            $fieldset->addField('id', 'hidden', ['name' => 'id']);
        }
		
		$fieldset->addField(
            'zone',
            'text',
            [
                'name' => 'zone',
                'label' => __('Zone'),
                'title' => __('Zone'),
				'required' => true                
            ]
        );
		
		$fieldset->addField(
            'nsw',
            'text',
            [
                'name' => 'nsw',
                'label' => __('NSW'),
                'title' => __('NSW')               
            ]
        );
		
		$fieldset->addField(
            'qld',
            'text',
            [
                'name' => 'qld',
                'label' => __('QLD'),
                'title' => __('QLD')               
            ]
        );
		
		$fieldset->addField(
            'vic',
            'text',
            [
                'name' => 'vic',
                'label' => __('VIC'),
                'title' => __('VIC')               
            ]
        );
		
		$fieldset->addField(
            'wa',
            'text',
            [
                'name' => 'wa',
                'label' => __('WA'),
                'title' => __('WA')               
            ]
        );
		
        
        $this->_eventManager->dispatch('adminhtml_customshippingzone_edit_tab_main_prepare_form', ['form' => $form]);

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
        return __('Digital Shipping Zone Information');
    }

    /**
     * Prepare title for tab
     *
     * @return string
     */
    public function getTabTitle()
    {
        return __('Digital Shipping Zone Information');
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
