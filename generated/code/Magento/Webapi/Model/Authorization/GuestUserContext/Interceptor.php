<?php
namespace Magento\Webapi\Model\Authorization\GuestUserContext;

/**
 * Interceptor class for @see \Magento\Webapi\Model\Authorization\GuestUserContext
 */
class Interceptor extends \Magento\Webapi\Model\Authorization\GuestUserContext implements \Magento\Framework\Interception\InterceptorInterface
{
    use \Magento\Framework\Interception\Interceptor;

    public function __construct()
    {
        $this->___init();
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
