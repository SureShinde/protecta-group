<?php

namespace Dcs\Updateaccount\Controller\Adminhtml\Index;

use Magento\Backend\App\Action;

class Save extends \Magento\Backend\App\Action
{
    /**
     * @var PostDataProcessor
     */
    protected $dataProcessor;

    /**
     * @param Action\Context $context
     * @param PostDataProcessor $dataProcessor
     */
    public function __construct(Action\Context $context, PostDataProcessor $dataProcessor)
    {
        $this->dataProcessor = $dataProcessor;
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
     * Save action
     *
     * @return void
     */
    public function execute()
    {
        $data = $this->getRequest()->getPostValue();
        if ($data) {
            $data = $this->dataProcessor->filter($data);
            $model = $this->_objectManager->create('Dcs\Updateaccount\Model\Updateaccount');

            $id = $this->getRequest()->getParam('updateaccount_id');
            if ($id) {
                $model->load($id);
            }
          /*  if (isset($data['image1'])) {
                //$imageData1 = $data['image1'];
                unset($data['image1']);
            } else {
                $imageData1 = array();
            }
            if (isset($data['image2'])) {
                //$imageData2 = $data['image2'];
                unset($data['image2']);
            } else {
                $imageData2 = array();
            }
			if (isset($data['image3'])) {
                //$imageData3 = $data['image3'];
                unset($data['image3']);
            } else {
                $imageData3 = array();
            } */
            $model->addData($data);

            if (!$this->dataProcessor->validate($data)) {
                $this->_redirect('*/*/edit', ['updateaccount_id' => $model->getId(), '_current' => true]);
                return;
            }

            try {
                $imageHelper = $this->_objectManager->get('Dcs\Updateaccount\Helper\Data');

              
                $model->save();
                $this->messageManager->addSuccess(__('The Data has been saved.'));
                $this->_objectManager->get('Magento\Backend\Model\Session')->setFormData(false);
                if ($this->getRequest()->getParam('back')) {
                    $this->_redirect('*/*/edit', ['updateaccount_id' => $model->getId(), '_current' => true]);
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
            $this->_redirect('*/*/edit', ['updateaccount_id' => $this->getRequest()->getParam('updateaccount_id')]);
            return;
        }
        $this->_redirect('*/*/');
    }
}
