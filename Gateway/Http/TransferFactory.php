<?php

namespace Pronko\Authorizenet\Gateway\Http;

use Magento\Payment\Gateway\Http\TransferBuilder;
use Magento\Payment\Gateway\Http\TransferFactoryInterface;
use Pronko\Authorizenet\Gateway\Converter\Converter;
use Pronko\Authorizenet\Gateway\Config;

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

    /**
     * @var Config
     */
    private $config;

    public function __construct(
        TransferBuilder $transferBuilder,
        Converter $converter,
        Config $config
    )
    {
        $this->transferBuilder = $transferBuilder;
        $this->converter = $converter;
        $this->config = $config;
    }

    public function create(array $request)
    {
        return $this->transferBuilder
            ->setUri($this->config->getGatewayUrl())
            ->setMethod('POST')
            ->setBody($this->converter->convert($request))
            ->setHeaders($this->config->getGatewayHeaders())
            ->build();
    }
}
