<?php

/**
 * *
 *  Copyright © 2016 MagePlaza. All rights reserved.
 *  See COPYING.txt for license details.
 *
 */

namespace MagePlaza\Osc\Observer;

use Digital\CustomAPI\Helper\CustomLogger;
use Magento\Framework\Event\ObserverInterface;

/**
 * Class OrderPlaceAfter
 *
 * @category MagePlaza
 * @package  MagePlaza_Osc
 * @module   Osc
 * @author   MagePlaza Developer
 */
class OrderPlaceAfter implements ObserverInterface
{
    /**
     * @var \Magento\Checkout\Model\Session
     */
    protected $_checkoutSession;

    /**
     * @var \MagePlaza\Osc\Helper\Data
     */
    protected $_helper;

    /**
     * @var \Magento\Framework\Mail\Template\TransportBuilder
     */
    protected $_transportBuilder;

    protected $customerSession;


    /**
     * OrderPlaceAfter constructor.
     * @param \Magento\Checkout\Model\Session $checkoutSession
     * @param \Magento\Sales\Model\Order\Email\Sender\OrderSender $sender
     * @param \MagePlaza\Osc\Helper\Data $helper
     */
    public function __construct(
        \Magento\Checkout\Model\Session $checkoutSession,
        \MagePlaza\Osc\Helper\Data $helper,
        \Magento\Customer\Model\Session $customerSession,
        \Magento\Framework\App\ResourceConnection $_resourceconnection
    )
    {
        $this->_checkoutSession = $checkoutSession;
        $this->_helper = $helper;
        $this->_customerSession = $customerSession;
        $this->_resourceconnection = $_resourceconnection;
    }

    /**
     * @param \Magento\Framework\Event\Observer $observer
     *
     * @return void
     * @SuppressWarnings(PHPMD.UnusedFormalParameter)
     */
    public function execute(\Magento\Framework\Event\Observer $observer)
    {

        $order = $observer->getEvent()->getOrder();
        CustomLogger::webo_custom_logger('observer', $order->getData());
        $comment = $this->_checkoutSession->getData('osc_comment', true);
        if ($comment) {
            $order->addStatusHistoryComment($comment);
        }
		die();
		$ship_po_number = $this->_checkoutSession->getData('ship_po_number', true);
		if ($ship_po_number) {
            $order->setShipPoNumber($ship_po_number);
	    }
		$ship_due_date = $this->_checkoutSession->getData('ship_due_date', true);
        if ($ship_due_date) {
           $order->setShipDueDate($ship_due_date);
        }

		$pg_delivery_phone = $this->_checkoutSession->getData('pg_delivery_phone', true);
        if ($pg_delivery_phone) {
           $order->setPgDeliveryPhone($pg_delivery_phone);
        }

        $pg_delivery_contact = $this->_checkoutSession->getData('pg_delivery_contact', true);
        if ($pg_delivery_contact) {
           $order->setPgDeliveryContact($pg_delivery_contact);
        }

        $ship_zone = '';
        $ship_int_id = '';
        $ship_int_id = str_replace("dcsshipping_dcsshipping_delivery_","",$order->getShippingMethod());
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

        $itemCollection = $order->getAllItems();
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
            if ($order->getShippingAddress()) {
                $sendEmail = $order->getShippingAddress()->getEmail();
            } elseif ($order->getBillingAddress()) {
                $sendEmail = $order->getBillingAddress()->getEmail();
            } else {
                $sendEmail = '';
            }
            if ($sendEmail) {
                $this->_helper->addSubscriber($sendEmail);
            }
        }
    }
}
