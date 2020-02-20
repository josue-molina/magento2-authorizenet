<?php

namespace Pronko\Authorizenet\Gateway\Request;

use Magento\Payment\Gateway\Request\BuilderInterface;

class RequestBuilder implements BuilderInterface
{
    /**
     * @var BuilderInterface
     */
    private $builderComposite;

    public function __construct(
        BuilderInterface $builder
    )
    {
        $this->builderComposite = $builder;
    }

    public function build(array $buildSubject)
    {
        return [
            'createTransactionRequest' => [
                'merchantAuthentication' => [
                    'name' => '9yyANU22f',
                    'transactionKey' => '92Kc8sM5v98Y6x6Q'
                ],
                'transactionRequest' => $this->builderComposite->build($buildSubject)
            ]
        ];
    }
}
