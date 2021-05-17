<?php

namespace Digital\Warehouse\Controller\Index;

use Magento\Store\Model\ScopeInterface;
use Magento\Framework\App\Action\Context;
use Digital\CustomAPI\Helper\CustomLogger;
use Magento\Framework\View\Result\PageFactory;
use Magento\Framework\Controller\ResultFactory;
use Digital\Warehouse\Controller\AbstractAction;
use Magento\Framework\App\Filesystem\DirectoryList;

class Post extends \Magento\Framework\App\Action\Action
{
	const XML_PATH_CUSTOMER_EMAIL  = 'warehouse/view/email_template';
	const XML_PATH_ADMIN_EMAIL  = 'warehouse/view/admin_email';
	const XML_PATH_EMAIL_SENDER = 'warehouse/email/sender_email_identity';

	public function __construct(
        Context $context,
		\Magento\Framework\Controller\ResultFactory $resultFactory,
		\Magento\Framework\Controller\Result\JsonFactory $resultJsonFactory,
		\Magento\Framework\Translate\Inline\StateInterface $StateInterface,
		\Magento\Store\Model\StoreManagerInterface $StoreManagerInterface,
		\Digital\Warehouse\Helper\Data $helperWarehouse,
		\Digital\Warehouse\Model\Warehouse $_warehouseModel,

		\Digital\Warehouse\Helper\Email $emailHelper
    ){
        parent::__construct($context);
		$this->resultFactory = $resultFactory;
		$this->resultJsonFactory = $resultJsonFactory;
		$this->StateInterface = $StateInterface;
		$this->StoreManagerInterface = $StoreManagerInterface;
		$this->_warehouseModel = $_warehouseModel;

		$this->helperWarehouse = $helperWarehouse;
		$this->EmailHelper = $emailHelper;
    }

	public function execute()
	{
		$resultRedirect = $this->resultFactory->create(ResultFactory::TYPE_REDIRECT);
		$response = array();

		$address = $this->getRequest()->getParam('address');
		$center_lat = $this->getRequest()->getParam('lat');
		$center_lng = $this->getRequest()->getParam('lng');
		$radius = $this->getRequest()->getParam('radius');

		$collection = $this->_warehouseModel->getCollection();

		//$distance = sprintf( "3959 * 1.60934 * acos( cos( radians(%s) ) * cos( radians( lat ) ) * cos( radians( lng ) - radians(%s) ) + sin( radians(%s) ) * sin( radians( lat ) ) )", $center_lat, $center_lng, $center_lat);
		if($center_lat!='' && $center_lng!='') {
			$objectManager = \Magento\Framework\App\ObjectManager::getInstance();
			$resource = $objectManager->get('Magento\Framework\App\ResourceConnection');
			$connection = $resource->getConnection();
			$sql = "SELECT warehouse_id,warehouse_code,warehouse_name, ( 3959 * 1.60934 * acos( cos( radians(".$center_lat.") ) * cos( radians( lat ) ) * cos( radians( lng ) - radians(".$center_lng.") ) + sin( radians(".$center_lat.") ) * sin(radians(lat)) ) ) AS distance FROM digital_warehouse HAVING distance < 20000 ORDER BY distance LIMIT 0 , 1";
			$result = $connection->fetchAll($sql);
			if(isset($result)&& count($result)>0) {
				//$collection->addExpressionFieldToSelect('distance', $distance, array('lat'=>'lat', 'lng'=>'lng'));
				//$collection->getSelect()->having('distance < ' . $radius)->order('distance','ASC');

				$cartObject = $objectManager->create('Magento\Checkout\Model\Cart')->truncate();
				$cartObject->saveQuote();

				$customerSession = $this->helperWarehouse->getCustomerSession();
				$customerSession->setLocationSession($result[0]['warehouse_code']);

				$response = [
					'status' => 'success',
					'message' => $result[0]['warehouse_name'],
				];
			} else {
				$response = [
					'status' => 'success',
					'message' => 'There is not any store close to the specified suburb or postcode. Please try searching with another suburb or postcode.',
				];
			}
		} else {
			$response = [
				'status' => 'error',
				'message' => 'Invalid post data',
			];
		}

		$resultJson = $this->resultJsonFactory->create();
		return $resultJson->setData($response);
    }
}
