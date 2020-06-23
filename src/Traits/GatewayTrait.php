<?php


namespace enumit\snappay\Traits;


use enumit\snappay\Requests\Request;
use enumit\snappay\Response;
use enumit\snappay\Signature;
use GuzzleHttp\Client;

trait GatewayTrait
{
    protected $merchantNo;
    protected $notifyUrl;
    protected $returnUrl;
    protected $format = 'JSON';
    protected $charset = 'UTF-8';
    protected $signType = 'MD5';
    protected $version = '1.0';
    protected $commonData;
    protected $headers;

    protected $client;
    protected $signature;

    public function __construct($merchantNo, $appId, $secret, $notifyUrl, $returnUrl)
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

        $this->merchantNo = $merchantNo;
        $this->notifyUrl = $notifyUrl;
        $this->returnUrl = $returnUrl;

        $this->client = new Client([
            'base_uri' => 'https://open.snappay.ca/api/gateway',
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

        $response = $this->client->request('POST', [
            'headers' => $this->headers,
            'json' => $requestData,
        ]);

        if ($response->getStatusCode() != 200) {
            throw new \Exception('Network error: ' . $response->getStatusCode());
        }

        $content = json_decode($response->getBody()->getContents(), true);

        if ($content['code'] != 0) {
            throw new \Exception($content['msg']);
        }

        $sign = $this->signature->sign($content['data']);
        if ($sign != $content['sign']) {
            throw new \Exception('Sign invalid');
        }

        return Response::make($content);
    }
}