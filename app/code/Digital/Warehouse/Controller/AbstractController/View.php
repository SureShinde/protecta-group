<?php

namespace Digital\Warehouse\Controller\AbstractController;

use Magento\Framework\App\Action;
use Magento\Framework\View\Result\PageFactory;

abstract class View extends Action\Action
{
    /**
     * @var \Digital\Warehouse\Controller\AbstractController\WarehouseLoaderInterface
     */
    protected $warehouseLoader;
	
	/**
     * @var PageFactory
     */
    protected $resultPageFactory;

    /**
     * @param Action\Context $context
     * @param OrderLoaderInterface $orderLoader
	 * @param PageFactory $resultPageFactory
     */
    public function __construct(Action\Context $context, WarehouseLoaderInterface $warehouseLoader, PageFactory $resultPageFactory)
    {
        $this->warehouseLoader = $warehouseLoader;
		$this->resultPageFactory = $resultPageFactory;
        parent::__construct($context);
    }

    /**
     * Warehouse view page
     *
     * @return void
     */
    public function execute()
    {
        if (!$this->warehouseLoader->load($this->_request, $this->_response)) {
            return;
        }

        /** @var \Magento\Framework\View\Result\Page $resultPage */
        $resultPage = $this->resultPageFactory->create();
		return $resultPage;
    }
}
