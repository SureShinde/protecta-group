<?php
namespace Digital\Homebanner\Block\Adminhtml\Homebanner;

class Grid extends \Magento\Backend\Block\Widget\Grid\Extended
{
    /**
     * @var \Magento\Framework\Module\Manager
     */
    protected $moduleManager;

    /**
     * @var \Digital\Homebanner\Model\homebannerFactory
     */
    protected $_homebannerFactory;

    /**
     * @var \Digital\Homebanner\Model\Status
     */
    protected $_status;

    /**
     * @param \Magento\Backend\Block\Template\Context $context
     * @param \Magento\Backend\Helper\Data $backendHelper
     * @param \Digital\Homebanner\Model\homebannerFactory $homebannerFactory
     * @param \Digital\Homebanner\Model\Status $status
     * @param \Magento\Framework\Module\Manager $moduleManager
     * @param array $data
     *
     * @SuppressWarnings(PHPMD.ExcessiveParameterList)
     */
    public function __construct(
        \Magento\Backend\Block\Template\Context $context,
        \Magento\Backend\Helper\Data $backendHelper,
        \Digital\Homebanner\Model\HomebannerFactory $HomebannerFactory,
        \Digital\Homebanner\Model\Status $status,
        \Magento\Framework\Module\Manager $moduleManager,
        array $data = []
    ) {
        $this->_homebannerFactory = $HomebannerFactory;
        $this->_status = $status;
        $this->moduleManager = $moduleManager;
        parent::__construct($context, $backendHelper, $data);
    }

    /**
     * @return void
     */
    protected function _construct()
    {
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
    protected function _prepareCollection()
    {
        $collection = $this->_homebannerFactory->create()->getCollection();
        $this->setCollection($collection);

        parent::_prepareCollection();

        return $this;
    }

    /**
     * @return $this
     * @SuppressWarnings(PHPMD.ExcessiveMethodLength)
     */
    protected function _prepareColumns()
    {
        $this->addColumn(
            'banner_id',
            [
                'header' => __('Banner ID'),
                'type' => 'number',
                'index' => 'banner_id',
                'header_css_class' => 'col-id',
                'column_css_class' => 'col-id'
            ]
        );


		
		$this->addColumn(
			'name',
			[
				'header' => __('Banner Name'),
				'index' => 'name',
			]
		);
				
						
		$this->addColumn(
			'status',
			[
				'header' => __('Banner Status'),
				'index' => 'status',
				'type' => 'options',
				'options' => \Digital\Homebanner\Model\Status::getOptionArray()
			]
		); 
		
		$this->addColumn(
			'banner_use',
			[
				'header' => __('Banner For'),
				'index' => 'banner_use',
				'type' => 'options',
				'options' => \Digital\Homebanner\Helper\Data::getOptionArray()
			]
		); 	
		
        /*$this->addColumn(
            'banner_url',
            [
                'header' => __('Banner Url'),
                'index' => 'banner_url',
            ]
        );
        */
        /*$this->addColumn(
            'banner_slogan',
            [
                'header' => __('Banner Slogan'),
                'index' => 'banner_slogan',
            ]
        ); */

        $this->addColumn(
            'image',
            [
                'header' => __('Image'),
                'class' => 'xxx',
                'width' => '50px',
                'index' => 'image',
                'filter' => false,
                'renderer' => 'Digital\Homebanner\Block\Adminhtml\Homebanner\Helper\Renderer\Image',
            ]
        ); 
        
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
		

		
		  // $this->addExportType($this->getUrl('homebanner/*/exportCsv', ['_current' => true]),__('CSV'));
		 //  $this->addExportType($this->getUrl('homebanner/*/exportExcel', ['_current' => true]),__('Excel XML'));

        $block = $this->getLayout()->getBlock('grid.bottom.links');
        if ($block) {
            $this->setChild('grid.bottom.links', $block);
        }

        return parent::_prepareColumns();
    }

	
    /**
     * @return $this
     */
    protected function _prepareMassaction()
    {

        $this->setMassactionIdField('banner_id'); 
        $this->getMassactionBlock()->setFormFieldName('homebanner');

        $this->getMassactionBlock()->addItem(
            'delete',
            [
                'label' => __('Delete'),
                'url' => $this->getUrl('homebanner/*/massDelete'),
                'confirm' => __('Are you sure?')
            ]
        );

        $statuses = $this->_status->getOptionArray();

        $this->getMassactionBlock()->addItem(
            'status',
            [
                'label' => __('Change status'),
                'url' => $this->getUrl('homebanner/*/massStatus', ['_current' => true]),
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
    public function getGridUrl()
    {
        return $this->getUrl('*/*/grid', ['_current' => true]);
    }

    /**
     * @param \Digital\Homebanner\Model\homebanner|\Magento\Framework\Object $row
     * @return string
     */
    public function getRowUrl($row)
    {
		
        return $this->getUrl(
            'homebanner/*/edit',
            ['banner_id' => $row->getId()]
        );
		
    }
	 

}