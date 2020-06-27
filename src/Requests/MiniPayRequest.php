<?php


namespace enumit\snappay\Requests;


class MiniPayRequest extends Request
{
    protected $method = 'pay.minipay';

    public static function make($merchantNo, $outOrderNo, $amount, $userOpenId, $description, $attach, $notifyUrl, $subAppId)
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

        if ($subAppId) {
            $requestData['extension_parameters'] = [
                'sub_app_id' => $subAppId,
            ];
        }

        return new static($requestData);
    }
}