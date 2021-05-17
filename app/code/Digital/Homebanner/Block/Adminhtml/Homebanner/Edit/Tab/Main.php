<?php

namespace Digital\Homebanner\Block\Adminhtml\Homebanner\Edit\Tab;

/**
 * Homebanner edit form main tab
 */
class Main extends \Magento\Backend\Block\Widget\Form\Generic implements \Magento\Backend\Block\Widget\Tab\TabInterface
{
    /**
     * @var \Magento\Store\Model\System\Store
     */
    protected $_systemStore;

    /**
     * @var \Digital\Homebanner\Model\Status
     */
    protected $_status;

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
        \Digital\Homebanner\Model\Status $status,
        array $data = []
    ) {
        $this->_systemStore = $systemStore;
        $this->_status = $status;
        parent::__construct($context, $registry, $formFactory, $data);
    }

    /**
     * Prepare form
     *
     * @return $this
     * @SuppressWarnings(PHPMD.ExcessiveMethodLength)
     */
    protected function _prepareForm()
    {
        /* @var $model \Digital\Homebanner\Model\BlogPosts */
        $model = $this->_coreRegistry->registry('homebanner');

        $isElementDisabled = false;

        /** @var \Magento\Framework\Data\Form $form */
        $form = $this->_formFactory->create();

        $form->setHtmlIdPrefix('page_');

        $fieldset = $form->addFieldset('base_fieldset', ['legend' => __('Home Banner Information')]);

        if ($model->getId()) {
            $fieldset->addField('banner_id', 'hidden', ['name' => 'banner_id']);
        }

		
        $fieldset->addField(
            'name',
            'text',
            [
                'name' => 'name',
                'label' => __('Banner Name'),
                'title' => __('Banner Name'),
				'required' => true,
                'disabled' => $isElementDisabled
            ]
        );

        $fieldset->addField(
            'banner_url',
            'text',
            [
                'name' => 'banner_url',
                'label' => __('Banner Url'),
                'title' => __('Banner Url'),
                'required' => true,
                'disabled' => $isElementDisabled
            ]
        );

        /*$fieldset->addField(
            'banner_slogan',
            'text',
            [
                'name' => 'banner_slogan',
                'label' => __('Banner Slogan'),
                'title' => __('Banner Slogan'),
                //'required' => true,
                'disabled' => $isElementDisabled
            ]
        );*/
									
						
        $fieldset->addField(
            'status',
            'select',
            [
                'label' => __('Banner Status'),
                'title' => __('Banner Status'),
                'name' => 'status',
				'required' => true,
                'options' =>  $this->_status->getOptionArray(),
                'disabled' => $isElementDisabled
            ]
        );
						
										
						
        $fieldset->addField(
            'banner_use',
            'select',
            [
                'label' => __('Banner For'),
                'title' => __('Banner For'),
                'name' => 'banner_use',
				'required' => true,
                'options' =>  \Digital\Homebanner\Helper\Data::getOptionArray(),
                'disabled' => $isElementDisabled
            ]
        );
						
										

        $fieldset->addField(
            'image',
            'image',
            [
                'name' => 'image',
                'label' => __('Banner Image'),
                'title' => __('Banner Image'),
				'required' => true,
                'disabled' => $isElementDisabled,
                'note' => '(Dimensions for Desktop: 2000px * 350px)<br>(Dimensions for Mobile: 767px * 767px)',
            ]
        );
						
						
        $fieldset->addField(
            'sort_order',
            'text',
            [
                'name' => 'sort_order',
                'label' => __('Sort Order'),
                'title' => __('Sort Order'),
				
                'disabled' => $isElementDisabled
            ]
        );		 	

        if (!$model->getId()) {
            $model->setData('is_active', $isElementDisabled ? '0' : '1');
        }

        $form->setValues($model->getData());
        $this->setForm($form);
		
        return parent::_prepareForm();
    }

    /**
     * Prepare label for tab
     *
     * @return \Magento\Framework\Phrase
     */
    public function getTabLabel()
    {
        return __('Home Banner Information');
    }

    /**
     * Prepare title for tab
     *
     * @return \Magento\Framework\Phrase
     */
    public function getTabTitle()
    {
        return __('Banner Information');
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
    
    public function getTargetOptionArray(){
    	return array(
    				'_self' => "Self",
					'_blank' => "New Page",
    				);
    }
}
