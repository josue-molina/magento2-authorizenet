<?php

namespace Pronko\Authorizenet\Gateway\Request\Builder;

use Magento\Payment\Gateway\Data\PaymentDataObjectInterface;
use Magento\Payment\Gateway\Request\BuilderInterface;
use Magento\Sales\Api\Data\OrderItemInterface;

class ProductItems implements BuilderInterface
{
    public function build(array $buildSubject)
    {
        /** @var PaymentDataObjectInterface $paymentDataObject */
        $paymentDataObject = $buildSubject['payment'];
        $order = $paymentDataObject->getOrder();

        $items = [];

        /** @var OrderItemInterface $item */
        foreach ($order->getItems() as $key => $item) {
            $items['lineItem'][] = [
                'itemId' => (string)$key,
                'name' => substr($item->getName(), 0, 31),
                'description' => substr($item->getDescription(), 0, 255),
                'quantity' => $item->getQtyOrdered(),
                'unitPrice' => $item->getPrice()
            ];
        }

        return [
            'lineItems' => $items
        ];
    }
}
