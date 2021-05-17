<?php

namespace Digital\Contactus\Controller\AbstractController;

use Magento\Framework\App\RequestInterface;
use Magento\Framework\App\ResponseInterface;

interface ContactusLoaderInterface
{
    /**
     * @param RequestInterface $request
     * @param ResponseInterface $response
     * @return \Digital\Contactus\Model\Contactus
     */
    public function load(RequestInterface $request, ResponseInterface $response);
}
