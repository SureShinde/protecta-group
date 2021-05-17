<?php
namespace Dcs\Updateaccount\Block\Adminhtml\Updateaccount;

/**
 * Adminhtml Updateaccount grid
 */

class Grid extends \Magento\Backend\Block\Widget\Grid\Extended
{
    /**
     * @var \Dcs\Updateaccount\Model\ResourceModel\Updateaccount\CollectionFactory
     */
    protected $_collectionFactory;
    /**
     * @var \Dcs\Updateaccount\Model\Updateaccount
     */
    protected $_updateaccount;
    
    protected $_activitiesFactory;

    /**
     * @param \Magento\Backend\Block\Template\Context $context
     * @param \Magento\Backend\Helper\Data $backendHelper
     * @param \Dcs\Updateaccount\Model\Updateaccount $updateaccountPage
     * @param \Dcs\Updateaccount\Model\ResourceModel\Updateaccount\CollectionFactory $collectionFactory
     * @param \Magento\Core\Model\PageLayout\Config\Builder $pageLayoutBuilder
     * @param \Dcs\Updateaccount\Model\ActivitiesFactory
     * @param array $data
     */
	 
    public function __construct(
        \Magento\Backend\Block\Template\Context $context,
        \Magento\Backend\Helper\Data $backendHelper,
        \Dcs\Updateaccount\Model\Updateaccount $updateaccount,
        \Dcs\Updateaccount\Model\ResourceModel\Updateaccount\CollectionFactory $collectionFactory,
        array $data = []
    ) {
		$this->_collectionFactory = $collectionFactory;
        $this->_updateaccount = $updateaccount;
        parent::__construct($context, $backendHelper, $data);
    }

    /**
     * @return void
     */
    protected function _construct()
    {
        parent::_construct();
        $this->setId('updateaccountGrid');
        $this->setDefaultSort('updateaccount_id');
        $this->setDefaultDir('DESC');
        $this->setUseAjax(true);
        $this->setSaveParametersInSession(true);
        $this->setVarNameFilter('post_filter');
    }

    /**
     * Prepare collection
     *
     * @return \Magento\Backend\Block\Widget\Grid
     */
    protected function _prepareCollection()
    {
        $collection = $this->_collectionFactory->create();
        //$collection = $this->_activitiesFactory->create()->getCollection(); 
        /* @var $collection \Dcs\Updateaccount\Model\ResourceModel\Updateaccount\Collection */
        $this->setCollection($collection);

        parent::_prepareCollection();
        return $this;
    }

    /**
     * Prepare columns
     *
     * @return \Magento\Backend\Block\Widget\Grid\Extended
     */
    protected function _prepareColumns()
    {
        $this->addColumn('updateaccount_id', [
            'header'    => __('ID'),
            'index'     => 'updateaccount_id',
        ]);
        
        $this->addColumn('customer_name', [
				'header' => __('Customer Name'),
				'index' => 'customer_name'
		]);
        $this->addColumn('customer_company', [
				'header' => __('Company Name'),
				'index' => 'customer_company'
		]);
        $this->addColumn('customer_email', [
				'header' => __('Customer Email'), 
				'index' => 'customer_email'
		]);
        $this->addColumn(
					'request_type',
					[
						'header' => __('Enquiry Type'),
						'index' => 'request_type',
						'type' => 'options',
						'options' => \Dcs\Updateaccount\Block\Adminhtml\Updateaccount\Grid::getEnquiryType(),
					]
				);
        
        $this->addColumn(
            'action',
            [
                'header' => __('View'),
                'type' => 'action',
                'getter' => 'getId',
                'actions' => [
                    [
                        'caption' => __('View'),
                        'url' => [
                            'base' => '*/*/edit',
                            'params' => ['store' => $this->getRequest()->getParam('store')]
                        ],
                        'field' => 'updateaccount_id'
                    ]
                ],
                'sortable' => false,
                'filter' => false,
                'header_css_class' => 'col-action',
                'column_css_class' => 'col-action'
            ]
        );
         
		//$this->addExportType($this->getUrl('updateaccount/*/exportCsv', ['_current' => true]),__('CSV'));
		// $this->addExportType($this->getUrl('updateaccount/*/exportExcel', ['_current' => true]),__('Excel XML'));

        return parent::_prepareColumns();
    }

    /**
     * Row click url
     *
     * @param \Magento\Framework\Object $row
     * @return string
     */
    public function getRowUrl($row)
    {
        return $this->getUrl('*/*/edit', ['updateaccount_id' => $row->getId()]);
    }

    /**
     * Get grid url
     *
     * @return string
     */
    protected function _prepareMassaction()
	{

        $this->setMassactionIdField('updateaccount_id');
        
        $this->getMassactionBlock()->setFormFieldName('updateaccount');

        $this->getMassactionBlock()->addItem(
            'delete',
            [
                'label' => __('Delete'),
                'url' => $this->getUrl('updateaccount/*/massDelete'),
                'confirm' => __('Are you sure?')
            ]
        );
        
        return $this;
    }
    public function getGridUrl()
    {
        return $this->getUrl('*/*/grid', ['_current' => true]);
    }
    public function getEnquiryType()
		{	
			$option_value = array();
			$option_value['Account Information']='Account Information';
			$option_value['Billing Address']='Billing Address';
           return($option_value);
		}
}
