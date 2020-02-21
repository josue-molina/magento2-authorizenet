<?php

namespace Pronko\Authorizenet\Plugin\Payment\Block;

class Info
{
    const AUTH_CODE = 'auth_code';
    const AVS_RESULT_CODE = 'avs_result_code';
    const CVV_RESULT_CODE = 'cvv_result_code';
    const CAVV_RESULT_CODE = 'cavv_result_code';
    const ACCOUNT_NUMBER = 'account_number';
    const ACCOUNT_TYPE = 'account_type';
    const TEST_REQUEST = 'test_request';

    private $labels = [
        self::AUTH_CODE => 'Auth Code',
        self::AVS_RESULT_CODE => 'Address Verification Service (AVS)',
        self::CVV_RESULT_CODE => 'Card Code Verification (CVV)',
        self::CAVV_RESULT_CODE => 'Cardholder Authentication Verification (CAVV)',
        self::ACCOUNT_NUMBER => 'Account Number',
        self::ACCOUNT_TYPE => 'Account Type',
        self::TEST_REQUEST => 'Test Request',
    ];

    private $values = [
        self::AVS_RESULT_CODE => [
            'p' => 'Not Applicable (P)'
        ]
    ];

    public function afterGetSpecificInformation(
        \Magento\Payment\Block\Info $subject,
        $result
    )
    {
        if ('pronko_authorizenet' === $subject->getData('methodCode')) {
            foreach ($this->labels as $key => $label) {
                if (array_key_exists($key, $result)) {
                    $value = $result[$key];
                    if (isset($this->values[$key][$value])) {
                        $value = $this->values[$key][$value];
                    }
                    $result[$label] = $value;
                    unset($result[$key]);
                }
            }
        }

        return $result;
    }
}
