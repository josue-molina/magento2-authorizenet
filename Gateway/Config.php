<?php


namespace Pronko\Authorizenet\Gateway;

use Magento\Framework\Exception\NotFoundException;
use Magento\Payment\Gateway\Config\ValueHandlerPoolInterface;

class Config
{
    /**
     * @var ValueHandlerPoolInterface
     */
    private $valueHandlerPool;

    public function __construct(
        ValueHandlerPoolInterface $valueHandlerPool
    )
    {
        $this->valueHandlerPool = $valueHandlerPool;
    }

    public function getGatewayUrl()
    {
        if ($this->isSandbox()) {
            return (string)$this->getValue('gateway_url_sandbox');
        }

        return (string)$this->getValue('gateway_url');
    }

    public function isSandbox()
    {
        return (bool)$this->getValue('is_sandbox');
    }

    private function getValue($field)
    {
        try {
            $handler = $this->valueHandlerPool->get($field);
            return $handler->handle(['field' => $field]);
        } catch (NotFoundException $e) {
            return null;
        }
    }

    public function getGatewayHeaders()
    {
        return ['Content-Type' => 'application/json'];
    }

    public function getApiLoginId()
    {
        return (string)$this->getValue('api_login_id');
    }

    public function getTransactionKey()
    {
        return (string)$this->getValue('transaction_key');
    }
}
