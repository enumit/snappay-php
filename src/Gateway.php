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
     * Ali Pay
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
    public function aliPay($outOrderNo, $amount, $description, $notifyUrl, $returnUrl, $attach, $browserType)
    {
        $request = AliPayRequest::make($this->merchantNo, $outOrderNo, $amount, $description,
            $notifyUrl, $returnUrl, $attach, $browserType);

        return $this->send($request);
    }

    /**
     * Union Pay
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
    public function unionPay($outOrderNo, $amount, $description, $notifyUrl, $returnUrl, $attach)
    {
        $request = UnionPayRequest::make($this->merchantNo, $outOrderNo, $amount, $description,
            $notifyUrl, $returnUrl, $attach);

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
    public function orderQuery($outOrderNo, $transNo = null)
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

    /**
     * Verify notify data
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