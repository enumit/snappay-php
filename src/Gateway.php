<?php


namespace enumit\snappay;


use enumit\snappay\Requests\AliPayRequest;
use enumit\snappay\Requests\ExchangeRateQueryRequest;
use enumit\snappay\Requests\MiniPayRequest;
use enumit\snappay\Requests\OrderCancelRequest;
use enumit\snappay\Requests\OrderQueryRequest;
use enumit\snappay\Requests\OrderRefundRequest;
use enumit\snappay\Requests\UnionPayRequest;
use enumit\snappay\Traits\GatewayTrait;

class Gateway
{
    use GatewayTrait;

    /**
     * Mini Program Pay
     *
     * @param $outOrderNo
     * @param $amount
     * @param $userOpenId
     * @param $description
     * @param $attach
     * @return Response
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function miniPay($outOrderNo, $amount, $userOpenId, $description, $attach)
    {
        $request = MiniPayRequest::make($this->merchantNo, $outOrderNo, $amount, $userOpenId,
            $description, $attach, $this->notifyUrl);

        return $this->send($request);
    }

    /**
     * Ali Pay
     *
     * @param $outOrderNo
     * @param $amount
     * @param $description
     * @param $attach
     * @param $browserType
     * @return Response
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function aliPay($outOrderNo, $amount, $description, $attach, $browserType)
    {
        $request = AliPayRequest::make($this->merchantNo, $outOrderNo, $amount, $description,
            $attach, $this->notifyUrl, $this->returnUrl, $browserType);

        return $this->send($request);
    }

    /**
     * Union Pay
     *
     * @param $outOrderNo
     * @param $amount
     * @param $description
     * @param $attach
     * @return Response
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function unionPay($outOrderNo, $amount, $description, $attach)
    {
        $request = UnionPayRequest::make($this->merchantNo, $outOrderNo, $amount, $description,
            $attach, $this->notifyUrl, $this->returnUrl);

        return $this->send($request);
    }

    /**
     * Query Order
     *
     * @param $outOrderNo
     * @param $transNo
     * @return Response
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function orderQuery($outOrderNo, $transNo)
    {
        $request = OrderQueryRequest::make($this->merchantNo, $outOrderNo, $transNo);

        return $this->send($request);
    }

    /**
     * Cancel Order
     *
     * @param $outOrderNo
     * @return Response
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function orderCancel($outOrderNo)
    {
        $request = OrderCancelRequest::make($this->merchantNo, $outOrderNo);

        return $this->send($request);
    }

    /**
     * Refund Order
     *
     * @param $outOrderNo
     * @param $outRefundNo
     * @param $refundAmount
     * @param $refundDescription
     * @return Response
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function orderRefund($outOrderNo, $outRefundNo, $refundAmount, $refundDescription)
    {
        $request = OrderRefundRequest::make($this->merchantNo, $outOrderNo, $outRefundNo,
            $refundAmount, $refundDescription);

        return $this->send($request);
    }

    /**
     * Exchange Rate Query
     *
     * @param $baseCurrencyUnit
     * @param $paymentMethod
     * @param $payType
     * @return Response
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function exchangeRateQuery($baseCurrencyUnit, $paymentMethod, $payType)
    {
        $request = ExchangeRateQueryRequest::make($baseCurrencyUnit, $paymentMethod, $payType);

        return $this->send($request);
    }
}