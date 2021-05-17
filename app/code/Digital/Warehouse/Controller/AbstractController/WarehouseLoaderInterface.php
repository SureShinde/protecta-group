<?php

namespace Digital\Warehouse\Controller\AbstractController;

use Magento\Framework\App\RequestInterface;
use Magento\Framework\App\ResponseInterface;

interface WarehouseLoaderInterface
{
    /**
     * @param RequestInterface $request
     * @param ResponseInterface $response
     * @return \Digital\Warehouse\Model\Warehouse
     */
    public function load(RequestInterface $request, ResponseInterface $response);
}
