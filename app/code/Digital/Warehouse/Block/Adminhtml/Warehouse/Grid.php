<?php
namespace Digital\Warehouse\Block\Adminhtml\Warehouse;

use Digital\Warehouse\Model\Status;
/**
 * Adminhtml Warehouse grid
 */
class Grid extends \Magento\Backend\Block\Widget\Grid\Extended
{
    /**
     * @var \Digital\Warehouse\Model\ResourceModel\Warehouse\CollectionFactory
     */
    protected $_collectionFactory;

    /**
     * @var \Digital\Warehouse\Model\Warehouse
     */
    protected $_warehouse;

    /**
     * @param \Magento\Backend\Block\Template\Context $context
     * @param \Magento\Backend\Helper\Data $backendHelper
     * @param \Digital\Warehouse\Model\Warehouse $warehousePage
     * @param \Digital\Warehouse\Model\ResourceModel\Warehouse\CollectionFactory $collectionFactory
     * @param \Magento\Core\Model\PageLayout\Config\Builder $pageLayoutBuilder
     * @param array $data
     */
    public function __construct(
        \Magento\Backend\Block\Template\Context $context,
        \Magento\Backend\Helper\Data $backendHelper,
		\Magento\Config\Model\Config\Source\Yesno $booleanOptions,
        \Digital\Warehouse\Model\Warehouse $warehouse,
        \Digital\Warehouse\Model\ResourceModel\Warehouse\CollectionFactory $collectionFactory,
        array $data = []
    ) {
        $this->_collectionFactory = $collectionFactory;
		$this->booleanOptions    = $booleanOptions;
        $this->_warehouse = $warehouse;
        parent::__construct($context, $backendHelper, $data);
    }

    /**
     * @return void
     */
    protected function _construct()
    {
        parent::_construct();
        $this->setId('warehouseGrid');
        $this->setDefaultSort('warehouse_id');
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
        /* @var $collection \Digital\Warehouse\Model\ResourceModel\Warehouse\Collection */
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
        $this->addColumn('warehouse_id', [
            'header'    => __('ID'),
            'index'     => 'warehouse_id',
        ]);
        
        $this->addColumn('warehouse_code', [
            'header' => __('Warehouse Code'), 
            'index' => 'warehouse_code'
        ]);
		
				
		 $this->addColumn('warehouse_name', [
            'header' => __('Warehouse Name'), 
            'index' => 'warehouse_name'
        ]);
		
		
		$this->addColumn('lng', [
            'header' => __('Longitude'), 
            'index' => 'lng'
        ]);
		
		$this->addColumn('lat', [
            'header' => __('Latitude'), 
            'index' => 'lat'
        ]);
		
		        
       
                
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
                        'field' => 'warehouse_id'
                    ]
                ],
                'sortable' => false,
                'filter' => false,
                'header_css_class' => 'col-action',
                'column_css_class' => 'col-action'
            ]
        );

        //$this->addExportType($this->getUrl('warehouse/*/exportCsv', ['_current' => true]),__('CSV'));
        //$this->addExportType($this->getUrl('warehouse/*/exportExcel', ['_current' => true]),__('Excel XML'));

        
        return parent::_prepareColumns();
    }
	
	protected function _prepareMassaction()
    {
        $this->setMassactionIdField('warehouse_id');
        $this->getMassactionBlock()->setFormFieldName('warehouse_id');

        /*$this->getMassactionBlock()->addItem(
            'delete',
            [
                'label' => __('Delete'),
                'url' => $this->getUrl('warehouse/ * /massDelete'),
                'confirm' => __('Are you sure?'),
            ]
        );*/
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
        return $this->getUrl('*/*/edit', ['warehouse_id' => $row->getId()]);
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
