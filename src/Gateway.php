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
     * @link http://developer.snappay.ca/openapi.html#pay-apis-mini-program-api-post
     *
     * @param $outOrderNo
     * @param $amount
     * @param $userOpenId
     * @param $description
     * @param $notifyUrl
     * @param $attach
     * @param null $subAppId
     * @return Response
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function miniPay($outOrderNo, $amount, $userOpenId, $description, $notifyUrl, $attach, $subAppId = null)
    {
        $request = MiniPayRequest::make($this->merchantNo, $outOrderNo, $amount, $userOpenId,
            $description, $notifyUrl, $attach, $subAppId);

        return $this->send($request);
    }

    /**
     * Web Ali Pay
     * @link http://developer.snappay.ca/openapi.html#pay-apis-website-pay-api-post
     *
     * @param $outOrderNo
     * @param $amount
     * @param $description
     * @param $notifyUrl
     * @param $returnUrl
     * @param $attach
     * @param $browserType
     * @return Response
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function webAliPay($outOrderNo, $amount, $description, $notifyUrl, $returnUrl, $attach, $browserType)
    {
        $request = AliPayRequest::make($this->merchantNo, $outOrderNo, $amount, $description,
            $notifyUrl, $returnUrl, $attach, $browserType);

        return $this->send($request);
    }

    /**
     * Web Union Pay
     * @link http://developer.snappay.ca/openapi.html#pay-apis-website-pay-api-post
     *
     * @param $outOrderNo
     * @param $amount
     * @param $description
     * @param $notifyUrl
     * @param $returnUrl
     * @param $attach
     * @return Response
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function webUnionPay($outOrderNo, $amount, $description, $notifyUrl, $returnUrl, $attach)
    {
        $request = UnionPayRequest::make($this->merchantNo, $outOrderNo, $amount, $description,
            $notifyUrl, $returnUrl, $attach);

        return $this->send($request);
    }

    /**
     * Query Order
     * @link http://developer.snappay.ca/openapi.html#order-apis-query-order-api-post
     *
     * @param $transNo
     * @param $outOrderNo
     * @return Response
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function orderQuery($transNo, $outOrderNo = null)
    {
        $request = OrderQueryRequest::make($this->merchantNo, $transNo, $outOrderNo);

        return $this->send($request);
    }

    /**
     * Revoke Order
     * @link http://developer.snappay.ca/openapi.html#order-apis-revoke-order-api-post
     *
     * @param $outOrderNo
     * @return Response
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function orderRevoke($outOrderNo)
    {
        $request = OrderCancelRequest::make($this->merchantNo, $outOrderNo);

        return $this->send($request);
    }

    /**
     * Refund Order
     * @link http://developer.snappay.ca/openapi.html#order-apis-refund-api-post
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
     * @link http://developer.snappay.ca/openapi.html#order-apis-query-exchange-rate-post
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

    /**
     * Verify notify data
     * @link http://developer.snappay.ca/openapi.html#header-1.-select-sign-algorithms
     *
     * @param $data
     * @return bool
     * @throws \Exception
     */
    public function verifyNotify($data)
    {
        if (! isset($data['sign_type']) || ! isset($data['sign']) || ! isset($data['app_id'])) {
            return false;
        }

        if ($data['sign'] != $this->signature->sign($data, $data['sign_type'])) {
            return false;
        }

        if ($data['app_id'] != $this->appId) {
            return false;
        }

        return true;
    }

    /**
     * Get notify success response
     * @link http://developer.snappay.ca/openapi.html#order-apis-asynchronous-notification-post
     *
     * @return array
     * @throws \Exception
     */
    public function getNotifySuccessResponse()
    {
        $data = [
            'code' => '0',
            'msg' => 'SUCCESS',
            'sign_type' => 'MD5',
        ];

        $data['sign']  = $this->signature->sign($data);

        return $data;
    }
}