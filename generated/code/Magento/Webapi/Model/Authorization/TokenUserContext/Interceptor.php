<?php
namespace Magento\Webapi\Model\Authorization\TokenUserContext;

/**
 * Interceptor class for @see \Magento\Webapi\Model\Authorization\TokenUserContext
 */
class Interceptor extends \Magento\Webapi\Model\Authorization\TokenUserContext implements \Magento\Framework\Interception\InterceptorInterface
{
    use \Magento\Framework\Interception\Interceptor;

    public function __construct(\Magento\Framework\Webapi\Request $request, \Magento\Integration\Model\Oauth\TokenFactory $tokenFactory, \Magento\Integration\Api\IntegrationServiceInterface $integrationService, ?\Magento\Framework\Stdlib\DateTime $dateTime = null, ?\Magento\Framework\Stdlib\DateTime\DateTime $date = null, ?\Magento\Integration\Helper\Oauth\Data $oauthHelper = null)
    {
        $this->___init();
        parent::__construct($request, $tokenFactory, $integrationService, $dateTime, $date, $oauthHelper);
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
