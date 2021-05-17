<?php

namespace WEBO\NetSuite\Observer\Sales;

use WEBO\NetSuite\Helper\CustomLogger;

class SaveOrderAfter implements \Magento\Framework\Event\ObserverInterface {

    /**
     * @var \Magento\Checkout\Model\Session
     */
    protected $_checkoutSession;

    /**
     * @var \Magento\Framework\App\ResourceConnection
     */
    protected $_resourceconnection;

    /**
     * @var \Magento\Customer\Model\Session
     */
    protected $_customerSession;

    public function __construct(
        \Magento\Checkout\Model\Session $checkoutSession,
        \Magento\Framework\App\ResourceConnection $resourceconnection,
        \Magento\Customer\Model\Session $customerSession
    ) {
        $this->_checkoutSession = $checkoutSession;
        $this->_resourceconnection = $resourceconnection;
        $this->_customerSession = $customerSession;
    }

    /**
     * @param \Magento\Framework\Event\Observer $observer
     *
     * @return void
     */
    public function execute(\Magento\Framework\Event\Observer $observer)
    {
        $orderObj = $observer->getEvent()->getOrder();
        $comment = $this->_checkoutSession->getData('osc_comment', true);
        if ($comment) {
            $orderObj->addStatusHistoryComment($comment);
        }

		$ship_po_number = $this->_checkoutSession->getData('ship_po_number', true);
		if ($ship_po_number) {
            $orderObj->setShipPoNumber($ship_po_number);
	    }
		$ship_due_date = $this->_checkoutSession->getData('ship_due_date', true);
        if ($ship_due_date) {
           $orderObj->setShipDueDate($ship_due_date);
        }

		$pg_delivery_phone = $this->_checkoutSession->getData('pg_delivery_phone', true);
        if ($pg_delivery_phone) {
           $orderObj->setPgDeliveryPhone($pg_delivery_phone);
        }

        $pg_delivery_contact = $this->_checkoutSession->getData('pg_delivery_contact', true);
        if ($pg_delivery_contact) {
           $orderObj->setPgDeliveryContact($pg_delivery_contact);
        }

        $ship_zone = '';
        $ship_int_id = '';
        $ship_int_id = str_replace("dcsshipping_dcsshipping_delivery_","",$orderObj->getShippingMethod());

        if(is_numeric($ship_int_id))
        {
            $readConnection = $this->_resourceconnection->getConnection('core_read');
            $query_get_zone = "SELECT * FROM `digital_matrixrate` WHERE `internal_id`='".$ship_int_id."' LIMIT 1";
            $results_get_zone = $readConnection->fetchAll($query_get_zone);
            if(count($results_get_zone)>0)
            {
                $ship_zone = $results_get_zone[0]['zone'];
            }
        }

        $pg_delivery_location = $this->_customerSession->getLocationSession();

        $itemCollection = $orderObj->getAllItems();
        foreach ($itemCollection as $orderItem)
        {
            $quoteItemId = $orderItem->getQuoteItemId();
            if ($pg_delivery_location)
            {
                $orderItem->setPgDeliveryLocation($pg_delivery_location);
            }
            if($ship_zone)
            {
                $orderItem->setPgDeliveryZone($ship_zone);
            }
        }

        $isSubscriber =  $this->_checkoutSession->getData('osc_newsletter', true);
        if ($isSubscriber) {
            if ($orderObj->getShippingAddress()) {
                $sendEmail = $orderObj->getShippingAddress()->getEmail();
            } elseif ($orderObj->getBillingAddress()) {
                $sendEmail = $orderObj->getBillingAddress()->getEmail();
            } else {
                $sendEmail = '';
            }
            if ($sendEmail) {
                CustomLogger::webo_custom_logger('email', 'send email');
                // $this->_helper->addSubscriber($sendEmail);
            }
        }

        return $this;
    }
}
