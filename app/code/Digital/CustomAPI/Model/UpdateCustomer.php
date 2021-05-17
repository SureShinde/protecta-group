<?php

namespace Digital\CustomAPI\Model;

use Digital\CustomAPI\Helper\Data;
use Digital\CustomAPI\Services\Customer;
use Digital\CustomAPI\Helper\CustomLogger;
use Magento\Customer\Api\CustomerRepositoryInterface;

class UpdateCustomer implements \Digital\CustomAPI\Api\UpdateCustomerInterface
{
    /**
     * @var CustomerRepositoryInterface
     */
    private $_customerRepository;

    public function __construct(
        CustomerRepositoryInterface $customerRepositoryInterface
    ) {
        $this->_customerRepository = $customerRepositoryInterface;
        $this->baseUrl = (new Data)->getBaseUrl();
    }

    /**
     * @api
     * @param mixed $customer
     * @return array
     */
    public function updatecustomer($customer) {
        try {

            $customerId = $this->getCustomerByNetSuiteId($customer['netsuiteId']);

            if($customerId && $customer['syncCustomer'] == false) {

               $response = $this->deleteCustomerById($customerId);

            } else if( $customerId && $customer['syncCustomer'] == true) {

                $response = $this->update($customer, $customerId);

            } else if(!$customerId && $customer['syncCustomer'] == true) {
                $url = $this->baseUrl . 'rest/default/V1/parentaccount';
                if(isset($customer['parentEmail'])) {
                    $parentAccountId = $this->getCustomerByEmail($customer['parentEmail']);
                    unset($customer['parentEmail']);
                    $url = $this->baseUrl . 'rest/default/V1/parentaccount/'.$parentAccountId.'/subaccounts';
                }

                unset($customer['syncCustomer']);
                $newCustomer = $this->create($customer, $url);
                if($newCustomer['response']['code'] != 200) {
                    // return $newCustomer['response']['body'];
                    return $newCustomer['response']['body']->message;
                }
                $customerId = $this->getCustomerByEmail($customer['customer']['email']);
                $response = $this->update($customer, $customerId);
            } else {
                $response = 'User with NetSuite id does not exits';
            }

            return [ 'response' =>  $response ];
        } catch (\Exception $e) {
            CustomLogger::webo_custom_logger('customer_exception', $e->getMessage());
            return [ 'response' => $e->getMessage() ];
        }
    }

    private function getCustomerByEmail( $email ) {
        $objectManager = \Magento\Framework\App\ObjectManager::getInstance();
        $customerModel = $objectManager->create('Magento\Customer\Model\Customer');
        $customerModel->setWebsiteId(1);
        $customerModel->loadByEmail($email);

        return $customerModel->getId();
    }

    private function getCustomerByNetSuiteId($netsuiteId) {
        $objectManager = \Magento\Framework\App\ObjectManager::getInstance();
        $customerObj = $objectManager->create('Magento\Customer\Model\ResourceModel\Customer\Collection');
        $customer = $customerObj->addAttributeToSelect('*')
                ->addAttributeToFilter('ns_account_no', $netsuiteId)
                ->load();
        $customerData = $customer->getData();
        if($customerData) {
            return $customerData[0]['entity_id'];
        }

        return false;
    }

    private function update( $data, $customerId ) {
        $oldCustomer = $this->_customerRepository->getById($customerId);

        $oldCustomer->setEmail($data['customer']['email']);
        $oldCustomer->setFirstname($data['customer']['firstname']);
        $oldCustomer->setLastname($data['customer']['lastname']);

        foreach($data['customAttributes'] as $customAttribute ) {
            if(isset($customAttribute['value'])) {
                $oldCustomer->setCustomAttribute($customAttribute['attributeCode'], $customAttribute['value']);

                if($customAttribute['attributeCode'] == 'ns_price_level') {
                    $customerGroup = (new Customer)->getCustomerGroupId($customAttribute['value']);
                    $oldCustomer->setGroupId($customerGroup);
                }
            }
        }

        $this->addCustomerCustomItems($customerId, $data['customerItems']);
        $this->saveAddress($customerId, $data['addresses']);

        $oldCustomer = $this->_customerRepository->save($oldCustomer);

        // return $customer->getCustomAttribute('ns_customer_id')->getValue();
        return [
            'customer' => $oldCustomer->__toArray()
        ];
    }

