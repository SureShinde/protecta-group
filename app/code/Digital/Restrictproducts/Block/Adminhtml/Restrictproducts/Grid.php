<?php
namespace Digital\Restrictproducts\Block\Adminhtml\Restrictproducts;
class Grid extends \Magento\Backend\Block\Widget\Grid\Extended {
    /**
     * @var \Magento\Framework\Module\Manager
     */
    protected $moduleManager;
    /**
     * @var \Digital\Restrictproducts\Model\restrictproductsFactory
     */
    protected $_restrictproductsFactory;
    /**
     * @var \Digital\Restrictproducts\Model\Status
     */
    
    /**
     * @param \Magento\Backend\Block\Template\Context $context
     * @param \Magento\Backend\Helper\Data $backendHelper
     * @param \Digital\Restrictproducts\Model\restrictproductsFactory $restrictproductsFactory
     * @param \Digital\Restrictproducts\Model\Status $status
     * @param \Magento\Framework\Module\Manager $moduleManager
     * @param array $data
     *
     * @SuppressWarnings(PHPMD.ExcessiveParameterList)
     */
    public function __construct(
        \Magento\Backend\Block\Template\Context $context,
        \Magento\Backend\Helper\Data $backendHelper,
        \Digital\Restrictproducts\Model\RestrictproductsFactory $RestrictproductsFactory,        
        \Magento\Framework\Module\Manager $moduleManager,
        array $data = []
    ) {
        $this->_restrictproductsFactory = $RestrictproductsFactory;        
        $this->moduleManager = $moduleManager;
        parent::__construct($context, $backendHelper, $data);
    }
    /**
     * @return void
     */
    protected function _construct() {
        parent::_construct();
        $this->setId('postGrid');
        $this->setDefaultSort('restrictproducts_id');
        $this->setDefaultDir('DESC');
        $this->setSaveParametersInSession(true);
        $this->setUseAjax(true);
        $this->setVarNameFilter('post_filter');
    }
    /**
     * @return $this
     */
    protected function _prepareCollection() {
        $collection = $this->_restrictproductsFactory->create()->getCollection();
        $this->setCollection($collection);
        parent::_prepareCollection();
        return $this;
    }
    /**
     * @return $this
     * @SuppressWarnings(PHPMD.ExcessiveMethodLength)
     */
    protected function _prepareColumns() {
        $this->addColumn(
            'restrictproducts_id',
            [
                'header' => __('ID'),
                'type' => 'number',
                'index' => 'restrictproducts_id',
                'header_css_class' => 'col-id',
                'column_css_class' => 'col-id'
            ]
        );
		$this->addColumn(
			'product_id',
			[
				'header' => __('Product ID'),
				'index' => 'product_id',
			]
		);

        $this->addColumn(
            'customers_id',
            [
                'header' => __('Customer ID'),
                'index' => 'customers_id',
            ]
        );
		
		
		
        $this->addColumn(
            'edit',
            [
                'header' => __('Edit'),
                'type' => 'action',
                'getter' => 'getId',
                'actions' => [
                    [
                        'caption' => __('Edit'),
                        'url' => [
                            'base' => '*/*/edit'
                        ],
                        'field' => 'restrictproducts_id'
                    ]
                ],
                'filter' => false,
                'sortable' => false,
                'index' => 'stores',
                'header_css_class' => 'col-action',
                'column_css_class' => 'col-action'
            ]
        );
		
		//$this->addExportType($this->getUrl('restrictproducts/*/exportCsv', ['_current' => true]),__('CSV'));
		//$this->addExportType($this->getUrl('restrictproducts/*/exportExcel', ['_current' => true]),__('Excel XML'));
        $block = $this->getLayout()->getBlock('grid.bottom.links');
        
		if ($block) {
            $this->setChild('grid.bottom.links', $block);
        }
        return parent::_prepareColumns();
    }
    /**
     * @return $this
     */
    protected function _prepareMassaction() {
        
		$this->setMassactionIdField('restrictproducts_id');
        $this->getMassactionBlock()->setFormFieldName('restrictproducts');
        
		$this->getMassactionBlock()->addItem(
            'delete',
            [
                'label' => __('Delete'),
                'url' => $this->getUrl('restrictproducts/*/massDelete'),
                'confirm' => __('Are you sure?')
            ]
        );
		
        
        return $this;
    }
    /**
     * @return string
     */
    public function getGridUrl() {
        return $this->getUrl('restrictproducts/*/grid', ['_current' => true]);
    }
    /**
     * @param \Digital\Restrictproducts\Model\restrictproducts|\Magento\Framework\Object $row
     * @return string
     */
    public function getRowUrl($row) {
        return $this->getUrl(
            'restrictproducts/*/edit',
            ['restrictproducts_id' => $row->getId()]
        );
    }
}