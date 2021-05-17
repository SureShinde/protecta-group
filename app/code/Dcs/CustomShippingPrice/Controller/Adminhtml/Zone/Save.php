<?php

namespace Dcs\CustomShippingPrice\Controller\Adminhtml\Zone;

use Magento\Backend\App\Action;
use Magento\Framework\App\Filesystem\DirectoryList;

class Save extends \Magento\Backend\App\Action
{
    /**
     * @var PostDataProcessor
     */
    protected $dataProcessor;
	protected $_filesystem;


    /**
     * @param Action\Context $context
     * @param PostDataProcessor $dataProcessor
     */
    public function __construct(
		Action\Context $context,
		PostDataProcessor $dataProcessor,
		\Magento\Framework\Filesystem $filesystem
	)
    {
        $this->dataProcessor = $dataProcessor;
		$this->_filesystem = $filesystem;
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
     * Save action
     *
     * @return void
     */
    public function execute()
    {
        $data = $this->getRequest()->getPostValue();
        if ($data) {
			
						
            $data = $this->dataProcessor->filter($data);
            $model = $this->_objectManager->create('Dcs\CustomShippingPrice\Model\CustomShippingZone');

            $id = $this->getRequest()->getParam('id');
            if ($id) {
                $model->load($id);
            }
			
			
			// save PDF data and remove from data array
            /*if (isset($data['csv_file'])) {
                $catalogueData = $data['csv_file'];
                unset($data['csv_file']);
            } else {
                $catalogueData = array();
            }*/
			
          
            $model->addData($data);

            if (!$this->dataProcessor->validate($data)) {
                $this->_redirect('*/*/edit', ['id' => $model->getId(), '_current' => true]);
                return;
            }

            try {
                $Helper = $this->_objectManager->get('Dcs\CustomShippingPrice\Helper\Data');
				
						
				
                $model->save();
				
                $this->messageManager->addSuccess(__('The Zone has been saved.'));
                $this->_objectManager->get('Magento\Backend\Model\Session')->setFormData(false);
                if ($this->getRequest()->getParam('back')) {
                    $this->_redirect('*/*/edit', ['id' => $model->getId(), '_current' => true]);
                    return;
                }
                $this->_redirect('*/*/');
                return;
            } catch (\Magento\Framework\Model\Exception $e) {
                $this->messageManager->addError($e->getMessage());
            } catch (\RuntimeException $e) {
                $this->messageManager->addError($e->getMessage());
            } catch (\Exception $e) {
                $this->messageManager->addException($e, __($e->getMessage()));
            }

            $this->_getSession()->setFormData($data);
            $this->_redirect('*/*/edit', ['id' => $this->getRequest()->getParam('id')]);
            return;
        }
        $this->_redirect('*/*/');
    }
}
