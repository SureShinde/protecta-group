<?php

namespace Dcs\Downloadcatalogue\Controller\AbstractController;

use Magento\Framework\App\RequestInterface;
use Magento\Framework\App\ResponseInterface;

interface DownloadcatalogueLoaderInterface
{
    /**
     * @param RequestInterface $request
     * @param ResponseInterface $response
     * @return \Dcs\Downloadcatalogue\Model\Downloadcatalogue
     */
    public function load(RequestInterface $request, ResponseInterface $response);
}
