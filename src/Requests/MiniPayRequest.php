<?php


namespace enumit\snappay\Requests;


class MiniPayRequest extends Request
{
    protected $method = 'pay.minipay';

    public static function make($merchantNo, $outOrderNo, $amount, $userOpenId, $description, $attach, $notifyUrl)
    {
        $requestData = [
            'merchant_no' => $merchantNo,
            'payment_method' => 'WECHATPAY',
            'out_order_no' => $outOrderNo,
            'trans_currency' => 'CAD',
            'trans_amount' => $amount,
            'pay_user_account_id' => $userOpenId,
            'description' => $description,
            'notify_url' => $notifyUrl,
            'attach' => $attach,
            'effective_minutes' => 60,
        ];

        return new static($requestData);
    }
}