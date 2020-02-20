<?php

namespace Pronko\Authorizenet\Gateway\Http;

use Magento\Payment\Gateway\Http\TransferBuilder;
use Magento\Payment\Gateway\Http\TransferFactoryInterface;
use Pronko\Authorizenet\Gateway\Converter\Converter;

class TransferFactory implements TransferFactoryInterface
{
    /**
     * @var TransferBuilder
     */
    private $transferBuilder;

    /**
     * @var Converter
     */
    private $converter;

    public function __construct(
        TransferBuilder $transferBuilder,
        Converter $converter
    )
    {
        $this->transferBuilder = $transferBuilder;
        $this->converter = $converter;
    }

    public function create(array $request)
    {
        return $this->transferBuilder
            ->setUri('https://apitest.authorize.net/xml/v1/request.api')
            ->setMethod('POST')
            ->setBody($this->converter->convert($request))
            ->setHeaders(['Content-Type' => 'application/json'])
            ->build();
    }
}
