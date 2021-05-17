<?php

namespace Cminds\MultiUserAccounts\Model\Plugin\Customer\DataProvider;

use Cminds\MultiUserAccounts\Api\SubaccountRepositoryInterface;
use Magento\Customer\Model\Customer\DataProvider;
use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Framework\App\Request\Http;

class Plugin
{
    /**
     * Subaccount repository object.
     *
     * @var SubaccountRepositoryInterface
     */
    private $subaccountRepository;

    /**
     * Http Request Object.
     *
     * @var Http
     */
    private $request;

    /**
     * Plugin constructor.
     *
     * @param SubaccountRepositoryInterface $subaccountRepository
     * @param Http $http
     */
    public function __construct(
        SubaccountRepositoryInterface $subaccountRepository,
        Http $http
    ) {
        $this->subaccountRepository = $subaccountRepository;
        $this->request = $http;
    }

    /**
     * Set customer edit form data with the parent_account_id value.
     *
     * @param DataProvider $dataProvider
     * @param array $data
     *
     * @return array
     */
    public function afterGetData(
        DataProvider $dataProvider,
        $data
    ) {
        if (!$data) {
            return $data;
        }

        //iterate only one time because array contains only one element
        foreach ($data as $customerId => $customerFormData) {
            if (!isset($customerFormData['customer'])) {
                break;
            }

            try {
                $subaccountModel = $this->subaccountRepository
                    ->getByCustomerId($customerId);

                $data[$customerId]['customer']['parent_account_id'] = $subaccountModel
                    ->getParentCustomerId();

            } catch (NoSuchEntityException $exception) {
                break;
            }
        }

        return $data;
    }

    /**
     * Filter which fields to display.
     *
     * @param DataProvider $dataProvider
     * @param array $data
     *
     * @return array
     */
    public function afterGetMeta(
        DataProvider $dataProvider,
        $data
    ) {
        $id = $this->request->getParam('id');
        if (!$id) {
            return $data;
        }

        /** If there is no entity with id $id, then the code will be automatically executed in the catch block. */
        try {
            $this->subaccountRepository->getByCustomerId($id);

            $exists = true;
        } catch (\Exception $exception) {
            $exists = false;
        }

        if ($exists) {
            unset($data['customer']['children']['can_manage_subaccounts']);
        }

        return $data;
    }
}
