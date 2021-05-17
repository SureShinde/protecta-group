<?php

namespace Digital\CustomAPI\Block\Plugin\AttributeMerger;

use Digital\CustomAPI\Helper\CustomLogger;
use Magento\Checkout\Block\Checkout\AttributeMerger;

class PlaceholderAttributeMerger {

    public function afterMerge(AttributeMerger $subject, $result)
    {
        if (array_key_exists('street', $result)) {
            $result['street']['label'] = '';
            $result['street']['children'][0]['placeholder'] = __('STREET ADDRESS');
        }
        if (array_key_exists('firstname', $result)) {
            $result['firstname']['placeholder'] = __('FIRST NAME');
        }

        if (array_key_exists('lastname', $result)) {
            $result['lastname']['placeholder'] = __('LAST NAME');
        }

        if (array_key_exists('city', $result)) {
            $result['city']['placeholder'] = __('CITY');
        }

        if (array_key_exists('postcode', $result)) {
            $result['postcode']['placeholder'] = __('POSTCODE');
        }

        if (array_key_exists('mposc_field_1', $result)) {
            $result['mposc_field_1']['placeholder'] = __('DELIVERY CONTACT');
        }

        if (array_key_exists('mposc_field_2', $result)) {
            $result['mposc_field_2']['placeholder'] = __('DELIVERY PHONE');
        }

        return $result;
    }
}
