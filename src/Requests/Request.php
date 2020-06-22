<?php


namespace enumit\snappay\Requests;


class Request
{
    protected $method;
    protected $requestData;

    public function __construct($requestData, $method = null)
    {
        $this->requestData = $requestData;
        $this->requestData['method'] = isset($method) ? $method : $this->method;
    }

    public function getData()
    {
        return $this->requestData;
    }
}