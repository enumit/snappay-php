<?php


namespace enumit\snappay\Requests;


class OrderQueryRequest extends Request
{
    protected $method = 'pay.orderquery';

    public static function make($merchantNo, $outOrderNo, $transNo)
    {
        $requestData['merchant_no'] = $merchantNo;

        if ($outOrderNo) {
            $requestData['out_order_no'] = $outOrderNo;
        } else if ($transNo) {
            $requestData['trans_no'] = $transNo;
        }

        return new static($requestData);
    }
}