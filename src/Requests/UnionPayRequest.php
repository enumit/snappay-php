<?php


namespace enumit\snappay\Requests;


class UnionPayRequest extends Request
{
    protected $method = 'pay.webpay';

    public static function make($merchantNo, $outOrderNo, $amount, $description, $notifyUrl, $returnUrl, $attach)
    {
        $requestData = [
            'merchant_no' => $merchantNo,
            'payment_method' => 'UNIONPAY',
            'out_order_no' => $outOrderNo,
            'trans_currency' => 'CAD',
            'trans_amount' => $amount,
            'description' => $description,
            'notify_url' => $notifyUrl,
            'return_url' => $returnUrl,
            'attach' => $attach,
            'effective_minutes' => 60,
        ];

        return new static($requestData);
    }
}