<?php
namespace Dcs\Updateaccount\Block;

class Updateaccount extends \Magento\Framework\View\Element\Template
{
    /**
     * Updateaccount collection
     *
     * @var Dcs\Updateaccount\Model\ResourceModel\Updateaccount\Collection
     */
    protected $_updateaccountCollection = null;
    protected $_customerSession; 
    /**
     * Updateaccount factory
     *
     * @var \Dcs\Updateaccount\Model\UpdateaccountFactory
     */
    protected $_updateaccountCollectionFactory;
    
    /** @var \Dcs\Updateaccount\Helper\Data */
    protected $_dataHelper;
    
    /**
     * @param \Magento\Framework\View\Element\Template\Context $context
     * @param \Dcs\Updateaccount\Model\ResourceModel\Updateaccount\CollectionFactory $updateaccountCollectionFactory
     * @param array $data
     */
    public function __construct(
        \Magento\Framework\View\Element\Template\Context $context,
        \Dcs\Updateaccount\Model\ResourceModel\Updateaccount\CollectionFactory $updateaccountCollectionFactory,
        \Dcs\Updateaccount\Helper\Data $dataHelper,
        \Magento\Customer\Model\Session $customerSession,
        array $data = []
    ) {
        $this->_updateaccountCollectionFactory = $updateaccountCollectionFactory;
        $this->_dataHelper = $dataHelper;
        $this->_customerSession = $customerSession;
        parent::__construct(
            $context,
            $data
        );
    }
    protected function _prepareLayout()
	{
		parent::_prepareLayout();
		return $this;
	}
}
