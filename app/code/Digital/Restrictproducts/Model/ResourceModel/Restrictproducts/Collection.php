<?php
namespace Digital\Restrictproducts\Model\ResourceModel\Restrictproducts;
class Collection extends \Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection {
    /**
     * Define resource model
     *
     * @return void
     */
    protected function _construct() {
        $this->_init('Digital\Restrictproducts\Model\Restrictproducts', 'Digital\Restrictproducts\Model\ResourceModel\Restrictproducts');
        $this->_map['fields']['page_id'] = 'main_table.page_id';
    }
}
?>