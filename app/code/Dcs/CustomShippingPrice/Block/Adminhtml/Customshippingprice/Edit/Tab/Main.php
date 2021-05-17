<?php
namespace Dcs\CustomShippingPrice\Block\Adminhtml\Customshippingprice\Edit\Tab;

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
        $model = $this->_coreRegistry->registry('customshippingprice');

       

        /** @var \Magento\Framework\Data\Form $form */
        $form = $this->_formFactory->create();

        $form->setHtmlIdPrefix('customshippingprice_main_');

        $fieldset = $form->addFieldset('base_fieldset', ['legend' => __('Digital Shipping Method Information')]);

        if ($model->getId()) {
            $fieldset->addField('id', 'hidden', ['name' => 'id']);
        }
		
		$url = $this->urlBuilder->getUrl('customshippingprice/index/csvdownload/', $paramsHere = array());
		
		$fieldset->addField(
            'csv_file',
            'image',
            [
                'name' => 'csv_file',
                'label' => __('CSV File'),
                'title' => __('CSV File'),				
                'required'  => true,
                'note' => '<br>A file name not contain any space or special characters.
										<span id="sample-file-span">'
                                    . '<a id="sample-file-link" href="'. $url .'">'
                                    . __('Download Sample CSV File')
                                    . '</a></span>'
                
            ]
        );
		
        
        $this->_eventManager->dispatch('adminhtml_customshippingprice_edit_tab_main_prepare_form', ['form' => $form]);

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
        return __('Digital Shipping Method Information');
    }

    /**
     * Prepare title for tab
     *
     * @return string
     */
    public function getTabTitle()
    {
        return __('Digital Shipping Method Information');
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
