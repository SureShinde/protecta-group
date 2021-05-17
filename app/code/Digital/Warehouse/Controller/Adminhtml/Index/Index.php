<?php



namespace Digital\Warehouse\Controller\Adminhtml\Index;



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

        return $this->_authorization->isAllowed('Digital_Warehouse::warehouse_manage');

    }



    /**

     * Warehouse List action

     *

     * @return void

     */

    public function execute()

    {

        /** @var \Magento\Backend\Model\View\Result\Page $resultPage */

        $resultPage = $this->resultPageFactory->create();

        $resultPage->setActiveMenu(

            'Digital_Warehouse::warehouse_manage'

        )->addBreadcrumb(

            __('Warehouse'),

            __('Warehouse')

        )->addBreadcrumb(

            __('Manage Warehouse'),

            __('Manage Warehouse')

        );

        $resultPage->getConfig()->getTitle()->prepend(__('Manage Warehouses'));

        return $resultPage;

    }

}

