<?php


namespace enumit\snappay\Requests;


class Request
{
    protected $method;
    protected $requestData;

    /**
     * Request constructor.
     * @param $requestData
     * @param null $method
     */
    public function __construct($requestData, $method = null)
    {
        $this->requestData = $requestData;
        $this->requestData['method'] = isset($method) ? $method : $this->method;
    }

    /**
     * @return mixed
     */
    public function getData()
    {
        return $this->requestData;
    }
}