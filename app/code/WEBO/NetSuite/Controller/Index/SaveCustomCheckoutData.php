<?php

/**
 * *
 *  Copyright © 2016 WEBO. All rights reserved.
 *  See COPYING.txt for license details.
 *
 */

namespace WEBO\NetSuite\Controller\Index;

use WEBO\NetSuite\Helper\CustomLogger;
/**
 * Class SaveCustomCheckoutData
 * @package WEBO\NetSuite\Controller\Index
 */
class SaveCustomCheckoutData extends \Magento\Framework\App\Action\Action
{
    /**
     * @var \Magento\Checkout\Model\Sidebar
     */
    protected $_sidebar;


    /**
     * @var \Magento\Framework\Controller\Result\JsonFactory
     */
    protected $_resultJsonFactory;

    /**
     * @var \Magento\Framework\Json\Helper\Data
     */
    protected $_jsonHelper;

    /**
     * @var \Magento\Framework\DataObjectFactory
     */
    protected $_dataObjectFactory;
    /**
     * @var \Magento\Quote\Api\CartTotalRepositoryInterface
     */
    protected $_cartTotalRepositoryInterface;

    /**
     * SaveCustomCheckoutData constructor.
     * @param \Magento\Framework\App\Action\Context $context
     * @param \Magento\Framework\Json\Helper\Data $jsonHelper
     * @param \Magento\Framework\DataObjectFactory $dataObjectFactory
     * @param \Magento\Framework\Controller\Result\JsonFactory $resultJsonFactory
     * @param \Magento\Quote\Api\CartTotalRepositoryInterface $cartTotalRepositoryInterface
     * @param \Magento\Checkout\Model\Sidebar $sidebar
     */
    public function __construct(
        \Magento\Framework\App\Action\Context $context,
        \Magento\Framework\Json\Helper\Data $jsonHelper,
        \Magento\Framework\DataObjectFactory $dataObjectFactory,
        \Magento\Framework\Controller\Result\JsonFactory $resultJsonFactory,
        \Magento\Quote\Api\CartTotalRepositoryInterface $cartTotalRepositoryInterface,
        \Magento\Checkout\Model\Sidebar $sidebar
    ) {
        parent::__construct($context);
        $this->_resultJsonFactory = $resultJsonFactory;
        $this->_jsonHelper = $jsonHelper;
        $this->_dataObjectFactory = $dataObjectFactory;
        $this->_sidebar = $sidebar;
        $this->_cartTotalRepositoryInterface = $cartTotalRepositoryInterface;
    }

    /**
     *
     */
    public function execute()
    {
        // CustomLogger::webo_custom_logger('custom_api', 'custom api called');
        /** @var \Magento\Framework\DataObject $qtyData */
        $additionalData = $this->_dataObjectFactory->create([
            'data' => $this->_jsonHelper->jsonDecode($this->getRequest()->getContent()),
        ]);

        // $resultJson = $this->_resultJsonFactory->create();
        // $response = [
        //     'success' => 'true',
        //     'data'  => $additionalData->getData()
        // ];
        // $resultJson->setData($response);

        // return $resultJson;

        $this->_objectManager->get('Magento\Checkout\Model\Session')->setData('osc_delivery_date', $additionalData->getData('osc_delivery_date'));
        $this->_objectManager->get('Magento\Checkout\Model\Session')->setData('osc_comment', $additionalData->getData('osc_comment'));
        $this->_objectManager->get('Magento\Checkout\Model\Session')->setData('osc_newsletter', $additionalData->getData('osc_newsletter'));
        $this->_objectManager->get('Magento\Checkout\Model\Session')->setData('osc_security_code', $additionalData->getData('osc_security_code'));
        $this->_objectManager->get('Magento\Checkout\Model\Session')->setData('osc_delivery_time', $additionalData->getData('osc_delivery_time'));
		$this->_objectManager->get('Magento\Checkout\Model\Session')->setData('ship_po_number',  $additionalData->getData('ship_po_number'));
        $this->_objectManager->get('Magento\Checkout\Model\Session')->setData('ship_due_date',$additionalData->getData('ship_due_date'));
		$this->_objectManager->get('Magento\Checkout\Model\Session')->setData('pg_delivery_phone',  $additionalData->getData('pg_delivery_phone'));
        $this->_objectManager->get('Magento\Checkout\Model\Session')->setData('pg_delivery_contact',  $additionalData->getData('pg_delivery_contact'));
    }
}
