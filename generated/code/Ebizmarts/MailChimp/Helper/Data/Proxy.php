<?php
namespace Ebizmarts\MailChimp\Helper\Data;

/**
 * Proxy class for @see \Ebizmarts\MailChimp\Helper\Data
 */
class Proxy extends \Ebizmarts\MailChimp\Helper\Data implements \Magento\Framework\ObjectManager\NoninterceptableInterface
{
    /**
     * Object Manager instance
     *
     * @var \Magento\Framework\ObjectManagerInterface
     */
    protected $_objectManager = null;

    /**
     * Proxied instance name
     *
     * @var string
     */
    protected $_instanceName = null;

    /**
     * Proxied instance
     *
     * @var \Ebizmarts\MailChimp\Helper\Data
     */
    protected $_subject = null;

    /**
     * Instance shareability flag
     *
     * @var bool
     */
    protected $_isShared = null;

    /**
     * Proxy constructor
     *
     * @param \Magento\Framework\ObjectManagerInterface $objectManager
     * @param string $instanceName
     * @param bool $shared
     */
    public function __construct(\Magento\Framework\ObjectManagerInterface $objectManager, $instanceName = '\\Ebizmarts\\MailChimp\\Helper\\Data', $shared = true)
    {
        $this->_objectManager = $objectManager;
        $this->_instanceName = $instanceName;
        $this->_isShared = $shared;
    }

    /**
     * @return array
     */
    public function __sleep()
    {
        return ['_subject', '_isShared', '_instanceName'];
    }

    /**
     * Retrieve ObjectManager from global scope
     */
    public function __wakeup()
    {
        $this->_objectManager = \Magento\Framework\App\ObjectManager::getInstance();
    }

    /**
     * Clone proxied instance
     */
    public function __clone()
    {
        $this->_subject = clone $this->_getSubject();
    }

    /**
     * Get proxied instance
     *
     * @return \Ebizmarts\MailChimp\Helper\Data
     */
    protected function _getSubject()
    {
        if (!$this->_subject) {
            $this->_subject = true === $this->_isShared
                ? $this->_objectManager->get($this->_instanceName)
                : $this->_objectManager->create($this->_instanceName);
        }
        return $this->_subject;
    }

    /**
     * {@inheritdoc}
     */
    public function isMailChimpEnabled($store = null)
    {
        return $this->_getSubject()->isMailChimpEnabled($store);
    }

    /**
     * {@inheritdoc}
     */
    public function isDoubleOptInEnabled($store = null)
    {
        return $this->_getSubject()->isDoubleOptInEnabled($store);
    }

    /**
     * {@inheritdoc}
     */
    public function getApiKey($store = null, $scope = null)
    {
        return $this->_getSubject()->getApiKey($store, $scope);
    }

    /**
     * {@inheritdoc}
     */
    public function getApi($store = null, $scope = null)
    {
        return $this->_getSubject()->getApi($store, $scope);
    }

    /**
     * {@inheritdoc}
     */
    public function resetMapFields()
    {
        return $this->_getSubject()->resetMapFields();
    }

    /**
     * {@inheritdoc}
     */
    public function getMapFields($storeId = null)
    {
        return $this->_getSubject()->getMapFields($storeId);
    }

    /**
     * {@inheritdoc}
     */
    public function getDateFormat()
    {
        return $this->_getSubject()->getDateFormat();
    }

    /**
     * {@inheritdoc}
     */
    public function getApiByApiKey($apiKey, $encrypted = false)
    {
        return $this->_getSubject()->getApiByApiKey($apiKey, $encrypted);
    }

    /**
     * {@inheritdoc}
     */
    public function getConfigValue($path, $storeId = null, $scope = null)
    {
        return $this->_getSubject()->getConfigValue($path, $storeId, $scope);
    }

    /**
     * {@inheritdoc}
     */
    public function deleteConfig($path, $storeId = null, $scope = null)
    {
        return $this->_getSubject()->deleteConfig($path, $storeId, $scope);
    }

    /**
     * {@inheritdoc}
     */
    public function saveConfigValue($path, $value, $storeId = null, $scope = null)
    {
        return $this->_getSubject()->saveConfigValue($path, $value, $storeId, $scope);
    }

    /**
     * {@inheritdoc}
     */
    public function getMCMinSyncing($storeId)
    {
        return $this->_getSubject()->getMCMinSyncing($storeId);
    }

    /**
     * {@inheritdoc}
     */
    public function getCartUrl($storeId, $cartId, $token)
    {
        return $this->_getSubject()->getCartUrl($storeId, $cartId, $token);
    }

    /**
     * {@inheritdoc}
     */
    public function getRedemptionUrl($storeId, $couponId, $token)
    {
        return $this->_getSubject()->getRedemptionUrl($storeId, $couponId, $token);
    }

    /**
     * {@inheritdoc}
     */
    public function getSuccessInterestUrl($storeId)
    {
        return $this->_getSubject()->getSuccessInterestUrl($storeId);
    }

