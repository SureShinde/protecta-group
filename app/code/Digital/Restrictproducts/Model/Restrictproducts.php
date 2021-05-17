<?php
namespace Digital\Restrictproducts\Model;
class Restrictproducts extends \Magento\Framework\Model\AbstractModel {
    /**
     * Initialize resource model
     *
     * @return void
     */
    protected function _construct()
    {
        $this->_init('Digital\Restrictproducts\Model\ResourceModel\Restrictproducts');
    }
}
?>