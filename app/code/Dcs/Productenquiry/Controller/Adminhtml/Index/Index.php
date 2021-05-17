<?php



namespace Dcs\Productenquiry\Controller\Adminhtml\Index;



use Magento\Backend\App\Action\Context;

use Magento\Framework\View\Result\PageFactory;



class Index extends \Magento\Backend\App\Action

{

	

    protected $resultPageFactory;



  

    public function __construct(

        Context $context,

        PageFactory $resultPageFactory

    ) {

        parent::__construct($context);

        $this->resultPageFactory = $resultPageFactory;

    }

	

    protected function _isAllowed()

    {

        return $this->_authorization->isAllowed('Dcs_Productenquiry::manage');

    }



    

    public function execute()

    {

        $resultPage = $this->resultPageFactory->create();

        $resultPage->setActiveMenu(

            'Dcs_Productenquiry::manage'

        )->addBreadcrumb(

            __('Product Enquiry'),

            __('Product Enquiry')

        )->addBreadcrumb(

            __('Manage Product Enquiry'),

            __('Manage Product Enquiry')

        );

        $resultPage->getConfig()->getTitle()->prepend(__('Product Enquiries'));

        return $resultPage;

    }

}

