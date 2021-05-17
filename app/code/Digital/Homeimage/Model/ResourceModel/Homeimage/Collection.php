<?php
namespace Digital\Homeimage\Model\ResourceModel\Homeimage;
class Collection extends \Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection {
    /**
     * Define resource model
     *
     * @return void
     */
    protected function _construct() {
        $this->_init('Digital\Homeimage\Model\Homeimage', 'Digital\Homeimage\Model\ResourceModel\Homeimage');
        $this->_map['fields']['page_id'] = 'main_table.page_id';
    }
}
?>