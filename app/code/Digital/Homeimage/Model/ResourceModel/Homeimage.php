<?php
namespace Digital\Homeimage\Model\ResourceModel;
class Homeimage extends \Magento\Framework\Model\ResourceModel\Db\AbstractDb {
    /**
     * Initialize resource model
     *
     * @return void
     */
    protected function _construct() {
        $this->_init('digital_homeimage', 'banner_id');
    }
}
?>