<?php
namespace Digital\Homeimage\Model;
class Homeimage extends \Magento\Framework\Model\AbstractModel {
    /**
     * Initialize resource model
     *
     * @return void
     */
    protected function _construct()
    {
        $this->_init('Digital\Homeimage\Model\ResourceModel\Homeimage');
    }
}
?>