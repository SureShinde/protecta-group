<?php
namespace Digital\Warehouse\Block;

class Warehouse extends \Magento\Framework\View\Element\Template
{
   
    protected $_dataHelper;
    
    protected function _prepareLayout(){
        return parent::_prepareLayout();
    }
    
    public function __construct(
        \Magento\Framework\View\Element\Template\Context $context,
        \Digital\Warehouse\Helper\Data $dataHelper,
        array $data = []
    ) {
        $this->_dataHelper = $dataHelper;
        parent::__construct(
            $context,
            $data
        );
    }
	public function isEnabledModule()
    {
		 return $this->_dataHelper->isEnabled();
    }
    
    public function getHelper()
    {
		 return $this->_dataHelper;
    }
    
    
}
