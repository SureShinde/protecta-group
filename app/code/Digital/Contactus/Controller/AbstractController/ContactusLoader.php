<?php

namespace Digital\Contactus\Controller\AbstractController;

use Magento\Framework\App\RequestInterface;
use Magento\Framework\App\ResponseInterface;
use Magento\Framework\Registry;

class ContactusLoader implements ContactusLoaderInterface
{
    /**
     * @var \Digital\Contactus\Model\ContactusFactory
     */
    protected $contactusFactory;

    /**
     * @var \Magento\Framework\Registry
     */
    protected $registry;

    /**
     * @var \Magento\Framework\UrlInterface
     */
    protected $url;

    /**
     * @param \Digital\Contactus\Model\ContactusFactory $contactusFactory
     * @param OrderViewAuthorizationInterface $orderAuthorization
     * @param Registry $registry
     * @param \Magento\Framework\UrlInterface $url
     */
    public function __construct(
        \Digital\Contactus\Model\ContactusFactory $contactusFactory,
        Registry $registry,
        \Magento\Framework\UrlInterface $url
    ) {
        $this->contactusFactory = $contactusFactory;
        $this->registry = $registry;
        $this->url = $url;
    }

    /**
     * @param RequestInterface $request
     * @param ResponseInterface $response
     * @return bool
     */
    public function load(RequestInterface $request, ResponseInterface $response)
    {
        $id = (int)$request->getParam('id');
        if (!$id) {
            $request->initForward();
            $request->setActionName('noroute');
            $request->setDispatched(false);
            return false;
        }

        $contactus = $this->contactusFactory->create()->load($id);
        $this->registry->register('current_contactus', $contactus);
        return true;
    }
}
