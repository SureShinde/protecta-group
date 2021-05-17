<?php

namespace Digital\Contactus\Controller\Index;

use Magento\Framework\View\Result\PageFactory;

class Index extends \Magento\Framework\App\Action\Action
{
	/**
     * @var PageFactory
     */
    protected $resultPageFactory;
    protected $_helper;
	
	/**
     * @param \Magento\Framework\App\Action\Context $context
     * @param PageFactory $resultPageFactory
     */
    public function __construct(
        \Magento\Framework\App\Action\Context $context,
        \Digital\Contactus\Helper\Data $_helper,
        PageFactory $resultPageFactory
    ) {
        $this->resultPageFactory = $resultPageFactory;
        $this->_helper = $_helper;
        parent::__construct($context);
    }
	
    /**
     * Default Contactus Index page
     *
     * @return void
     */
    public function execute()
    {   
        if(!$this->_helper->isEnabled()){
            $this->_redirect('noRoute');
            return;
       }else{
        $this->_view->loadLayout();
        //$this->_view->getLayout()->initMessages();
		$this->_view->getPage()->getConfig()->getTitle()->set(__('Contact Us'));
        
        /** @var \Magento\Framework\View\Result\Page $resultPage */
        $resultPage = $this->resultPageFactory->create();
        return $resultPage;
        }
    }
}
