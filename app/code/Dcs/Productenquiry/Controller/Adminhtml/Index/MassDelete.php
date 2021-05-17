<?php
namespace Dcs\Productenquiry\Controller\Adminhtml\Index;

class MassDelete extends \Magento\Backend\App\Action
{
    public function execute()
    {
		$ids = $this->getRequest()->getParam('enquiry_id');
		$resultRedirect = $this->resultRedirectFactory->create();
		if (!is_array($ids) || empty($ids)) {
            $this->messageManager->addError(__('Please select item(s).'));
        } else {
            try {
                foreach ($ids as $id) {					
                    $row = $this->_objectManager->get('Dcs\Productenquiry\Model\Productenquiry')->load($id);
					$row->delete();
				}
                $this->messageManager->addSuccess(
                    __('A total of %1 record(s) have been deleted.', count($ids))
                );
            } catch (\Exception $e) {
                $this->messageManager->addError($e->getMessage());
            }
        }
		 return $resultRedirect->setPath('*/*/');
    }
}
