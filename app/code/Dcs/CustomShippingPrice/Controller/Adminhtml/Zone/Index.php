<?php

namespace Dcs\CustomShippingPrice\Controller\Adminhtml\Zone;

use Magento\Backend\App\Action\Context;
use Magento\Framework\View\Result\PageFactory;

class Index extends \Magento\Backend\App\Action
{
	/**
     * @var PageFactory
     */
    protected $resultPageFactory;

    /**
     * @param Context $context
     * @param PageFactory $resultPageFactory
     */
    public function __construct(
        Context $context,
        PageFactory $resultPageFactory
    ) {
        parent::__construct($context);
        $this->resultPageFactory = $resultPageFactory;
    }
	
    /**
     * Check the permission to run it
     *
     * @return bool
     */
    protected function _isAllowed()
    {
        return $this->_authorization->isAllowed('Dcs_CustomShippingPrice::customshippingzone_manage');
    }

    public function execute()
    {		
        /** @var \Magento\Backend\Model\View\Result\Page $resultPage */
        $resultPage = $this->resultPageFactory->create();
        $resultPage->setActiveMenu(
            'Dcs_CustomShippingPrice::customshippingzone'
        )->addBreadcrumb(
            __('Manage Digital Shipping Zone'),
            __('Manage Digital Shipping Zone')
        )->addBreadcrumb(
            __('Manage Digital Shipping Zone'),
            __('Manage Digital Shipping Zone')
        );
        $resultPage->getConfig()->getTitle()->prepend(__('Manage Digital Shipping Zone'));
        return $resultPage;
    }
}
