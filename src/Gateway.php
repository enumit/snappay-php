<?php


namespace enumit\snappay;


use enumit\snappay\Requests\MiniPayRequest;
use enumit\snappay\Traits\GatewayTrait;

class Gateway
{
    use GatewayTrait;

    /**
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
}