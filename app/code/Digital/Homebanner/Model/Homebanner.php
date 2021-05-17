<?php
namespace Digital\Homebanner\Model;

class Homebanner extends \Magento\Framework\Model\AbstractModel
{
    /**
     * Initialize resource model
     *
     * @return void
     */
    protected function _construct()
    {
        $this->_init('Digital\Homebanner\Model\ResourceModel\Homebanner');
    }
}
?>