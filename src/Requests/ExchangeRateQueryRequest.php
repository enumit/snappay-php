<?php


namespace enumit\snappay\Requests;


class ExchangeRateQueryRequest extends Request
{
    const CURRENCY_CAD = 'CAD';
    const CURRENCY_USD = 'USD';
    const PAYMENT_METHOD_ALIPAY = 'ALIPAY';
    const PAYMENT_METHOD_WECHATPAY = 'WECHATPAY';
    const PAY_TYPE_ONLINE = 'ONLINE';
    const PAY_TYPE_OFFLINE = 'OFFLINE';

    protected $method = 'pay.exchangerate';

    /**
     * @param $baseCurrencyUnit
     * @param $paymentMethod
     * @param $payType
     * @return ExchangeRateQueryRequest
     */
    public static function make($baseCurrencyUnit, $paymentMethod, $payType)
    {
        $requestData = [
            'basic_currency_unit' => $baseCurrencyUnit,
            'payment_method' => $paymentMethod,
            'pay_type' => $payType,
        ];

        return new static($requestData);
    }
}