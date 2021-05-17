<?php

namespace Dcs\CustomShippingPrice\Controller\Adminhtml\Index;

use Magento\Backend\App\Action;
use Digital\CustomAPI\Services\NetSuiteServices;
class Save extends \Magento\Backend\App\Action
{
    public function __construct(Action\Context $context)
    {
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
        $model = $this->_objectManager->create('Dcs\CustomShippingPrice\Model\CustomShippingPrice');

        $id = $this->getRequest()->getParam('id');
        if ($id) {
            $model->load($id);
        }
        
        $objectManager = \Magento\Framework\App\ObjectManager::getInstance();
        $resource = $objectManager->get('Magento\Framework\App\ResourceConnection');
        $connection = $resource->getConnection();
        $tableName = $resource->getTableName('digital_matrixrate');
        $sql = "TRUNCATE table ".$tableName."";

        $connection->query($sql);
        try {
            $fregitMetrices = (new NetSuiteServices)->getFreightMatrix();
            
            foreach($fregitMetrices as $freightMatrix) {
                $data['internal_id'] = trim($freightMatrix->internal_id);				
                $data['country_name'] = trim($freightMatrix->country_name);					
                $data['region_name'] = trim($freightMatrix->region_name);

                if(trim($freightMatrix->region_name)=='ACT') { $data['region_id'] = '569';}
                else if(trim($freightMatrix->region_name)=='NSW') { $data['region_id'] = '570';}
                else if(trim($freightMatrix->region_name)=='NT') { $data['region_id'] = '571';}
                else if(trim($freightMatrix->region_name)=='QLD') { $data['region_id'] = '572';}
                else if(trim($freightMatrix->region_name)=='SA') { $data['region_id'] = '573';}
                else if(trim($freightMatrix->region_name)=='TAS') { $data['region_id'] = '574';}
                else if(trim($freightMatrix->region_name)=='VIC') { $data['region_id'] = '575';}
                else if(trim($freightMatrix->region_name)=='WA') { $data['region_id'] = '576';}
                else{$data['region_id'] = '';}

                $data['zone'] = trim($freightMatrix->zone);							
                $data['zip_from'] = trim($freightMatrix->zip_from);						
                $data['zip_to'] = trim($freightMatrix->zip_to);						
                $data['weight_from'] = trim($freightMatrix->weight_from);						
                $data['weight_to'] = trim($freightMatrix->weight_to);						
                $data['volume_from'] = trim($freightMatrix->volume_from);						
                $data['volume_to'] = trim($freightMatrix->volume_to);
                $data['profile_name'] = trim($freightMatrix->profile_name);
                $data['price'] = trim($freightMatrix->price);
                $data['delivery_type'] = trim($freightMatrix->delivery_type);
                $data['shipping_description'] = trim($freightMatrix->shipping_description);


                $model->setData($data);
                $model->save();
            }
            
            $this->messageManager->addSuccess(__('Freight cost matrix synced successfully'));
            $this->_objectManager->get('Magento\Backend\Model\Session')->setFormData(false);
            if ($this->getRequest()->getParam('back')) {
                $this->_redirect('*/*/edit', ['customshippingprice_id' => $model->getId(), '_current' => true]);
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
        $this->_redirect('*/*/edit', ['customshippingprice_id' => $this->getRequest()->getParam('customshippingprice_id')]);
        return;
        
        $this->_redirect('*/*/');
    }
}
