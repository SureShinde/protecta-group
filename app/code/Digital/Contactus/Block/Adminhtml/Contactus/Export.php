<?php
namespace Digital\Contactus\Block\Adminhtml\Contactus;

use Digital\Contactus\Model\Status;
/**
 * Adminhtml Contactus grid
 */
class Export extends \Magento\Backend\Block\Widget\Grid\Extended
{
    /**
     * @var \Digital\Contactus\Model\ResourceModel\Contactus\CollectionFactory
     */
    protected $_collectionFactory;

    /**
     * @var \Digital\Contactus\Model\Contactus
     */
    protected $_contactus;

    /**
     * @param \Magento\Backend\Block\Template\Context $context
     * @param \Magento\Backend\Helper\Data $backendHelper
     * @param \Digital\Contactus\Model\Contactus $contactusPage
     * @param \Digital\Contactus\Model\ResourceModel\Contactus\CollectionFactory $collectionFactory
     * @param \Magento\Core\Model\PageLayout\Config\Builder $pageLayoutBuilder
     * @param array $data
     */
    public function __construct(
        \Magento\Backend\Block\Template\Context $context,
        \Magento\Backend\Helper\Data $backendHelper,
		\Magento\Config\Model\Config\Source\Yesno $booleanOptions,
        \Digital\Contactus\Model\Contactus $contactus,
        \Digital\Contactus\Model\ResourceModel\Contactus\CollectionFactory $collectionFactory,
        array $data = []
    ) {
        $this->_collectionFactory = $collectionFactory;
		$this->booleanOptions    = $booleanOptions;
        $this->_contactus = $contactus;
        parent::__construct($context, $backendHelper, $data);
    }

    /**
     * @return void
     */
    protected function _construct()
    {
        parent::_construct();
        $this->setId('contactusGrid');
        $this->setDefaultSort('contactus_id');
        $this->setDefaultDir('DESC');
        $this->setUseAjax(true);
        $this->setSaveParametersInSession(true);
    }

    /**
     * Prepare collection
     *
     * @return \Magento\Backend\Block\Widget\Grid
     */
    protected function _prepareCollection()
    {
        $collection = $this->_collectionFactory->create();
        /* @var $collection \Digital\Contactus\Model\ResourceModel\Contactus\Collection */
        $this->setCollection($collection);

        return parent::_prepareCollection();
    }
    /**
     * Prepare columns
     *
     * @return \Magento\Backend\Block\Widget\Grid\Extended
     */
    protected function _prepareColumns()
    {
        $this->addColumn('contactus_id', [
            'header'    => __('ID'),
            'index'     => 'contactus_id',
        ]);
        
        $this->addColumn('name', [
            'header' => __('Name'), 
            'index' => 'name'
        ]);
		
				
		 $this->addColumn('email', [
            'header' => __('Email'), 
            'index' => 'email'
        ]);
        
       
        $this->addColumn('phone', [
            'header' => __('Phone No.'), 
            'index' => 'phone'
        ]);
		
		$this->addColumn('company', [
            'header' => __('Company'), 
            'index' => 'company'
        ]);

        $this->addColumn('message', [
            'header' => __('Message'), 
            'index' => 'message'
        ]);

        
        return parent::_prepareColumns();
    }
	
	protected function _prepareMassaction()
    {
        $this->setMassactionIdField('entity_id');
        $this->getMassactionBlock()->setFormFieldName('contactus_id');

        $this->getMassactionBlock()->addItem(
            'delete',
            [
                'label' => __('Delete'),
                'url' => $this->getUrl('contactus/*/massDelete'),
                'confirm' => __('Are you sure?'),
            ]
        );
        return $this;
    }

    /**
     * Row click url
     *
     * @param \Magento\Framework\Object $row
     * @return string
     */
    public function getRowUrl($row)
    {
        return $this->getUrl('*/*/edit', ['contactus_id' => $row->getId()]);
    }

    /**
     * Get grid url
     *
     * @return string
     */
    public function getGridUrl()
    {
        return $this->getUrl('*/*/grid', ['_current' => true]);
    }
}
