<?php


namespace enumit\snappay\Requests;


class OrderRefundRequest extends Request
{
    protected $method = 'pay.orderrefund';

    public static function make($merchantNo, $outOrderNo, $outRefundNo, $refundAmount, $refundDescription)
    {
        $requestData = [
            'merchant_no' => $merchantNo,
            'out_order_no' => $outOrderNo,
            'out_refund_no' => $outRefundNo,
            'refund_amount' => $refundAmount,
            'refund_desc' => $refundDescription,
        ];

        return new static($requestData);
    }
}