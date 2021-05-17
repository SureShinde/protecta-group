<?php

namespace Digital\Contactus\Controller\AbstractController;

use Magento\Framework\App\Action;
use Magento\Framework\View\Result\PageFactory;

abstract class View extends Action\Action
{
    /**
     * @var \Digital\Contactus\Controller\AbstractController\ContactusLoaderInterface
     */
    protected $contactusLoader;
	
	/**
     * @var PageFactory
     */
    protected $resultPageFactory;

    /**
     * @param Action\Context $context
     * @param OrderLoaderInterface $orderLoader
	 * @param PageFactory $resultPageFactory
     */
    public function __construct(Action\Context $context, ContactusLoaderInterface $contactusLoader, PageFactory $resultPageFactory)
    {
        $this->contactusLoader = $contactusLoader;
		$this->resultPageFactory = $resultPageFactory;
        parent::__construct($context);
    }

    /**
     * Contactus view page
     *
     * @return void
     */
    public function execute()
    {
        if (!$this->contactusLoader->load($this->_request, $this->_response)) {
            return;
        }

        /** @var \Magento\Framework\View\Result\Page $resultPage */
        $resultPage = $this->resultPageFactory->create();
		return $resultPage;
    }
}
