<?php
namespace Magento\Webapi\Model\Authorization\OauthUserContext;

/**
 * Interceptor class for @see \Magento\Webapi\Model\Authorization\OauthUserContext
 */
class Interceptor extends \Magento\Webapi\Model\Authorization\OauthUserContext implements \Magento\Framework\Interception\InterceptorInterface
{
    use \Magento\Framework\Interception\Interceptor;

    public function __construct(\Magento\Framework\Webapi\Request $request, \Magento\Integration\Api\IntegrationServiceInterface $integrationService, \Magento\Framework\Oauth\OauthInterface $oauthService, \Magento\Framework\Oauth\Helper\Request $oauthHelper)
    {
        $this->___init();
        parent::__construct($request, $integrationService, $oauthService, $oauthHelper);
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
