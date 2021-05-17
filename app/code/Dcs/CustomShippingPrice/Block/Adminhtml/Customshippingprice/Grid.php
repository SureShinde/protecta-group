<?php
namespace Dcs\CustomShippingPrice\Block\Adminhtml\Customshippingprice;

/**
 * Adminhtml CustomShippingPrice grid
 */

class Grid extends \Magento\Backend\Block\Widget\Grid\Extended
{
    /**
     * @var \Dcs\CustomShippingPrice\Model\ResourceModel\CustomShippingPrice\CollectionFactory
     */
    protected $_collectionFactory;
    /**
     * @var \Dcs\CustomShippingPrice\Model\CustomShippingPrice
     */
    protected $_customshippingprice;
    
    protected $_activitiesFactory;

    /**
     * @param \Magento\Backend\Block\Template\Context $context
     * @param \Magento\Backend\Helper\Data $backendHelper
     * @param \Dcs\CustomShippingPrice\Model\CustomShippingPrice $customshippingpricePage
     * @param \Dcs\CustomShippingPrice\Model\ResourceModel\CustomShippingPrice\CollectionFactory $collectionFactory
     * @param \Magento\Core\Model\PageLayout\Config\Builder $pageLayoutBuilder
     * @param \Dcs\CustomShippingPrice\Model\ActivitiesFactory
     * @param array $data
     */
	 
    public function __construct(
        \Magento\Backend\Block\Template\Context $context,
        \Magento\Backend\Helper\Data $backendHelper,
        \Dcs\CustomShippingPrice\Model\CustomShippingPrice $customshippingprice,
        \Dcs\CustomShippingPrice\Model\ResourceModel\CustomShippingPrice\CollectionFactory $collectionFactory,
        array $data = []
    ) {
		$this->_collectionFactory = $collectionFactory;
        $this->_customshippingprice = $customshippingprice;
        parent::__construct($context, $backendHelper, $data);
    }

    /**
     * @return void
     */
    protected function _construct()
    {		
        parent::_construct();
        $this->setId('customshippingpriceGrid');
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
        //$collection = $this->_activitiesFactory->create()->getCollection(); 
        /* @var $collection \Dcs\CustomShippingPrice\Model\ResourceModel\CustomShippingPrice\Collection */
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
        
        $this->addColumn('country_name', [
				'header' => __('Country Name'),
				'index' => 'country_name'
		]);
		
		$this->addColumn('region_name', [
				'header' => __('Region Name'),
				'index' => 'region_name'
		]);
		
		/*$this->addColumn('city', [
				'header' => __('City'),
				'index' => 'city'
		]);*/
		
		$this->addColumn('zone', [
				'header' => __('Zone'),
				'index' => 'zone'
		]);
		
		$this->addColumn('zip_from', [
				'header' => __('Zip From'),
				'index' => 'zip_from'
		]);
		
		$this->addColumn('zip_to', [
				'header' => __('Zip To'),
				'index' => 'zip_to'
		]);
		
		$this->addColumn('weight_from', [
				'header' => __('Weight From'),
				'index' => 'weight_from'
		]);
		
		$this->addColumn('weight_to', [
				'header' => __('Weight To'),
				'index' => 'weight_to'
		]);
		
		$this->addColumn('volume_from', [
				'header' => __('Volume From'),
				'index' => 'volume_from'
		]);
		
		$this->addColumn('volume_to', [
				'header' => __('Volume To'),
				'index' => 'volume_to'
		]);
		
		$this->addColumn('profile_name', [
				'header' => __('Profile Name'),
				'index' => 'profile_name'
		]);
		
		$this->addColumn('price', [
				'header' => __('Shipping Price'),
				'index' => 'price'
		]);
		
		$this->addColumn('delivery_type', [
				'header' => __('Shipping Name'),
				'index' => 'delivery_type'
		]);

        $this->addColumn('shipping_description', [
                'header' => __('Shipping Description'),
                'index' => 'shipping_description'
        ]);
         
		$this->addExportType($this->getUrl('customshippingprice/*/exportCsv', ['_current' => true]),__('CSV'));
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

        //$this->setMassactionIdField('id');
        
       // $this->getMassactionBlock()->setFormFieldName('customshippingprice');

        //$this->getMassactionBlock()->addItem(
        //    'delete',
        //    [
         //       'label' => __('Delete'),
        //        'url' => $this->getUrl('customshippingprice/*/massDelete'),
        //        'confirm' => __('Are you sure?')
        //    ]
      //  );
        
       // return $this;
    }
    public function getGridUrl()
    {
        return $this->getUrl('*/*/grid', ['_current' => true]);
    }
    
}
