<?php

namespace Dcs\Updateaccount\Controller\Adminhtml\Index;

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
        return $this->_authorization->isAllowed('Dcs_Updateaccount::save');
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
            'Dcs_Updateaccount::updateaccount'
        )->addBreadcrumb(
            __('Updateaccount'),
            __('Updateaccount')
        )->addBreadcrumb(
            __('Manage Updateaccount'),
            __('Manage Updateaccount')
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
        $id = $this->getRequest()->getParam('updateaccount_id');
        $model = $this->_objectManager->create('Dcs\Updateaccount\Model\Updateaccount');
		if ($id) {
            $model->load($id);
            if (!$model->getId()) {
                $this->messageManager->addError(__('This updateaccount no longer exists.'));
				/** \Magento\Backend\Model\View\Result\Redirect $resultRedirect */
                $resultRedirect = $this->resultRedirectFactory->create();
                return $resultRedirect->setPath('*/*/');
            }
        }
		$data = $this->_objectManager->get('Magento\Backend\Model\Session')->getFormData(true);
        if (!empty($data)) {
            $model->setData($data);
        }
        $this->_coreRegistry->register('updateaccount', $model);
		/** @var \Magento\Backend\Model\View\Result\Page $resultPage */
        $resultPage = $this->_initAction();
        $resultPage->addBreadcrumb(
            $id ? __('Edit Updateaccount') : __('New Updateaccount'),
            $id ? __('Edit Updateaccount') : __('New Updateaccount')
        );
        $resultPage->getConfig()->getTitle()->prepend($id ? __('View Update Account Request') : __('New Updateaccount'));
        /* $resultPage->getConfig()->getTitle()->prepend(__('Updateaccount'));
        $resultPage->getConfig()->getTitle()
            ->prepend($model->getId() ? $model->getTitle() : __('New Updateaccount'));
            $resultPage->getConfig()->getTitle()->prepend(__('Account Update Request Information')); */
        return $resultPage;
    }
}
