<?php
namespace Digital\Restrictproducts\Model\ResourceModel;
class Restrictproducts extends \Magento\Framework\Model\ResourceModel\Db\AbstractDb {
    /**
     * Initialize resource model
     *
     * @return void
     */
    protected function _construct() {
        $this->_init('restrictproducts', 'restrictproducts_id');
    }
}
?>