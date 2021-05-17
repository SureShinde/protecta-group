<?php
namespace Digital\Homeimage\Block\Adminhtml\Homeimage;
class Grid extends \Magento\Backend\Block\Widget\Grid\Extended {
    /**
     * @var \Magento\Framework\Module\Manager
     */
    protected $moduleManager;
    /**
     * @var \Digital\Homeimage\Model\homeimageFactory
     */
    protected $_homeimageFactory;
    /**
     * @var \Digital\Homeimage\Model\Status
     */
    protected $_status;
    /**
     * @param \Magento\Backend\Block\Template\Context $context
     * @param \Magento\Backend\Helper\Data $backendHelper
     * @param \Digital\Homeimage\Model\homeimageFactory $homeimageFactory
     * @param \Digital\Homeimage\Model\Status $status
     * @param \Magento\Framework\Module\Manager $moduleManager
     * @param array $data
     *
     * @SuppressWarnings(PHPMD.ExcessiveParameterList)
     */
    public function __construct(
        \Magento\Backend\Block\Template\Context $context,
        \Magento\Backend\Helper\Data $backendHelper,
        \Digital\Homeimage\Model\HomeimageFactory $HomeimageFactory,
        \Digital\Homeimage\Model\Status $status,
        \Magento\Framework\Module\Manager $moduleManager,
        array $data = []
    ) {
        $this->_homeimageFactory = $HomeimageFactory;
        $this->_status = $status;
        $this->moduleManager = $moduleManager;
        parent::__construct($context, $backendHelper, $data);
    }
    /**
     * @return void
     */
    protected function _construct() {
        parent::_construct();
        $this->setId('postGrid');
        $this->setDefaultSort('banner_id');
        $this->setDefaultDir('DESC');
        $this->setSaveParametersInSession(true);
        $this->setUseAjax(true);
        $this->setVarNameFilter('post_filter');
    }
    /**
     * @return $this
     */
    protected function _prepareCollection() {
        $collection = $this->_homeimageFactory->create()->getCollection();
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
            'banner_id',
            [
                'header' => __('ID'),
                'type' => 'number',
                'index' => 'banner_id',
                'header_css_class' => 'col-id',
                'column_css_class' => 'col-id'
            ]
        );
		$this->addColumn(
			'name',
			[
				'header' => __('Title'),
				'index' => 'name',
			]
		);
		
		
        $this->addColumn(
            'image',
            [
                'header' => __('Image'),
                'class' => 'xxx',
                'width' => '50px',
                'index' => 'image',
                'filter' => false,
                'renderer' => 'Digital\Homeimage\Block\Adminhtml\Homeimage\Helper\Renderer\Image',
            ]
        );
		
		/*$this->addColumn(
            'banner_url',
            [
                'header' => __('URL'),
                'index' => 'banner_url',
            ]
        );*/
		
		$this->addColumn(
			'sort_order',
			[
				'header' => __('Sort Order'),
				'index' => 'sort_order',
                'type' =>'number',
                'header_css_class' => 'col-id',
                'column_css_class' => 'col-id'
			]
		);
		
		$this->addColumn(
			'status',
			[
				'header' => __('Status'),
				'index' => 'status',
				'type' => 'options',
				'options' => \Digital\Homeimage\Model\Status::getOptionArray()
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
                        'field' => 'banner_id'
                    ]
                ],
                'filter' => false,
                'sortable' => false,
                'index' => 'stores',
                'header_css_class' => 'col-action',
                'column_css_class' => 'col-action'
            ]
        );
		
		//$this->addExportType($this->getUrl('homeimage/*/exportCsv', ['_current' => true]),__('CSV'));
		//$this->addExportType($this->getUrl('homeimage/*/exportExcel', ['_current' => true]),__('Excel XML'));
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
        
		$this->setMassactionIdField('banner_id');
        $this->getMassactionBlock()->setFormFieldName('homeimage');
        
		$this->getMassactionBlock()->addItem(
            'delete',
            [
                'label' => __('Delete'),
                'url' => $this->getUrl('homeimage/*/massDelete'),
                'confirm' => __('Are you sure?')
            ]
        );
		
        $statuses = $this->_status->getOptionArray();
		
        $this->getMassactionBlock()->addItem(
            'status',
            [
                'label' => __('Change status'),
                'url' => $this->getUrl('homeimage/*/massStatus', ['_current' => true]),
                'additional' => [
                    'visibility' => [
                        'name' => 'status',
                        'type' => 'select',
                        'class' => 'required-entry',
                        'label' => __('Status'),
                        'values' => $statuses
                    ]
                ]
            ]
        );
        return $this;
    }
    /**
     * @return string
     */
    public function getGridUrl() {
        return $this->getUrl('homeimage/*/grid', ['_current' => true]);
    }
    /**
     * @param \Digital\Homeimage\Model\homeimage|\Magento\Framework\Object $row
     * @return string
     */
    public function getRowUrl($row) {
        return $this->getUrl(
            'homeimage/*/edit',
            ['banner_id' => $row->getId()]
        );
    }
}