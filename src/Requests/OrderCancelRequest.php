<?php


namespace enumit\snappay\Requests;


class OrderCancelRequest extends Request
{
    protected $method = 'pay.ordercancel';

    /**
     * @param $merchantNo
     * @param $outOrderNo
     * @return OrderCancelRequest
     */
    public static function make($merchantNo, $outOrderNo)
    {
        $requestData = [
            'merchant_no' => $merchantNo,
            'out_order_no' => $outOrderNo,
        ];

        return new static($requestData);
    }
}