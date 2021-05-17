<?php

namespace Dcs\CustomShippingPrice\Controller\Adminhtml\Zone;

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
            __('CustomShippingZone'),
            __('CustomShippingZone')
        )->addBreadcrumb(
            __('Manage CustomShippingZone'),
            __('Manage CustomShippingZone')
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
        $model = $this->_objectManager->create('Dcs\CustomShippingPrice\Model\CustomShippingZone');
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
        $this->_coreRegistry->register('customshippingzone', $model);		
		/** @var \Magento\Backend\Model\View\Result\Page $resultPage */
        $resultPage = $this->_initAction();
        $resultPage->addBreadcrumb(
            $id ? __('Edit Digital Shipping Zone') : __('New Digital Shipping Zone'),
            $id ? __('Edit Digital Shipping Zone') : __('New Digital Shipping Zone')
        );
        $resultPage->getConfig()->getTitle()->prepend($id ? __('Digital Shipping Zone') : __('Digital Shipping Zone'));        
        return $resultPage;
    }
}
