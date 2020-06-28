<?php


namespace enumit\snappay\Traits;


use enumit\snappay\Requests\Request;
use enumit\snappay\Response;
use enumit\snappay\Signature;
use GuzzleHttp\Client;

trait GatewayTrait
{
    protected $urlGateway = 'https://open.snappay.ca/api/gateway';

    protected $appId;
    protected $merchantNo;
    protected $format = 'JSON';
    protected $charset = 'UTF-8';
    protected $signType = 'MD5';
    protected $version = '1.0';
    protected $commonData;
    protected $headers;

    protected $client;
    protected $signature;

    /**
     * @param $merchantNo
     * @param $appId
     * @param $secret
     * @return $this
     */
    public static function make($merchantNo, $appId, $secret)
    {
        return new static($merchantNo, $appId, $secret);
    }

    /**
     * GatewayTrait constructor.
     * @param $merchantNo
     * @param $appId
     * @param $secret
     */
    public function __construct($merchantNo, $appId, $secret)
    {
        $this->commonData = [
            'app_id' => $appId,
            'format' => $this->format,
            'charset' => $this->charset,
            'sign_type' => $this->signType,
            'version' => $this->version,
        ];

        $this->headers = [
            'Accept' => 'application/json',
            'Content-Type' => 'application/json',
        ];

        $this->appId = $appId;
        $this->merchantNo = $merchantNo;

        $this->client = new Client([
            'timeout' => 10.0,
        ]);

        $this->signature = new Signature($secret);
    }

    /**
     * @param Request $request
     * @return Response
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    protected function send(Request $request)
    {
        $requestData = array_merge($this->commonData, $request->getData());

        $sign = $this->signature->sign($requestData);
        $requestData['sign'] = $sign;

        $response = $this->client->request('POST', $this->urlGateway, [
            'headers' => $this->headers,
            'json' => $requestData,
        ]);

        if ($response->getStatusCode() != 200) {
            throw new \Exception('Network error: ' . $response->getStatusCode());
        }

        $content = json_decode($response->getBody()->getContents(), true);

        if ($content['code'] != '0') {
            throw new \Exception($content['msg']);
        }

        if ($content['sign'] != $this->signature->sign($content)) {
            throw new \Exception('Invalid signature on response');
        }

        return Response::make($content);
    }
}