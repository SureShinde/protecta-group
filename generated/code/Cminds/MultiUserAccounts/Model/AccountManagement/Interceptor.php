<?php
namespace Cminds\MultiUserAccounts\Model\AccountManagement;

/**
 * Interceptor class for @see \Cminds\MultiUserAccounts\Model\AccountManagement
 */
class Interceptor extends \Cminds\MultiUserAccounts\Model\AccountManagement implements \Magento\Framework\Interception\InterceptorInterface
{
    use \Magento\Framework\Interception\Interceptor;

    public function __construct(\Magento\Customer\Model\CustomerFactory $customerFactory, \Magento\Framework\Event\ManagerInterface $eventManager, \Magento\Store\Model\StoreManagerInterface $storeManager, \Magento\Framework\Math\Random $mathRandom, \Magento\Customer\Model\Metadata\Validator $validator, \Magento\Customer\Api\Data\ValidationResultsInterfaceFactory $validationResultsDataFactory, \Magento\Customer\Api\AddressRepositoryInterface $addressRepository, \Magento\Customer\Api\CustomerMetadataInterface $customerMetadataService, \Magento\Customer\Model\CustomerRegistry $customerRegistry, \Psr\Log\LoggerInterface $logger, \Magento\Framework\Encryption\EncryptorInterface $encryptor, \Magento\Customer\Model\Config\Share $configShare, \Magento\Framework\Stdlib\StringUtils $stringHelper, \Magento\Customer\Api\CustomerRepositoryInterface $customerRepository, \Magento\Framework\App\Config\ScopeConfigInterface $scopeConfig, \Magento\Framework\Mail\Template\TransportBuilder $transportBuilder, \Magento\Framework\Reflection\DataObjectProcessor $dataProcessor, \Magento\Framework\Registry $registry, \Magento\Customer\Helper\View $customerViewHelper, \Magento\Framework\Stdlib\DateTime $dateTime, \Magento\Customer\Model\Customer $customerModel, \Magento\Framework\DataObjectFactory $objectFactory, \Magento\Framework\Api\ExtensibleDataObjectConverter $extensibleDataObjectConverter, \Cminds\MultiUserAccounts\Model\Config $moduleConfig, \Magento\Framework\Message\ManagerInterface $messageManager)
    {
        $this->___init();
        parent::__construct($customerFactory, $eventManager, $storeManager, $mathRandom, $validator, $validationResultsDataFactory, $addressRepository, $customerMetadataService, $customerRegistry, $logger, $encryptor, $configShare, $stringHelper, $customerRepository, $scopeConfig, $transportBuilder, $dataProcessor, $registry, $customerViewHelper, $dateTime, $customerModel, $objectFactory, $extensibleDataObjectConverter, $moduleConfig, $messageManager);
    }

    /**
     * {@inheritdoc}
     */
    public function authenticate($username, $password)
    {
        $pluginInfo = $this->pluginList->getNext($this->subjectType, 'authenticate');
        if (!$pluginInfo) {
            return parent::authenticate($username, $password);
        } else {
            return $this->___callPlugins('authenticate', func_get_args(), $pluginInfo);
        }
    }

    /**
     * {@inheritdoc}
     */
    public function initiatePasswordReset($email, $template, $websiteId = null)
    {
        $pluginInfo = $this->pluginList->getNext($this->subjectType, 'initiatePasswordReset');
        if (!$pluginInfo) {
            return parent::initiatePasswordReset($email, $template, $websiteId);
        } else {
            return $this->___callPlugins('initiatePasswordReset', func_get_args(), $pluginInfo);
        }
    }

    /**
     * {@inheritdoc}
     */
    public function createAccount(\Magento\Customer\Api\Data\CustomerInterface $customer, $password = null, $redirectUrl = '')
    {
        $pluginInfo = $this->pluginList->getNext($this->subjectType, 'createAccount');
        if (!$pluginInfo) {
            return parent::createAccount($customer, $password, $redirectUrl);
        } else {
            return $this->___callPlugins('createAccount', func_get_args(), $pluginInfo);
        }
    }

    /**
     * {@inheritdoc}
     */
    public function isEmailAvailable($customerEmail, $websiteId = null)
    {
        $pluginInfo = $this->pluginList->getNext($this->subjectType, 'isEmailAvailable');
        if (!$pluginInfo) {
            return parent::isEmailAvailable($customerEmail, $websiteId);
        } else {
            return $this->___callPlugins('isEmailAvailable', func_get_args(), $pluginInfo);
        }
    }
}
