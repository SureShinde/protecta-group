<?php

namespace WEBO\NetSuite\Observer\Sales;

use Magento\Framework\Event\Observer;
use WEBO\NetSuite\Helper\CustomLogger;
use Digital\CustomAPI\Helper\NetSuiteRestlet;
use WEBO\NetSuite\Helper\SendSyncFailedEmail;
use Magento\Framework\Event\ObserverInterface;
use Magento\Sales\Api\OrderRepositoryInterface;
use Digital\CustomAPI\Services\NetSuiteServices;

class SyncOrderToNetsuite implements ObserverInterface
{
    /**
     * @var OrderRepositoryInterface
     */
    private $_orderRepository;

    public function __construct(
        OrderRepositoryInterface $orderRepositoryInterface,
        \Magento\Framework\App\ResourceConnection $resourceconnection
    ) {
        $this->_orderRepository = $orderRepositoryInterface;
        $this->_resourceconnection = $resourceconnection;
    }

    public function execute(Observer $observer)
    {
        try {
            $orderObj = $observer->getEvent()->getOrder();
            $incrementId = $orderObj->getIncrementId();
            $customerId = $orderObj->getCustomerId();
            if($customerId == null) {
                CustomLogger::webo_custom_logger('ordersync_error', 'Customer is not logged in');
                return $this;
            }

            $orderId = $orderObj->getId();
            $order = $this->_orderRepository->get($orderId);
            $orderData = $order->getData();
            $deliveryInfo = json_decode($orderData['mp_delivery_information']);
            $params['order_id'] = $incrementId;
            $params['items'] = $this->getOrderLineItems($orderObj);
            $params['shipping_address'] = $orderObj->getShippingAddress()->getData();
            $params['billing_address'] = $orderObj->getBillingAddress()->getData();
            $params['required_date'] = $orderData['ship_due_date'];
            $params['po_number'] = $orderData['ship_po_number'];
            $params['shipping_method'] = $orderData['shipping_description'];
            $params['shipping_cost'] = $orderData['shipping_amount'];
            $params['delivery_contact'] = $orderData['pg_delivery_contact'];
            $params['delivery_contact_phone'] = $orderData['pg_delivery_phone'];
            $params['special_instruction'] = $deliveryInfo->deliveryComment;

            $customerdata = $this->getCustomerById($customerId);
            if(!isset($customerdata['ns_account_no'])) {
                // TODO::
                //throw email regarding order being not synced to NetSuite
                return $this;
            }
            $params['contact_id'] = $customerdata['ns_account_no'];
            $parentNsAccountId = $this->getParentNsAccountId($customerId);
            if(!$parentNsAccountId) {
                $params['customer_id'] = $customerdata['ns_account_no'];
            } else {
                $params['customer_id'] = $parentNsAccountId;
            }

            $payment = $order->getPayment();
            $method = $payment->getMethodInstance();
            $methodTitle = $method->getTitle();
            $params['payment_method'] = $this->setPaymentMethod($methodTitle);
            $params['payment_title'] = $methodTitle;

            $reqParams = [
                'action' => 'addSalesOrder',
                'data' => $params
            ];
            CustomLogger::webo_custom_logger('order_params', $reqParams);

            $netSuiteRestlet = new NetSuiteRestlet();
            $response = $netSuiteRestlet->callRestlet('POST', null, $reqParams);
            CustomLogger::webo_custom_logger('order_response', $response);
            if(empty($response['response']['body']) || $response['response']['body']->statusCode == 400) {
                // (new SendSyncFailedEmail)->sendEmail($response['response']['body']->message);
                return $this;
            }

            $ns_order_id = $response['response']['body']->payload->orderId;
            $this->updateOrderWithNetSuiteOrderId($orderId, $ns_order_id);

        } catch (\Exception $e) {
            CustomLogger::webo_custom_logger('order_failed', $e->getMessage());
        }

        return $this;
    }

    /**
     * Retrieve a customer from database for given customer ID
     * @param int $customerId, ID of the customer that is to be fetched
     * @return array, Array of customer data
     */
    public function getCustomerById($customerId) {
        $objectManager = \Magento\Framework\App\ObjectManager::getInstance();
        $customer = $objectManager->create('Magento\Customer\Model\Customer')->load($customerId);

        return $customer->getData();
    }

    /**
     * Create an array of sales order items items for given sales order object
     * @param object $orderObj, newly created sales order object'
     * @return array, Array of items for given sales order
     */
    public function getOrderLineItems($orderObj) {
        $items = [];
        foreach($orderObj->getAllItems() as $orderItem){
            $product = $this->getProductData($orderItem->getProductId());
            $item['internalID'] = $product['pg_internal_id'];
            $item['quantity_order'] = intval($orderItem->getQtyOrdered());
            $item['price'] = $orderItem->getPrice();

            array_push($items, $item);
        }

        return $items;
    }

    /**
     * Retrieve a product from database for given product ID
     * @param int $productId, ID of the product that is to be fetched
     * @return array, Array of product data
     */
    public function getProductData($productId) {
        $objectManager = \Magento\Framework\App\ObjectManager::getInstance();
        $product = $objectManager->create('Magento\Catalog\Model\Product')->load($productId);

        return $product->getData();
    }

    /**
     * Retrieve child account record from cminds_multiuseraccounts_subaccount table for given customer id
     * @param int $customerId, ID of the customer whose record is to be fetched
     * @return array, Array containing the single child account record if found for given customer ID, else return empty array
     */
    public function getSubAccount($customerId) {
        $objectManager = \Magento\Framework\App\ObjectManager::getInstance();
        $resource = $objectManager->get('Magento\Framework\App\ResourceConnection');
        $connection = $resource->getConnection();
        $select_query = "SELECT * FROM `cminds_multiuseraccounts_subaccount` WHERE `cminds_multiuseraccounts_subaccount`.`customer_id` = '$customerId'";
        $res = $connection->fetchAll($select_query);

        return $res;
    }

    /**
     * Retrieve the NetSuite ID for given customer's parent account if the requesting user if a child account,
     * else returns false
     * @param int $customerId, ID of the child customer whose parent's NetSuite ID is to be fetched
     * @return int, NetSuite ID of a customer
     */
    public function getParentNsAccountId($customerId) {
        $subAccount = $this->getSubAccount($customerId);
        if(!$subAccount) return false;

        $parentAccount = $this->getCustomerById($subAccount[0]['parent_customer_id']);
        return $parentAccount['ns_account_no'];
    }

    /**
     * Set the NetSuite sales order ID on newly crated sales order
     * @param int $orderId, ID of the sales order for which NetSuite Id is to be set
     * @param int $nsOrderId, NetSuite order to be updated for given order
     */
    public function updateOrderWithNetSuiteOrderId($orderId, $nsOrderId){
        $connection = $this->_resourceconnection->getConnection('core_write');
        $sql = "UPDATE `sales_order` SET ns_order_id = ?  WHERE entity_id = ? ";
        $connection->query($sql, array($nsOrderId, $orderId));
    }

    public function setPaymentMethod($paymentText) {
        switch ($paymentText) {
            case 'Bank Transfer Payment':
                $paymentMethod = 7;
                break;
            case 'Credit Card - eWAY':
                $paymentMethod = 1;
                break;
            default:
                $paymentMethod = '';
                break;
        }
        return $paymentMethod;
    }
}
