<?php

namespace Digital\Contactus\Controller\Adminhtml\Index;

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
        return $this->_authorization->isAllowed('Digital_Contactus::contactus_manage');
    }

    /**
     * Contactus List action
     *
     * @return void
     */
    public function execute()
    {
        /** @var \Magento\Backend\Model\View\Result\Page $resultPage */
        $resultPage = $this->resultPageFactory->create();
        $resultPage->setActiveMenu(
            'Digital_Contactus::contactus_manage'
        )->addBreadcrumb(
            __('Contactus'),
            __('Contactus')
        )->addBreadcrumb(
            __('Manage Contact Us'),
            __('Manage Contact Us')
        );
        $resultPage->getConfig()->getTitle()->prepend(__('Contact Enquiries'));
        return $resultPage;
    }
}
