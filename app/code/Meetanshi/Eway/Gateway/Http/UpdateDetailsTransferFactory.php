<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
namespace Meetanshi\Eway\Gateway\Http;

use Meetanshi\Eway\Gateway\Helper\TransactionReader;
use Meetanshi\Eway\Gateway\Http\Client\Curl;
use Meetanshi\Eway\Gateway\Validator\Shared\AccessCodeValidator;

/**
 * Class UpdateDetailsTransferFactory
 */
class UpdateDetailsTransferFactory extends AbstractTransferFactory
{
    /**
     * @inheritdoc
     */
    public function create(array $request)
    {
        return $this->transferBuilder->setMethod(Curl::GET)
            ->setAuthUsername($this->getApiKey())
            ->setAuthPassword($this->getApiPassword())
            ->setUri($this->getUrl($request))
            ->build();
    }

    /**
     * @param array $request
     * @return string
     * @throws \InvalidArgumentException
     */
    private function getUrl($request)
    {
        return $this->action->getUrl('/' . TransactionReader::readAccessCode($request));
    }
}
