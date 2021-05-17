<?php

namespace Digital\CustomAPI\Helper;

Class Data {

    public function getBaseUrl() {
        $objectManager = \Magento\Framework\App\ObjectManager::getInstance();
        $storeManager = $objectManager->get('\Magento\Store\Model\StoreManagerInterface');
        $url = $storeManager->getStore()->getBaseUrl();

        return $url;
    }
}
