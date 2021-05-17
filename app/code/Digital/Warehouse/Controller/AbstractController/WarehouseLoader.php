<?php

namespace Digital\Warehouse\Controller\AbstractController;

use Magento\Framework\App\RequestInterface;
use Magento\Framework\App\ResponseInterface;
use Magento\Framework\Registry;

class WarehouseLoader implements WarehouseLoaderInterface
{
    /**
     * @var \Digital\Warehouse\Model\WarehouseFactory
     */
    protected $warehouseFactory;

    /**
     * @var \Magento\Framework\Registry
     */
    protected $registry;

    /**
     * @var \Magento\Framework\UrlInterface
     */
    protected $url;

    /**
     * @param \Digital\Warehouse\Model\WarehouseFactory $warehouseFactory
     * @param OrderViewAuthorizationInterface $orderAuthorization
     * @param Registry $registry
     * @param \Magento\Framework\UrlInterface $url
     */
    public function __construct(
        \Digital\Warehouse\Model\WarehouseFactory $warehouseFactory,
        Registry $registry,
        \Magento\Framework\UrlInterface $url
    ) {
        $this->warehouseFactory = $warehouseFactory;
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

        $warehouse = $this->warehouseFactory->create()->load($id);
        $this->registry->register('current_warehouse', $warehouse);
        return true;
    }
}