    /**
     * {@inheritdoc}
     */
    public function getDefaultList($store = null)
    {
        return $this->_getSubject()->getDefaultList($store);
    }

    /**
     * {@inheritdoc}
     */
    public function getLogger()
    {
        return $this->_getSubject()->getLogger();
    }

    /**
     * {@inheritdoc}
     */
    public function log($message, $store = null, $file = null)
    {
        return $this->_getSubject()->log($message, $store, $file);
    }

    /**
     * {@inheritdoc}
     */
    public function getModuleVersion()
    {
        return $this->_getSubject()->getModuleVersion();
    }

    /**
     * {@inheritdoc}
     */
    public function deleteStore($mailchimpStore)
    {
        return $this->_getSubject()->deleteStore($mailchimpStore);
    }

    /**
     * {@inheritdoc}
     */
    public function markAllBatchesAs($mailchimpStore, $fromStatus, $toStatus)
    {
        return $this->_getSubject()->markAllBatchesAs($mailchimpStore, $fromStatus, $toStatus);
    }

    /**
     * {@inheritdoc}
     */
    public function cancelAllPendingBatches($mailchimpStore)
    {
        return $this->_getSubject()->cancelAllPendingBatches($mailchimpStore);
    }

    /**
     * {@inheritdoc}
     */
    public function restoreAllCanceledBatches($mailchimpStore)
    {
        return $this->_getSubject()->restoreAllCanceledBatches($mailchimpStore);
    }

    /**
     * {@inheritdoc}
     */
    public function markRegisterAsModified($registerId, $type)
    {
        return $this->_getSubject()->markRegisterAsModified($registerId, $type);
    }

    /**
     * {@inheritdoc}
     */
    public function getMCStoreName($storeId)
    {
        return $this->_getSubject()->getMCStoreName($storeId);
    }

    /**
     * {@inheritdoc}
     */
    public function getBaserUrl($storeId, $type)
    {
        return $this->_getSubject()->getBaserUrl($storeId, $type);
    }

    /**
     * {@inheritdoc}
     */
    public function createStore($listId, $storeId)
    {
        return $this->_getSubject()->createStore($listId, $storeId);
    }

    /**
     * {@inheritdoc}
     */
    public function getMCMinSyncDateFlag($storeId = null)
    {
        return $this->_getSubject()->getMCMinSyncDateFlag($storeId);
    }

    /**
     * {@inheritdoc}
     */
    public function getBaseDir()
    {
        return $this->_getSubject()->getBaseDir();
    }

    /**
     * {@inheritdoc}
     */
    public function getMergeVars(\Magento\Customer\Model\Customer $customer, $storeId)
    {
        return $this->_getSubject()->getMergeVars($customer, $storeId);
    }

    /**
     * {@inheritdoc}
     */
    public function getMergeVarsBySubscriber(\Magento\Newsletter\Model\Subscriber $subscriber, $email = null)
    {
        return $this->_getSubject()->getMergeVarsBySubscriber($subscriber, $email);
    }

    /**
     * {@inheritdoc}
     */
    public function getMergeVarsByCustomer(\Magento\Customer\Model\Customer $customer, $email)
    {
        return $this->_getSubject()->getMergeVarsByCustomer($customer, $email);
    }

    /**
     * {@inheritdoc}
     */
    public function getGeneralList($storeId)
    {
        return $this->_getSubject()->getGeneralList($storeId);
    }

    /**
     * {@inheritdoc}
     */
    public function getListForMailChimpStore($mailchimpStoreId, $apiKey)
    {
        return $this->_getSubject()->getListForMailChimpStore($mailchimpStoreId, $apiKey);
    }

    /**
     * {@inheritdoc}
     */
    public function getDateMicrotime()
    {
        return $this->_getSubject()->getDateMicrotime();
    }

    /**
     * {@inheritdoc}
     */
    public function resetErrors($mailchimpStore)
    {
        return $this->_getSubject()->resetErrors($mailchimpStore);
    }

    /**
     * {@inheritdoc}
     */
    public function resetEcommerce()
    {
        return $this->_getSubject()->resetEcommerce();
    }

    /**
     * {@inheritdoc}
     */
    public function saveEcommerceData($storeId, $entityId, $type, $date = null, $error = null, $modified = null, $deleted = null, $token = null, $sent = null)
    {
        return $this->_getSubject()->saveEcommerceData($storeId, $entityId, $type, $date, $error, $modified, $deleted, $token, $sent);
    }

    /**
     * {@inheritdoc}
     */
    public function markEcommerceAsDeleted($relatedId, $type, $relatedDeletedId = null)
    {
        return $this->_getSubject()->markEcommerceAsDeleted($relatedId, $type, $relatedDeletedId);
    }

    /**
     * {@inheritdoc}
     */
    public function ecommerceDeleteAllByIdType($id, $type, $mailchimpStoreId)
    {
        return $this->_getSubject()->ecommerceDeleteAllByIdType($id, $type, $mailchimpStoreId);
    }

