<?php

namespace Cminds\MultiUserAccounts\Helper;

use Cminds\MultiUserAccounts\Api\Data\SubaccountTransportInterface;
use Cminds\MultiUserAccounts\Api\SubaccountTransportRepositoryInterface;
use Cminds\MultiUserAccounts\Model\Config as ModuleConfig;
use Magento\Customer\Api\Data\CustomerInterface;
use Magento\Customer\Model\ResourceModel\CustomerRepository;
use Magento\Customer\Model\Session\Proxy as CustomerSession;
use Magento\Framework\App\Helper\AbstractHelper;
use Magento\Framework\App\Helper\Context;

/**
 * Cminds MultiUserAccounts view helper.
 *
 * @category Cminds
 * @package  Cminds_MultiUserAccounts
 * @author   Piotr Pierzak <piotr@cminds.com>
 */
class View extends AbstractHelper
{
    /**
     * Session object.
     *
     * @var CustomerSession
     */
    private $customerSession;

    /**
     * Module config object.
     *
     * @var ModuleConfig
     */
    private $moduleConfig;

    /**
     * @var SubaccountTransportRepositoryInterface
     */
    protected $subaccountTransportRepositoryInterface;

    /**
     * @var CustomerRepository
     */
    protected $customerRepository;

    /**
     * @param Context $context
     * @param CustomerSession $customerSession
     * @param ModuleConfig $moduleConfig
     * @param SubaccountTransportRepositoryInterface $subaccountTransportRepositoryInterface
     * @param CustomerRepository $customerRepository
     */
    public function __construct(
        Context $context,
        CustomerSession $customerSession,
        ModuleConfig $moduleConfig,
        SubaccountTransportRepositoryInterface $subaccountTransportRepositoryInterface,
        CustomerRepository $customerRepository
    ) {
        $this->customerSession = $customerSession;
        $this->moduleConfig = $moduleConfig;
        $this->subaccountTransportRepositoryInterface = $subaccountTransportRepositoryInterface;
        $this->customerRepository = $customerRepository;
        parent::__construct($context);
    }

    /**
     * Concatenate all subaccount name parts into full subaccount name.
     *
     * @param SubaccountTransportInterface $subaccountTransportDataObject Subaccount
     *     transport data object.
     *
     * @return string
     */
    public function getSubaccountName(
        SubaccountTransportInterface $subaccountTransportDataObject
    ) {
        return trim(
            ($subaccountTransportDataObject->getPrefix() ? $subaccountTransportDataObject->getPrefix() . ' ' : '')
            . $subaccountTransportDataObject->getFirstname()
            . ($subaccountTransportDataObject->getMiddlename() ? ' ' . $subaccountTransportDataObject->getMiddlename() : '')
            . ' '
            . $subaccountTransportDataObject->getLastname()
            . ($subaccountTransportDataObject->getSuffix() ? ' ' . $subaccountTransportDataObject->getSuffix() : '')
        );
    }

    /**
     * Return bool value depends of that if subaccount is logged
     * in in current session.
     *
     * @param bool|false $skipForNested
     * @return bool
     */
    public function isSubaccountLoggedIn($skipForNested = false)
    {
        if ($this->moduleConfig->isNestedSubaccountsAllowed() && $skipForNested) {
            return false;
        }
        /** @var SubaccountTransportInterface $subaccountDataObject */
        $subaccountTransportDataObject = $this->customerSession
            ->getSubaccountData();

        /** @var CustomerInterface $customerDataObject */
        $customerDataObject = $this->customerSession->getCustomerData();

        if ($subaccountTransportDataObject === null) {
            return false;
        }

        $parentCustomerId = $subaccountTransportDataObject
            ->getParentCustomerId();
        $customerDataObjectId = $customerDataObject ? intval($customerDataObject->getId()) : 0;
        if ($this->moduleConfig->isSharedSessionEnabled() === true
            && (int)$parentCustomerId === $customerDataObjectId
        ) {
            return true;
        }

        $customerId = $subaccountTransportDataObject->getCustomerId();
        if ($this->moduleConfig->isSharedSessionEnabled() === false
            && (int)$customerId === $customerDataObjectId
        ) {
            return true;
        }

        return false;
    }

    /**
     * Return bool value depends of that if subaccount can manage orders
     * waiting for approval.
     *
     * @return bool
     */
    public function canManageOrderApprovals()
    {
        if (!$this->isSubaccountLoggedIn()) {
            return $this->canManageSubaccounts();
        } else {
            /** @var SubaccountTransportInterface $subaccountDataObject */
            $subaccountTransportDataObject = $this->customerSession
                ->getSubaccountData();

            $manageOrderApprovalPermission = (bool)$subaccountTransportDataObject
                ->getManageOrderApprovalPermission();
        }

        return $manageOrderApprovalPermission === true;
    }

    /**
     * Check if customer can manage subaccounts.
     *
     * @param $customerId
     *
     * @return bool
     */
    public function canManageSubaccounts($customerId = null)
    {
        $customerId = $customerId ?: $this->customerSession->getCustomerId();
        $customerModel = $this->customerRepository->getById($customerId);

        $canManageSubaccounts = $customerModel->getCustomAttribute('can_manage_subaccounts');
        if ($canManageSubaccounts !== null) {
            $canManageSubaccounts = $canManageSubaccounts->getValue();
        }

        if ($this->isSubaccountLoggedIn()) {
            if ($this->moduleConfig->isNestedSubaccountsAllowed()) {
                $subaccount = $this->subaccountTransportRepositoryInterface->getByCustomerId($customerId);
                if (!$subaccount->getManageSubaccounts()) {
                    $canManageSubaccounts = false;
                }
            } else {
                return false;
            }
        }

        return $canManageSubaccounts;
    }
}
