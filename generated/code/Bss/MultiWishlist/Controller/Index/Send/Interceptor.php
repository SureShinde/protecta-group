<?php
namespace Bss\MultiWishlist\Controller\Index\Send;

/**
 * Interceptor class for @see \Bss\MultiWishlist\Controller\Index\Send
 */
class Interceptor extends \Bss\MultiWishlist\Controller\Index\Send implements \Magento\Framework\Interception\InterceptorInterface
{
    use \Magento\Framework\Interception\Interceptor;

    public function __construct(\Magento\Framework\App\Action\Context $context, \Magento\Framework\Data\Form\FormKey\Validator $formKeyValidator, \Magento\Customer\Model\Session $customerSession, \Magento\Wishlist\Controller\WishlistProviderInterface $wishlistProvider, \Magento\Wishlist\Model\Config $wishlistConfig, \Magento\Framework\Mail\Template\TransportBuilder $transportBuilder, \Magento\Framework\Translate\Inline\StateInterface $inlineTranslation, \Magento\Customer\Helper\View $customerHelperView, \Magento\Framework\Session\Generic $wishlistSession, \Magento\Framework\App\Config\ScopeConfigInterface $scopeConfig, \Magento\Store\Model\StoreManagerInterface $storeManager, \Bss\MultiWishlist\Helper\Data $helper)
    {
        $this->___init();
        parent::__construct($context, $formKeyValidator, $customerSession, $wishlistProvider, $wishlistConfig, $transportBuilder, $inlineTranslation, $customerHelperView, $wishlistSession, $scopeConfig, $storeManager, $helper);
    }

    /**
     * {@inheritdoc}
     */
    public function execute()
    {
        $pluginInfo = $this->pluginList->getNext($this->subjectType, 'execute');
        if (!$pluginInfo) {
            return parent::execute();
        } else {
            return $this->___callPlugins('execute', func_get_args(), $pluginInfo);
        }
    }

    /**
     * {@inheritdoc}
     */
    public function dispatch(\Magento\Framework\App\RequestInterface $request)
    {
        $pluginInfo = $this->pluginList->getNext($this->subjectType, 'dispatch');
        if (!$pluginInfo) {
            return parent::dispatch($request);
        } else {
            return $this->___callPlugins('dispatch', func_get_args(), $pluginInfo);
        }
    }
}
