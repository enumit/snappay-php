<?php


namespace enumit\snappay\Requests;


class OrderQueryRequest extends Request
{
    protected $method = 'pay.orderquery';

    public static function make($merchantNo, $outOrderNo, $transNo)
    {
        $requestData = [
            'merchant_no' => $merchantNo,
            'out_order_no' => $outOrderNo,
            'trans_no' => $transNo,
        ];

        return new static($requestData);
    }
}