<?php 
error_reporting(E_ALL);
ini_set('display_errors', 1);
ini_set('max_execution_time', 0);
ini_set('memory_limit', '-1');
set_time_limit(0);
use Magento\Framework\App\Bootstrap;
include('app/bootstrap.php');
$bootstrap = Bootstrap::create(BP, $_SERVER);
$objectManager = $bootstrap->getObjectManager();

$state = $objectManager->get('\Magento\Framework\App\State');
$state->setAreaCode('frontend');
$indexerFactory = $objectManager->get(\Magento\Indexer\Model\IndexerFactory::class);
$indexerCollectionFactory = $objectManager->get(\Magento\Indexer\Model\Indexer\CollectionFactory::class);
$indexerCollection = $indexerCollectionFactory->create();
   $ids = $indexerCollection->getAllIds();	
   foreach ($ids as $id) {
   $idx = $indexerFactory->create()->load($id);
   $idx->reindexAll($id); // this reindexes all
   }

$cacheTypeList = $objectManager->get(\Magento\Framework\App\Cache\TypeListInterface::class);
$cacheFrontendPool = $objectManager->get(\Magento\Framework\App\Cache\Frontend\Pool::class);
$types = array('config','layout','block_html','collections','reflection','db_ddl','eav','config_integration','config_integration_api','full_page','translate','config_webservice');
foreach ($types as $type) {
   $cacheTypeList->cleanType($type);
}
foreach ($cacheFrontendPool as $cacheFrontend) {
    $cacheFrontend->getBackend()->clean();
}
?>