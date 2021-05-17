<?php
namespace Dcs\Downloadcatalogue\Block\Adminhtml\Downloadcatalogue;

use Dcs\Downloadcatalogue\Model\Status;
use Dcs\Downloadcatalogue\Model\Visibility;

/**
 * Adminhtml Downloadcatalogue grid
 */
class Grid extends \Magento\Backend\Block\Widget\Grid\Extended
{
    /**
     * @var \Dcs\Downloadcatalogue\Model\ResourceModel\Downloadcatalogue\CollectionFactory
     */
    protected $_collectionFactory;

    /**
     * @var \Dcs\Downloadcatalogue\Model\Downloadcatalogue
     */
    protected $_downloadcatalogue;

    /**
     * @param \Magento\Backend\Block\Template\Context $context
     * @param \Magento\Backend\Helper\Data $backendHelper
     * @param \Dcs\Downloadcatalogue\Model\Downloadcatalogue $downloadcataloguePage
     * @param \Dcs\Downloadcatalogue\Model\ResourceModel\Downloadcatalogue\CollectionFactory $collectionFactory
     * @param \Magento\Core\Model\PageLayout\Config\Builder $pageLayoutBuilder
     * @param array $data
     */
    public function __construct(
        \Magento\Backend\Block\Template\Context $context,
        \Magento\Backend\Helper\Data $backendHelper,
        \Dcs\Downloadcatalogue\Model\Downloadcatalogue $downloadcatalogue,
        \Dcs\Downloadcatalogue\Model\ResourceModel\Downloadcatalogue\CollectionFactory $collectionFactory,
        array $data = []
    ) {
        $this->_collectionFactory = $collectionFactory;
        $this->_downloadcatalogue = $downloadcatalogue;
        parent::__construct($context, $backendHelper, $data);
    }

    /**
     * @return void
     */
    protected function _construct()
    {
        parent::_construct();
        $this->setId('downloadcatalogueGrid');
        $this->setDefaultSort('downloadcatalogue_id');
        $this->setDefaultDir('Asc');
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
        /* @var $collection \Dcs\Downloadcatalogue\Model\ResourceModel\Downloadcatalogue\Collection */
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
        $this->addColumn('downloadcatalogue_id', [
            'header'    => __('ID'),
            'index'     => 'downloadcatalogue_id',
        ]);
        
        $this->addColumn('name', ['header' => __('Name'), 'index' => 'name']);
		$this->addColumn(
            'image',
            [
                'header' => __('Image'),
                'index' => 'image',
			    'renderer' => 'Dcs\Downloadcatalogue\Block\Adminhtml\Downloadcatalogue\Helper\Renderer\Image',    
				'filter' => false,
				'sortable' => false,
                
            ]
        );		
		$this->addColumn('rank', ['header' => __('Rank'), 'index' => 'rank']);
		
        $this->addColumn(
            'status',
            [           
            'header' => __('Status'), 
            'index' => 'status',
            'type'      => 'options',
            'options' => Status::getAvailableStatuses(),
            'sortable' => false,
            ]          
          );
      
       /* $this->addColumn(
            'updated_time',
            [
                'header' => __('Published On'),
                'index' => 'updated_time',
                'type' => 'date',
                'header_css_class' => 'col-date',
                'column_css_class' => 'col-date'
            ]
        );
        
       $this->addColumn(
            'created_time',
            [
                'header' => __('Creation Time'),
                'index' => 'created_time',
                'type' => 'datetime',
                'header_css_class' => 'col-date',
                'column_css_class' => 'col-date'
            ]
        );*/
        
        $this->addColumn(
            'action',
            [
                'header' => __('Edit'),
                'type' => 'action',
                'getter' => 'getId',
                'actions' => [
                    [
                        'caption' => __('Edit'),
                        'url' => [
                            'base' => '*/*/edit',
                            'params' => ['store' => $this->getRequest()->getParam('store')]
                        ],
                        'field' => 'downloadcatalogue_id'
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

    /**
     * @return $this
     */
    protected function _prepareMassaction()
    {
        $this->setMassactionIdField('downloadcatalogue_id');
        $this->getMassactionBlock()->setFormFieldName('downloadcatalogue_id');

        $this->getMassactionBlock()->addItem(
            'delete',
            [
                'label' => __('Delete'),
                'url' => $this->getUrl('downloadcatalogue/*/massDelete'),
                'confirm' => __('Are you sure?'),
            ]
        );

        $statuses = Status::getAvailableStatuses();
        array_unshift($statuses, ['label' => '', 'value' => '']);
        $this->getMassactionBlock()->addItem(
            'status',
            [
                'label' => __('Change status'),
                'url' => $this->getUrl('downloadcatalogue/*/massStatus', ['_current' => true]),
                'additional' => [
                    'visibility' => [
                        'name' => 'status',
                        'type' => 'select',
                        'class' => 'required-entry',
                        'label' => __('Status'),
                        'values' => $statuses,
                    ],
                ],
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
        return $this->getUrl('*/*/edit', ['downloadcatalogue_id' => $row->getId()]);
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