    /**
     * {@inheritdoc}
     */
    public function deleteAllByBatchId($batchId)
    {
        return $this->_getSubject()->deleteAllByBatchId($batchId);
    }

    /**
     * {@inheritdoc}
     */
    public function getChimpSyncEcommerce($storeId, $id, $type)
    {
        return $this->_getSubject()->getChimpSyncEcommerce($storeId, $id, $type);
    }

    /**
     * {@inheritdoc}
     */
    public function loadStores()
    {
        return $this->_getSubject()->loadStores();
    }

    /**
     * {@inheritdoc}
     */
    public function saveJsUrl($storeId, $scope = null, $mailChimpStoreId = null)
    {
        return $this->_getSubject()->saveJsUrl($storeId, $scope, $mailChimpStoreId);
    }

    /**
     * {@inheritdoc}
     */
    public function getJsUrl($storeId)
    {
        return $this->_getSubject()->getJsUrl($storeId);
    }

    /**
     * {@inheritdoc}
     */
    public function getWebhooksKey()
    {
        return $this->_getSubject()->getWebhooksKey();
    }

    /**
     * {@inheritdoc}
     */
    public function createWebHook($apikey, $listId)
    {
        return $this->_getSubject()->createWebHook($apikey, $listId);
    }

    /**
     * {@inheritdoc}
     */
    public function deleteWebHook($apikey, $listId)
    {
        return $this->_getSubject()->deleteWebHook($apikey, $listId);
    }

    /**
     * {@inheritdoc}
     */
    public function loadListSubscribers($listId, $mail)
    {
        return $this->_getSubject()->loadListSubscribers($listId, $mail);
    }

    /**
     * {@inheritdoc}
     */
    public function getMagentoStoreIdsByListId($listId)
    {
        return $this->_getSubject()->getMagentoStoreIdsByListId($listId);
    }

    /**
     * {@inheritdoc}
     */
    public function loadListCustomers($listId, $email)
    {
        return $this->_getSubject()->loadListCustomers($listId, $email);
    }

    /**
     * {@inheritdoc}
     */
    public function getTableName($tableName, $conn = 'default')
    {
        return $this->_getSubject()->getTableName($tableName, $conn);
    }

    /**
     * {@inheritdoc}
     */
    public function getWebsiteId($storeId)
    {
        return $this->_getSubject()->getWebsiteId($storeId);
    }

    /**
     * {@inheritdoc}
     */
    public function getInterest($storeId)
    {
        return $this->_getSubject()->getInterest($storeId);
    }

    /**
     * {@inheritdoc}
     */
    public function getSubscriberInterest($subscriberId, $storeId, $interest = null)
    {
        return $this->_getSubject()->getSubscriberInterest($subscriberId, $storeId, $interest);
    }

    /**
     * {@inheritdoc}
     */
    public function getGmtDate($format = null)
    {
        return $this->_getSubject()->getGmtDate($format);
    }

    /**
     * {@inheritdoc}
     */
    public function getGmtTimeStamp()
    {
        return $this->_getSubject()->getGmtTimeStamp();
    }

    /**
     * {@inheritdoc}
     */
    public function getAllApiKeys()
    {
        return $this->_getSubject()->getAllApiKeys();
    }

    /**
     * {@inheritdoc}
     */
    public function modifyCounter($index, $increment = 1)
    {
        return $this->_getSubject()->modifyCounter($index, $increment);
    }

    /**
     * {@inheritdoc}
     */
    public function resetCounters()
    {
        return $this->_getSubject()->resetCounters();
    }

    /**
     * {@inheritdoc}
     */
    public function getCounters()
    {
        return $this->_getSubject()->getCounters();
    }

    /**
     * {@inheritdoc}
     */
    public function serialize($data)
    {
        return $this->_getSubject()->serialize($data);
    }

    /**
     * {@inheritdoc}
     */
    public function unserialize($string)
    {
        return $this->_getSubject()->unserialize($string);
    }

    /**
     * {@inheritdoc}
     */
    public function isEmailSavingEnabled($storeId)
    {
        return $this->_getSubject()->isEmailSavingEnabled($storeId);
    }

    /**
     * {@inheritdoc}
     */
    public function resyncAllSubscribers($mailchimpList)
    {
        return $this->_getSubject()->resyncAllSubscribers($mailchimpList);
    }

    /**
     * {@inheritdoc}
     */
    public function decrypt($value)
    {
        return $this->_getSubject()->decrypt($value);
    }

    /**
     * {@inheritdoc}
     */
    public function encrypt($value)
    {
        return $this->_getSubject()->encrypt($value);
    }

    /**
     * {@inheritdoc}
     */
    public function isModuleOutputEnabled($moduleName = null)
    {
        return $this->_getSubject()->isModuleOutputEnabled($moduleName);
    }
}
