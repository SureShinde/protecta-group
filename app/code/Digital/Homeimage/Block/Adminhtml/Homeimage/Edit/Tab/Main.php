<?php
namespace Digital\Homeimage\Block\Adminhtml\Homeimage\Edit\Tab;

use Magento\Cms\Model\Wysiwyg\Config;
/**

 * Homeimage edit form main tab

 */

class Main extends \Magento\Backend\Block\Widget\Form\Generic implements \Magento\Backend\Block\Widget\Tab\TabInterface

{

    /**

     * @var \Magento\Store\Model\System\Store

     */

    protected $_systemStore;



    /**

     * @var \Digital\Homeimage\Model\Status

     */

    protected $_status;
	protected $_wysiwygConfig;



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

        \Digital\Homeimage\Model\Status $status,
		Config $wysiwygConfig,

        array $data = []

    ) {

        $this->_systemStore = $systemStore;

        $this->_status = $status;
		$this->_wysiwygConfig = $wysiwygConfig;

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

        /* @var $model \Digital\Homeimage\Model\BlogPosts */

        $model = $this->_coreRegistry->registry('homeimage');



        $isElementDisabled = false;



        /** @var \Magento\Framework\Data\Form $form */

        $form = $this->_formFactory->create();



        $form->setHtmlIdPrefix('page_');



        $fieldset = $form->addFieldset('base_fieldset', ['legend' => __('Home Image Information')]);



        if ($model->getId()) {

            $fieldset->addField('banner_id', 'hidden', ['name' => 'banner_id']);

        }		

        $fieldset->addField(

            'name',

            'text',

            [

                'name' => 'name',

                'label' => __('Title'),

                'title' => __('Title'),

				'required' => true,

                'disabled' => $isElementDisabled

            ]

        );
		
		$wysiwygConfig = $this->_wysiwygConfig->getConfig();				
        $fieldset->addField(
            'banner_description',
            'editor',
            [
                'name' => 'banner_description',
                'style'     => 'width:400px; height:150px;',
                'label' => __('Description'),
                'title' => __('Description'),
				'required' => true,                
                'config' => $wysiwygConfig 
            ]
        );

        
        $fieldset->addField(

            'image',

            'image',

            [

                'name' => 'image',

                'label' => __('Image'),

                'title' => __('Image'),

				'required' => true,

                'disabled' => $isElementDisabled,

                'note' => '(Dimensions: 370px * 290px)',

            ]

        );
		
		$fieldset->addField(

            'banner_url',

            'text',

            [

                'name' => 'banner_url',

                'label' => __('URL'),

                'title' => __('URL'),

                'required' => false,

                'disabled' => $isElementDisabled

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
		
		$fieldset->addField(

            'status',

            'select',

            [

                'label' => __('Status'),

                'title' => __('Status'),

                'name' => 'status',

				'required' => true,

                'options' =>  $this->_status->getOptionArray(),

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

        return __('Home Image Information');

    }



    /**

     * Prepare title for tab

     *

     * @return \Magento\Framework\Phrase

     */

    public function getTabTitle()

    {

        return __('Image Information');

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

