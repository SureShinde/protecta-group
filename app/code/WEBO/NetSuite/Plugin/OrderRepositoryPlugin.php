<?php

namespace WEBO\NetSuite\Plugin;

use WEBO\NetSuite\Helper\CustomLogger;
use Magento\Sales\Api\Data\OrderInterface;
use Magento\Sales\Api\OrderRepositoryInterface;
use Magento\Sales\Api\Data\OrderExtensionFactory;
use Magento\Sales\Api\Data\OrderExtensionInterface;
use Magento\Sales\Api\Data\OrderSearchResultInterface;

/**
 * Class OrderRepositoryPlugin
 */
class OrderRepositoryPlugin
{
    /**
     * Order ship_po_number field name
     */
    //const FIELD_NAME = 'ship_po_number';

    /**
     * Order Extension Attributes Factory
     *
     * @var OrderExtensionFactory
     */
    protected $extensionFactory;

    /**
     * OrderRepositoryPlugin constructor
     *
     * @param OrderExtensionFactory $extensionFactory
     */
    public function __construct(OrderExtensionFactory $extensionFactory)
    {
        $this->extensionFactory = $extensionFactory;
    }

    /**
     * Add "ship_po_number" extension attribute to order data object to make it accessible in API data
     *
     * @param OrderRepositoryInterface $subject
     * @param OrderInterface $order
     *
     * @return OrderInterface
     */
    public function afterGet(OrderRepositoryInterface $subject, OrderInterface $order)
    {
        // $ship_po_number = $order->getData('ship_po_number');
		// $ship_due_date = $order->getData('ship_due_date');
        $pg_delivery_phone = $order->getData('pg_delivery_phone');
        $pg_delivery_contact = $order->getData('pg_delivery_contact');

        $extensionAttributes = $order->getExtensionAttributes();
        $extensionAttributes = $extensionAttributes ? $extensionAttributes : $this->extensionFactory->create();

		// $extensionAttributes->setShipPoNumber($ship_po_number);
		// $extensionAttributes->setShipDueDate($ship_due_date);

        $extensionAttributes->setPgDeliveryPhone($pg_delivery_phone);
        $extensionAttributes->setPgDeliveryContact($pg_delivery_contact);

		$order->setExtensionAttributes($extensionAttributes);

        return $order;
    }

    /**
     * Add "ship_po_number" extension attribute to order data object to make it accessible in API data
     *
     * @param OrderRepositoryInterface $subject
     * @param OrderSearchResultInterface $searchResult
     *
     * @return OrderSearchResultInterface
     */
    public function afterGetList(OrderRepositoryInterface $subject, OrderSearchResultInterface $searchResult)
    {
        $orders = $searchResult->getItems();
        foreach ($orders as &$order) {

			$ship_po_number = $order->getData('ship_po_number');
			$ship_due_date = $order->getData('ship_due_date');

            $pg_delivery_phone = $order->getData('pg_delivery_phone');
            $pg_delivery_contact = $order->getData('pg_delivery_contact');


            $extensionAttributes = $order->getExtensionAttributes();
            $extensionAttributes = $extensionAttributes ? $extensionAttributes : $this->extensionFactory->create();

			$extensionAttributes->setShipPoNumber($ship_po_number);
			$extensionAttributes->setShipDueDate($ship_due_date);

            $extensionAttributes->setPgDeliveryPhone($pg_delivery_phone);
            $extensionAttributes->setPgDeliveryContact($pg_delivery_contact);

			$order->setExtensionAttributes($extensionAttributes);
        }

        return $searchResult;
    }
}
