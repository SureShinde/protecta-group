<?php
namespace Bss\MultiWishlist\Controller\Index\Create;

/**
 * Interceptor class for @see \Bss\MultiWishlist\Controller\Index\Create
 */
class Interceptor extends \Bss\MultiWishlist\Controller\Index\Create implements \Magento\Framework\Interception\InterceptorInterface
{
    use \Magento\Framework\Interception\Interceptor;

    public function __construct(\Magento\Framework\App\Action\Context $context, \Magento\Framework\View\Result\PageFactory $resultPageFactory, \Magento\Framework\Data\Form\FormKey\Validator $validatorFormKey, \Magento\Customer\Model\Session $customerSession, \Bss\MultiWishlist\Helper\Data $helper, \Bss\MultiWishlist\Model\WishlistLabel $wishlistLabel)
    {
        $this->___init();
        parent::__construct($context, $resultPageFactory, $validatorFormKey, $customerSession, $helper, $wishlistLabel);
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