    private function addCustomerCustomItems($customerId, $items) {
		if(count($items) > 0) {
            $objectManager = \Magento\Framework\App\ObjectManager::getInstance();
			$customer = $objectManager->create('Magento\Customer\Model\Customer')->load($customerId);
			$custName = $customer->getName();
			$custEmail = $customer->getEmail();

			foreach($items as $item) {
				$sku = trim($item['name']);
				$newPrice = trim($item['price']);
                $qty = isset($item['qty']) ? trim($item['qty']): 1;

                $productRepository = $objectManager->get('\Magento\Catalog\Model\ProductRepository');
                $product = $productRepository->get($sku);

				$prodName = $product->getName();
                $itemId = $product->getId();
				$prodPrice = $product->getPrice();

				if($custName != '' && $custEmail != '' && $prodName != '') {
                    $customerPrice = $objectManager->create('Magedelight\Customerprice\Model\Customerprice')->getCollection()
                        ->addFieldToFilter('customer_id', array('eq' => $customerId))
                        ->addFieldToFilter('product_id', array('eq' => $itemId))
                        ->addFieldToFilter('qty', array('eq' => $qty))
                    ;
                    if(count($customerPrice) > 0)  /// update existing row
                    {
                        foreach($customerPrice as $single_item) {
                            if(isset($single_item['customerprice_id'])) {
                                $modelLoad = '';
                                $modelLoad = $objectManager->create('Magedelight\Customerprice\Model\Customerprice');
                                $modelLoad->load($single_item['customerprice_id']);
                                $modelLoad->setLogPrice($newPrice);
                                $modelLoad->setNewPrice($newPrice);
                                $modelLoad->save();
                                $modelLoad = '';
                            }
                        }
                    }
                    else  /// create new row
                    {
                        $modelCreate = '';
                        $modelCreate = $objectManager->create('Magedelight\Customerprice\Model\Customerprice');
                        $modelCreate->setCustomerId($customerId);
                        $modelCreate->setCustomerName($custName);
                        $modelCreate->setCustomerEmail($custEmail);
                        $modelCreate->setProductId($itemId);
                        $modelCreate->setProductName($prodName);
                        $modelCreate->setPrice($prodPrice);
                        $modelCreate->setLogPrice($newPrice);
                        $modelCreate->setNewPrice($newPrice);
                        $modelCreate->setQty($qty);
                        $modelCreate->save();
                        $modelCreate = '';
                    }
				}
			}
		}
    }

    public static function getProductBySku( $sku ) {
        try {
            $objectManager = \Magento\Framework\App\ObjectManager::getInstance();
            $productRepository = $objectManager->get('\Magento\Catalog\Model\ProductRepository');
            $productObj = $productRepository->get($sku);

            return $productObj;
        } catch (\Throwable $th) {

            return false;
        }
    }

    private function create( $data, $url ) {
        try {
            $authorization = 'Authorization: Bearer xfc9y8dazdxvq8yiuv0scy2rz0ds4r37';

            $crl = curl_init();
            curl_setopt($crl, CURLOPT_URL, $url);
            curl_setopt($crl, CURLOPT_CUSTOMREQUEST, 'POST');
            curl_setopt($crl, CURLOPT_HTTPHEADER, array(
                'Content-Type: application/json' ,
                $authorization
            ));
            curl_setopt($crl, CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt($crl, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($crl, CURLOPT_POSTFIELDS, json_encode($data));

            $response = array();
            $response['response']['body'] = json_decode(curl_exec($crl));
            $response['response']['code']  = curl_getinfo($crl, CURLINFO_HTTP_CODE);
            curl_close($crl);
            return $response;

        } catch (Exception $e) {
            CustomLogger::webo_custom_logger('exception', $e->getMessage());
            return $e->getMessage();
        }
    }

    private function deleteCustomerById( $customerId ) {
        $objectManager = \Magento\Framework\App\ObjectManager::getInstance();
        $customerModel = $objectManager->create('Magento\Customer\Model\Customer');
        $customerModel->setWebsiteId(1);
        $customerModel->load($customerId);
        $customerModel->setIsDeleteable(true);
        $customerModel->delete();

        return 'User deleted successfully';
    }

    private function saveAddress(  $customerId , $addresses) {
        $objectManager = \Magento\Framework\App\ObjectManager::getInstance();
        $addresss = $objectManager->get('\Magento\Customer\Model\AddressFactory');
        if($addresses) {
            foreach($addresses as $address) {
                $newAddress = $addresss->create();
                $newAddress->setCustomerId($customerId)
                ->setFirstname($address['firstname'])
                ->setLastname($address['lastname'])
                ->setCountryId($address['countryId'])
                ->setPostcode($address['postcode'])
                ->setCity($address['city'])
                ->setTelephone(isset($address['telephone']) ? $address['telephone']: '')
                // ->setCompany('GMI')
                ->setStreet($address['street'])
                ->setIsDefaultBilling($address['defaultBilling'])
                ->setIsDefaultShipping($address['defaultShipping'])
                ->setSaveInAddressBook('1');
                $newAddress->save();
            }
        }
    }
}
