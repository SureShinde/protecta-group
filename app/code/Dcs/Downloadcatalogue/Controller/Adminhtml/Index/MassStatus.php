<?php
namespace Dcs\Downloadcatalogue\Controller\Adminhtml\Index;

class MassStatus extends \Magento\Backend\App\Action
{
    /**
     * @var \Magento\Framework\View\Result\PageFactory
     */
    public function execute()
    {
		 $ids = $this->getRequest()->getParam('downloadcatalogue_id');
		 $status = $this->getRequest()->getParam('status');
		
		if (!is_array($ids) || empty($ids)) {
            $this->messageManager->addError(__('Please select product(s).'));
        } else {
            try {
                foreach ($ids as $id) {
                    $row = $this->_objectManager->get('Dcs\Downloadcatalogue\Model\Downloadcatalogue')->load($id);
					$row->setData('status',$status)
							->save();
				}
                $this->messageManager->addSuccess(
                    __('A total of %1 record(s) have been updated.', count($ids))
                );
            } catch (\Exception $e) {
                $this->messageManager->addError($e->getMessage());
            }
        }
		 $this->_redirect('*/*/');
    }
}
