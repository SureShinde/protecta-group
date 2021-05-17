<?php

namespace Dcs\Downloadcatalogue\Controller\AbstractController;

use Magento\Framework\App\RequestInterface;
use Magento\Framework\App\ResponseInterface;
use Magento\Framework\Registry;

class DownloadcatalogueLoader implements DownloadcatalogueLoaderInterface
{
    /**
     * @var \Dcs\Downloadcatalogue\Model\DownloadcatalogueFactory
     */
    protected $downloadcatalogueFactory;

    /**
     * @var \Magento\Framework\Registry
     */
    protected $registry;

    /**
     * @var \Magento\Framework\UrlInterface
     */
    protected $url;

    /**
     * @param \Dcs\Downloadcatalogue\Model\DownloadcatalogueFactory $downloadcatalogueFactory
     * @param OrderViewAuthorizationInterface $orderAuthorization
     * @param Registry $registry
     * @param \Magento\Framework\UrlInterface $url
     */
    public function __construct(
        \Dcs\Downloadcatalogue\Model\DownloadcatalogueFactory $downloadcatalogueFactory,
        Registry $registry,
        \Magento\Framework\UrlInterface $url
    ) {
        $this->downloadcatalogueFactory = $downloadcatalogueFactory;
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

        $downloadcatalogue = $this->downloadcatalogueFactory->create()->load($id);
        $this->registry->register('current_downloadcatalogue', $downloadcatalogue);
        return true;
    }
}
