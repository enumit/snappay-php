<?php


namespace enumit\snappay\Requests;


class AliPayRequest extends Request
{
    const BROWSER_TYPE_PC = 'PC';
    const BROWSER_TYPE_WAP = 'WAP';

    protected $method = 'pay.webpay';

    public static function make($merchantNo, $outOrderNo, $amount, $description, $attach, $returnUrl, $notifyUrl, $browserType = 'PC')
    {
        $requestData = [
            'merchant_no' => $merchantNo,
            'payment_method' => 'ALIPAY',
            'out_order_no' => $outOrderNo,
            'trans_currency' => 'CAD',
            'trans_amount' => $amount,
            'description' => $description,
            'notify_url' => $notifyUrl,
            'return_url' => $returnUrl,
            'attach' => $attach,
            'effective_minutes' => 60,
            'browser_type' => $browserType,
        ];

        return new static($requestData);
    }
}