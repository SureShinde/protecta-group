<?php

namespace Digital\CustomAPI\Services;

use Digital\CustomAPI\Helper\CustomLogger;
use Digital\CustomAPI\Helper\NetSuiteRestlet;

class NetSuiteServices {

    public function getCategories() {
        try {
            return $this->_callRestlet('GET', 'getCategories');
        } catch (\Exception $e) {
            throw new \Exception('Could not fetch categories from NetSuite');
        }
    }

    public function getProducts() {
        try {
            return $this->_callRestlet('GET', 'getItems');
        } catch (\Exception $e) {
            throw new \Exception('Could fetch products from NetSuite');
        }
    }

    public function getPriceMatrices( $nsInternalId ) {
        try {
            $reqParams = [
                'action' => 'getPriceMatrix',
                'data' => [ 'itemId' => $nsInternalId ]
            ];

            return $this->_callRestlet('POST', null, $reqParams);
        } catch (\Exception $e) {
            CustomLogger::webo_custom_logger('Exception', $e->getMessage());
            // throw new \Exception('Could fetch products from NetSuite');
            return false;
        }
    }

    public function createSalesOrder( $order ) {
        try {
            $reqParams = [
                'action' => 'addSalesOrder',
                'data' => $order
            ];
            $response = (new NetSuiteRestlet)->callRestlet( 'POST', null, $reqParams );
            if($response['response']['body']->statusCode == 400) {
                throw new \Exception($response['response']['body']->message);
            }

            return $response['response']['body']->payload->orderId;
        } catch (\Exception $e) {
            throw new \Exception($e->getMessage());
        }
    }

    public function getFreightMatrix() {
        try {
            return $this->_callRestlet('GET', 'getFreightMatrix');
        } catch (\Exception $e) {
            throw new \Exception('Could fetch freight cost matrix from NetSuite');
        }
    }

    public function getItemBinLocation($nsInternalId) {
        try {
            $reqParams = [
                'action' => 'getItemBinLocation',
                'data' => [ 'itemId' => $nsInternalId ]
            ];

            return $this->_callRestlet('POST', null, $reqParams);
        } catch (\Exception $e) {
            return false;
        }
    }

    public function createCustomer($customer) {
        try {
            $reqParams = [
                'data' => $customer,
                'action' => 'addCustomer'
            ];

            return $this->_callRestlet('POST', null, $reqParams);
        } catch (\Exception $e) {
            CustomLogger::webo_custom_logger('customer_exception', $e->getMessage());
            throw new \Exception('Could not create customer on NetSuite ');
        }
    }

    public function createContact($contact) {
        try {
            $reqParams = [
                'data' => $contact,
                'action' => 'addContact'
            ];

            return $this->_callRestlet('POST', null, $reqParams);
        } catch (\Exception $e) {
            CustomLogger::webo_custom_logger('contact_exception', $e->getMessage());
            throw new \Exception('Could not create contact on NetSuite ');
        }
    }

    public function _callRestlet($requestType, $action = null, $reqParams = null) {
        try {
            $response = (new NetSuiteRestlet)->callRestlet( $requestType, $action, $reqParams );
            if($response['response']['code'] != 200 || empty($response['response']['body'])) {
                CustomLogger::webo_custom_logger('restlet_error', $response['response']);
                throw new \Exception('Could fetch record from NetSuite');
            }

            return $response['response']['body'];
        } catch (\Exception $e) {
            CustomLogger::webo_custom_logger('Exception', $e->getMessage());
            throw new \Exception($e->getMessage());
        }
    }
}
