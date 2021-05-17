<?php

namespace Dcs\Updateaccount\Controller\Index;

use Magento\Framework\View\Result\PageFactory;

class Index extends \Magento\Framework\App\Action\Action
{
	/**
     * @var PageFactory
     */
    protected $resultPageFactory;
	
	/**
     * @param \Magento\Framework\App\Action\Context $context
     * @param PageFactory $resultPageFactory
     */
    public function __construct(
        \Magento\Framework\App\Action\Context $context,
        \Magento\Customer\Model\Session $customerSession,
        PageFactory $resultPageFactory
    ) {
        $this->resultPageFactory = $resultPageFactory;
        $this->customerSession = $customerSession;
        parent::__construct($context);
    }
	
    /**
     * Default Updateaccount Index page
     *
     * @return void
     */
    public function execute()
    {
		if(!$this->customerSession->isLoggedIn()){
			$this->_redirect('customer/account/login');
			return;
		}
        $resultPage = $this->resultPageFactory->create();
        return $resultPage;
    }
}
