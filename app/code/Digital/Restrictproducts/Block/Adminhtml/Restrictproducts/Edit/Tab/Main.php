<?php
namespace Digital\Restrictproducts\Block\Adminhtml\Restrictproducts\Edit\Tab;

use Magento\Cms\Model\Wysiwyg\Config;
/**

 * Restrictproducts edit form main tab

 */

class Main extends \Magento\Backend\Block\Widget\Form\Generic implements \Magento\Backend\Block\Widget\Tab\TabInterface

{

    /**

     * @var \Magento\Store\Model\System\Store

     */

    protected $_systemStore;



    /**

     * @var \Digital\Restrictproducts\Model\Status

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

        
		Config $wysiwygConfig,

        array $data = []

    ) {

        $this->_systemStore = $systemStore;

        
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

        /* @var $model \Digital\Restrictproducts\Model\BlogPosts */

        $model = $this->_coreRegistry->registry('restrictproducts');



        $isElementDisabled = false;



        /** @var \Magento\Framework\Data\Form $form */

        $form = $this->_formFactory->create();



        $form->setHtmlIdPrefix('page_');



        $fieldset = $form->addFieldset('base_fieldset', ['legend' => __('Custom Branded Items Information')]);



        if ($model->getId()) {

            $fieldset->addField('restrictproducts_id', 'hidden', ['name' => 'restrictproducts_id']);

        }		

        $fieldset->addField(
            'product_id',
            'text',
            [
                'name' => 'product_id',
                'label' => __('Product ID'),
                'title' => __('Product ID'),
				'required' => true,
                'disabled' => $isElementDisabled,                
            ]
        );

        $fieldset->addField(
            'customers_id',
            'text',
            [
                'name' => 'customers_id',
                'label' => __('Customer ID'),
                'title' => __('Customer ID'),
                'required' => true,
                'disabled' => $isElementDisabled,
                'note' => 'Comma-separated (e.g. 10,11,12 etc.)',
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

        return __('Custom Branded Items Information');

    }



    /**

     * Prepare title for tab

     *

     * @return \Magento\Framework\Phrase

     */

    public function getTabTitle()

    {

        return __('Custom Branded Items Information');

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

