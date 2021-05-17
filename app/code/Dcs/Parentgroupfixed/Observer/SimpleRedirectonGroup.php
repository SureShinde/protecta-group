<?php
namespace Dcs\Parentgroupfixed\Observer;

use Magento\Framework\Event\Observer;
use Magento\Framework\Event\ObserverInterface;

class SimpleRedirectonGroup implements ObserverInterface
{
    protected $_redirect;
    protected $_productTypeConfigurable;
    protected $_productRepository;
    protected $_storeManager;

    public function __construct(
        \Magento\Framework\App\Response\Http $redirect,
        \Magento\ConfigurableProduct\Model\ResourceModel\Product\Type\Configurable $productTypeConfigurable,
        \Magento\Catalog\Model\ProductRepository $productRepository,
        \Magento\Store\Model\StoreManagerInterface $storeManager
    )
    {
        $this->_redirect = $redirect;
        $this->_productTypeConfigurable = $productTypeConfigurable;
        $this->_productRepository = $productRepository;
        $this->_storeManager = $storeManager;
    }

    public function execute(Observer $observer)
    {
		$request = $observer->getEvent()->getRequest();
		$simpleProductId = $request->getParam('id');
		if (!$simpleProductId) {
			return;
		}

		$simpleProduct = $this->_productRepository->getById($simpleProductId, false, $this->_storeManager->getStore()->getId());
		if (!$simpleProduct || $simpleProduct->getTypeId() != \Magento\Catalog\Model\Product\Type::TYPE_SIMPLE) {
			return;
		}

		$objectManager = \Magento\Framework\App\ObjectManager::getInstance();
		$resource = $objectManager->get('Magento\Framework\App\ResourceConnection');
		$connection = $resource->getConnection();
		$sql = "SELECT parent_id FROM `catalog_product_relation` where `child_id` =".$simpleProductId;
		$result = $connection->fetchAll($sql);
		if(isset($result[0]['parent_id']) && (int)$result[0]['parent_id'] > 0 )
		{
			$parentProduct = $objectManager->create('Magento\Catalog\Model\Product')->load($result[0]['parent_id']);
			$parentUrl	   = $parentProduct->getUrlModel()->getUrl($parentProduct);
		}
		else
		{
			$simpleProduct = $objectManager->create('Magento\Catalog\Model\Product')->load($simpleProductId);
			$parentUrl	= $simpleProduct->getUrlModel()->getUrl($simpleProduct);
		}

		$this->_redirect->setRedirect($parentUrl, 301);
    }
}
