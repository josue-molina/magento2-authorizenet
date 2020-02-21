<?php

namespace Pronko\Authorizenet\Gateway\Request;

use Magento\Payment\Gateway\Request\BuilderInterface;
use Pronko\Authorizenet\Gateway\Config;

class RequestBuilder implements BuilderInterface
{
    /**
     * @var BuilderInterface
     */
    private $builderComposite;

    /**
     * @var Config
     */
    private $config;

    public function __construct(
        BuilderInterface $builder,
        Config $config
    )
    {
        $this->builderComposite = $builder;
        $this->config = $config;
    }

    public function build(array $buildSubject)
    {
        return [
            'createTransactionRequest' => [
                'merchantAuthentication' => [
                    'name' => $this->config->getApiLoginId(),
                    'transactionKey' => $this->config->getTransactionKey()
                ],
                'transactionRequest' => $this->builderComposite->build($buildSubject)
            ]
        ];
    }
}
