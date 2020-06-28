<?php


namespace enumit\snappay\Requests;


class OrderQueryRequest extends Request
{
    protected $method = 'pay.orderquery';

    /**
     * @param $merchantNo
     * @param $transNo
     * @param $outOrderNo
     * @return OrderQueryRequest
     */
    public static function make($merchantNo, $transNo, $outOrderNo)
    {
        $requestData['merchant_no'] = $merchantNo;

        if ($transNo) {
            $requestData['trans_no'] = $transNo;
        } else if ($outOrderNo) {
            $requestData['out_order_no'] = $outOrderNo;
        }

        return new static($requestData);
    }
}