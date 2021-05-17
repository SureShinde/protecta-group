<?php

namespace Dcs\CustomShippingPrice\Controller\Adminhtml\Index;

use Magento\Backend\App\Action;

class Edit extends \Magento\Backend\App\Action
{
    /**
     * Core registry
     *
     * @var \Magento\Framework\Registry
     */
    protected $_coreRegistry = null;
	
	/**
     * @var \Magento\Framework\View\Result\PageFactory
     */
    protected $resultPageFactory;

    /**
     * @param Action\Context $context
	 * @param \Magento\Framework\View\Result\PageFactory $resultPageFactory
     * @param \Magento\Framework\Registry $registry
     */
    public function __construct(Action\Context $context, \Magento\Framework\View\Result\PageFactory $resultPageFactory, \Magento\Framework\Registry $registry)
    {
        $this->resultPageFactory = $resultPageFactory;
		$this->_coreRegistry = $registry;
        parent::__construct($context);
    }

    /**
     * {@inheritdoc}
     */
    protected function _isAllowed()
    {
        return $this->_authorization->isAllowed('Dcs_CustomShippingPrice::save');
    }

    /**
     * Init actions
     *
     * @return $this
     */
    protected function _initAction()
    {
		/** @var \Magento\Backend\Model\View\Result\Page $resultPage */
        $resultPage = $this->resultPageFactory->create();
        $resultPage->setActiveMenu(
            'Dcs_CustomShippingPrice::customshippingprice'
        )->addBreadcrumb(
            __('CustomShippingPrice'),
            __('CustomShippingPrice')
        )->addBreadcrumb(
            __('Manage CustomShippingPrice'),
            __('Manage CustomShippingPrice')
        );
        return $resultPage;
    }

    /**
     * Edit CMS page
     *
     * @return void
     */
    public function execute()
    {
        $id = $this->getRequest()->getParam('id');
        $model = $this->_objectManager->create('Dcs\CustomShippingPrice\Model\CustomShippingPrice');
		if ($id) {
            $model->load($id);
            if (!$model->getId()) {
                $this->messageManager->addError(__('This customshippingprice no longer exists.'));
				/** \Magento\Backend\Model\View\Result\Redirect $resultRedirect */
                $resultRedirect = $this->resultRedirectFactory->create();
                return $resultRedirect->setPath('*/*/');
            }
        }
		$data = $this->_objectManager->get('Magento\Backend\Model\Session')->getFormData(true);
        if (!empty($data)) {
            $model->setData($data);
        }
        $this->_coreRegistry->register('customshippingprice', $model);
		/** @var \Magento\Backend\Model\View\Result\Page $resultPage */
        $resultPage = $this->_initAction();
        $resultPage->addBreadcrumb(
            $id ? __('Edit Digital Shipping Method') : __('New Digital Shipping Method'),
            $id ? __('Edit Digital Shipping Method') : __('New Digital Shipping Method')
        );
        $resultPage->getConfig()->getTitle()->prepend($id ? __('Digital Shipping Method') : __('Digital Shipping Method'));        
        return $resultPage;
    }
}
