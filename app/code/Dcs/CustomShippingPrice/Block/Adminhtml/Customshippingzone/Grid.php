<?php
namespace Dcs\CustomShippingPrice\Block\Adminhtml\Customshippingzone;


class Grid extends \Magento\Backend\Block\Widget\Grid\Extended
{
	
    
    protected $_collectionFactory;
    
    protected $_customshippingzone;
    
    protected $_activitiesFactory;

    	 
    public function __construct(		
        \Magento\Backend\Block\Template\Context $context,
        \Magento\Backend\Helper\Data $backendHelper,
        \Dcs\CustomShippingPrice\Model\CustomShippingZone $customshippingzone,
        \Dcs\CustomShippingPrice\Model\ResourceModel\CustomShippingZone\CollectionFactory $collectionFactory,
        array $data = []
    ) {
		$this->_collectionFactory = $collectionFactory;
        $this->_customshippingzone = $customshippingzone;
        parent::__construct($context, $backendHelper, $data);
    }

    /**
     * @return void
     */
    protected function _construct()
    {		
        parent::_construct();
        $this->setId('customshippingzoneGrid');
        $this->setDefaultSort('id');
        $this->setDefaultDir('ASC');
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
        
		$this->addColumn('id', [
            'header'    => __('ID'),
            'index'     => 'id',
        ]);

        $this->addColumn('internal_id', [
                'header' => __('Internal ID'),
                'index' => 'internal_id'
        ]);
        
		$this->addColumn('zone', [
				'header' => __('Zone'),
				'index' => 'zone'
		]);
		
		$this->addColumn('nsw', [
				'header' => __('NSW'),
				'index' => 'nsw'
		]);
		
		$this->addColumn('qld', [
				'header' => __('QLD'),
				'index' => 'qld'
		]);
		
		$this->addColumn('vic', [
				'header' => __('VIC'),
				'index' => 'vic'
		]);
		
		$this->addColumn('wa', [
				'header' => __('WA'),
				'index' => 'wa'
		]);
		
		
         
		//$this->addExportType($this->getUrl('customshippingprice/*/exportCsv', ['_current' => true]),__('CSV'));
		// $this->addExportType($this->getUrl('customshippingprice/*/exportExcel', ['_current' => true]),__('Excel XML'));

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
        //return $this->getUrl('*/*/edit', ['id' => $row->getId()]);
    }

    /**
     * Get grid url
     *
     * @return string
     */
    protected function _prepareMassaction()
	{

       // $this->setMassactionIdField('id');
        
       // $this->getMassactionBlock()->setFormFieldName('customshippingzone');

      //  $this->getMassactionBlock()->addItem(
      //      'delete',
      //      [
      //          'label' => __('Delete'),
      //          'url' => $this->getUrl('customshippingprice/*/massDelete'),
      //          'confirm' => __('Are you sure?')
     //       ]
     //   );
        
     //   return $this;
    }
    public function getGridUrl()
    {
        return $this->getUrl('*/*/grid', ['_current' => true]);
    }
    
}
