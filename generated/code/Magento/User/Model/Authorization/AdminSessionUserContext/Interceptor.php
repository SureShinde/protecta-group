<?php
namespace Magento\User\Model\Authorization\AdminSessionUserContext;

/**
 * Interceptor class for @see \Magento\User\Model\Authorization\AdminSessionUserContext
 */
class Interceptor extends \Magento\User\Model\Authorization\AdminSessionUserContext implements \Magento\Framework\Interception\InterceptorInterface
{
    use \Magento\Framework\Interception\Interceptor;

    public function __construct(\Magento\Backend\Model\Auth\Session $adminSession)
    {
        $this->___init();
        parent::__construct($adminSession);
    }

    /**
     * {@inheritdoc}
     */
    public function getUserId()
    {
        $pluginInfo = $this->pluginList->getNext($this->subjectType, 'getUserId');
        if (!$pluginInfo) {
            return parent::getUserId();
        } else {
            return $this->___callPlugins('getUserId', func_get_args(), $pluginInfo);
        }
    }
}
