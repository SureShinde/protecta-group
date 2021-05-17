<?php
namespace Dcs\Productenquiry\Block\Adminhtml\Productenquiry;

class Grid extends \Magento\Backend\Block\Widget\Grid\Extended
{
    protected $_collectionFactory;

    protected $_productenquiry;

    public function __construct(
        \Magento\Backend\Block\Template\Context $context,
        \Magento\Backend\Helper\Data $backendHelper,
        \Dcs\Productenquiry\Model\Productenquiry $productenquiry,
        \Dcs\Productenquiry\Model\ResourceModel\Productenquiry\CollectionFactory $collectionFactory,
        array $data = []
    ) {
        $this->_collectionFactory = $collectionFactory;
        $this->_productenquiry = $productenquiry;
        parent::__construct($context, $backendHelper, $data);
    }

    protected function _construct()
    {
        parent::_construct();
        $this->setId('productenquiryGrid');
        $this->setDefaultSort('enquiry_id');
        $this->setDefaultDir('DESC');
        $this->setUseAjax(true);
        $this->setSaveParametersInSession(true);
    }

    protected function _prepareCollection()
    {
        $collection = $this->_collectionFactory->create();
        $this->setCollection($collection);
        return parent::_prepareCollection();
    }
   
    protected function _prepareColumns()
    {
        $this->addColumn('enquiry_id', [
            'header'    => __('ID'),
            'index'     => 'enquiry_id',
        ]);
        $this->addColumn('products', 
						 ['header' => __('Products'), 
						  'index' => 'products',
			'renderer' =>  'Dcs\Productenquiry\Block\Adminhtml\Productenquiry\Renderer\Products'
						 ]
						);
        $this->addColumn('fullname', ['header' => __('Full Name'), 'index' => 'fullname']);
        $this->addColumn('company', ['header' => __('Company'), 'index' => 'company']);
		$this->addColumn('email', ['header' => __('Email'), 'index' => 'email']);     
		$this->addColumn('phone', ['header' => __('Phone'), 'index' => 'phone']);
		//$this->addColumn('comment', ['header' => __('Comment'), 'index' => 'comment']);		
        
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
                        'field' => 'enquiry_id'
                    ]
                ],
                'sortable' => false,
                'filter' => false,
                'header_css_class' => 'col-action',
                'column_css_class' => 'col-action'
            ]
        );

        return parent::_prepareColumns();
    }
	
	protected function _prepareMassaction()
    {
        $this->setMassactionIdField('enquiry_id');
        $this->getMassactionBlock()->setFormFieldName('enquiry_id');

        $this->getMassactionBlock()->addItem(
            'delete',
            [
                'label' => __('Delete'),
                'url' => $this->getUrl('productenquiry/*/massDelete'),
                'confirm' => __('Are you sure?'),
            ]
        );

        return $this;
    }

    public function getRowUrl($row)
    {
        return $this->getUrl('*/*/edit', ['enquiry_id' => $row->getId()]);
    }

    public function getGridUrl()
    {
        return $this->getUrl('*/*/grid', ['_current' => true]);
    }
}
