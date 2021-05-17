<?php

namespace Dcs\Downloadcatalogue\Controller\Adminhtml\Index;

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
        return $this->_authorization->isAllowed('Dcs_Downloadcatalogue::save');
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
            $model = $this->_objectManager->create('Dcs\Downloadcatalogue\Model\Downloadcatalogue');
			
            $id = $this->getRequest()->getParam('downloadcatalogue_id');
            if ($id) {
                $model->load($id);
            }
            
            // save image data and remove from data array
            if (isset($data['image'])) {
                $imageData = $data['image'];
                unset($data['image']);
            } else {
                $imageData = array();
            }
			
			// save PDF data and remove from data array
            if (isset($data['catalogue_file'])) {
                $catalogueData = $data['catalogue_file'];
                unset($data['catalogue_file']);
            } else {
                $catalogueData = array();
            }

            $model->addData($data);

            if (!$this->dataProcessor->validate($data)) {
                $this->_redirect('*/*/edit', ['downloadcatalogue_id' => $model->getId(), '_current' => true]);
                return;
            }

            try {
                $Helper = $this->_objectManager->get('Dcs\Downloadcatalogue\Helper\Data');
				
				// Image Save & Delete
                if (isset($imageData['delete']) && $model->getImage()) {
                    $Helper->removeImage($model->getImage());
                    $model->setImage(null);
                }                
                $imageFile = $Helper->uploadImage('image');
                if ($imageFile) {
					$temp="resources/image".$imageFile;					
                    $model->setImage($temp);
                }
				
				// PDF Save & Delete
                if (isset($catalogueData['delete']) && $model->getCatalogueFile()) {
                    $Helper->removePdf($model->getCatalogueFile());
                    $model->setCatalogueFile(null);
                }                
                $pdfFile = $Helper->uploadPDF('catalogue_file');
                if ($pdfFile) {
					$temp="resources/pdf".$pdfFile;
                    $model->setCatalogueFile($temp);
                }
				
                
                $model->save();
                $this->messageManager->addSuccess(__('The Data has been saved.'));
                $this->_objectManager->get('Magento\Backend\Model\Session')->setFormData(false);
                if ($this->getRequest()->getParam('back')) {
                    $this->_redirect('*/*/edit', ['downloadcatalogue_id' => $model->getId(), '_current' => true]);
                    return;
                }
                $this->_redirect('*/*/');
                return;
            } catch (\Magento\Framework\Model\Exception $e) {
                $this->messageManager->addError($e->getMessage());
            } catch (\RuntimeException $e) {
                $this->messageManager->addError($e->getMessage());
            } catch (\Exception $e) {
                $this->messageManager->addException($e, __('Something went wrong while saving the data.'));
            }

            $this->_getSession()->setFormData($data);
            $this->_redirect('*/*/edit', ['downloadcatalogue_id' => $this->getRequest()->getParam('downloadcatalogue_id')]);
            return;
        }
        $this->_redirect('*/*/');
    }
}
