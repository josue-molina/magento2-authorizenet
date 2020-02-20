<?php

namespace Pronko\Authorizenet\Observer;

use Magento\Framework\Event\Observer;
use Magento\Payment\Observer\AbstractDataAssignObserver;
use Magento\Quote\Api\Data\PaymentInterface;

class DataAssignObserver extends AbstractDataAssignObserver
{
    const CC_NUMBER = 'cc_number';
    const CC_TYPE_4 = 'cc_last_4';
    const CC_TYPE = 'cc_type';
    const CC_EXP_MONTH = 'cc_exp_month';
    const CC_EXP_YEAR = 'cc_exp_year';
    const CC_CID = 'cc_cid';

    private $paymentFields = [
        self::CC_NUMBER => 'cc_number',
        self::CC_TYPE => 'cc_type',
        self::CC_EXP_MONTH => 'cc_exp_month',
        self::CC_EXP_YEAR => 'cc_exp_year',
        self::CC_CID => 'cc_cid'
    ];

    public function execute(Observer $observer)
    {
        $data = $this->readDataArgument($observer);
        $additionalData = $data->getData(PaymentInterface::KEY_ADDITIONAL_DATA);
        if (!is_array($additionalData)) {
            return;
        }
        /** @var \Magento\Quote\Model\Quote\Payment $paymentInfo */
        $paymentInfo = $this->readPaymentModelArgument($observer);
        foreach ($this->paymentFields as $field => $formField) {
            if (isset($additionalData[$formField])) {
                $paymentInfo->setData($field, $additionalData[$formField]);
            }
        }
    }
}
