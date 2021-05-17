<?php

namespace Digital\Homebanner\Model\ResourceModel\Homebanner;

class Collection extends \Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection
{

    /**
     * Define resource model
     *
     * @return void
     */
    protected function _construct()
    {
        $this->_init('Digital\Homebanner\Model\Homebanner', 'Digital\Homebanner\Model\ResourceModel\Homebanner');
        $this->_map['fields']['page_id'] = 'main_table.page_id';
    }

}
?>