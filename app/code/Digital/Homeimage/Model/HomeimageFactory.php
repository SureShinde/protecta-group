<?php
namespace Digital\Homeimage\Model;
class HomeimageFactory {
    /**
     * @var \Magento\Framework\ObjectManagerInterface
     */
    protected $_objectManager;
    /**
     * @param \Magento\Framework\ObjectManagerInterface $objectManager
     */
    public function __construct(\Magento\Framework\ObjectManagerInterface $objectManager) {
        $this->_objectManager = $objectManager;
    }
    /**
     * Create new country model
     *
     * @param array $arguments
     * @return \Magento\Directory\Model\Country
     */
    public function create(array $arguments = []) {
        return $this->_objectManager->create('Digital\Homeimage\Model\Homeimage', $arguments, false);
    }
}