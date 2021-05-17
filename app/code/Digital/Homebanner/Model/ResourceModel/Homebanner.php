<?php
namespace Digital\Homebanner\Model\ResourceModel;

class Homebanner extends \Magento\Framework\Model\ResourceModel\Db\AbstractDb
{
    /**
     * Initialize resource model
     *
     * @return void
     */
    protected function _construct()
    {
        $this->_init('digital_homebanner', 'banner_id');
    }
}
?>