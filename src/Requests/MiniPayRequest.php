<?php


namespace enumit\snappay\Requests;


class MiniPayRequest extends Request
{
    protected $method = 'pay.minipay';

    /**
     * @param $merchantNo
     * @param $outOrderNo
     * @param $amount
     * @param $userOpenId
     * @param $description
     * @param $notifyUrl
     * @param $attach
     * @param $subAppId
     * @return MiniPayRequest
     */
    public static function make($merchantNo, $outOrderNo, $amount, $userOpenId, $description, $notifyUrl, $attach, $subAppId)
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