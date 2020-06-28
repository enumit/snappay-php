<?php


namespace enumit\snappay;


class Response
{
    /**
     * @var string
     */
    private $code;

    /**
     * @var string
     */
    private $msg;

    /**
     * @var string
     */
    private $sign;

    /**
     * @var int
     */
    private $total;

    /**
     * @var array
     */
    private $data;

    /**
     * @var string
     */
    private $psn;

    /**
     * @param array $response
     * @return Response
     */
    public static function make(array $response)
    {
        $object = new static();

        $object->code = $response['code'];
        $object->msg = $response['msg'];
        $object->sign = $response['sign'];
        $object->total = $response['total'];
        $object->data = $response['data'];
        $object->psn = $response['psn'];

        return $object;
    }

    /**
     * @return string
     */
    public function getCode()
    {
        return $this->code;
    }

    /**
     * @return array
     */
    public function getData()
    {
        return $this->data;
    }

    /**
     * @return array
     */
    public function getFirstData()
    {
        return isset($this->data[0]) ? $this->data[0] : [];
    }

    /**
     * @return array
     */
    public function getList()
    {
        return $this->data;
    }

    /**
     * @return string
     */
    public function getMsg()
    {
        return $this->msg;
    }

    /**
     * @return string
     */
    public function getSign()
    {
        return $this->sign;
    }

    /**
     * @return int
     */
    public function getTotal()
    {
        return $this->total;
    }

    /**
     * @return string
     */
    public function getPsn()
    {
        return $this->psn;
    }
}