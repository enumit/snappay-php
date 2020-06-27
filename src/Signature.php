<?php


namespace enumit\snappay;


class Signature
{
    private $secret;
    private $signType;

    public function __construct($secret, $signType = 'MD5')
    {
        $this->secret = $secret;
        $this->signType = strtoupper($signType);
    }

    /**
     * @param array $data
     * @return string
     */
    public function sign(array $data)
    {
        switch ($this->signType) {
            case 'MD5':
                $sign = $this->signMd5($data);
                break;
            case 'RSA':
                $sign = $this->signRsa($data);
                break;
            default:
                $sign = '';
        }

        return $sign;
    }

    /**
     * @param array $data
     * @return string
     */
    protected function signMd5(array $data)
    {
        $string = $this->prepareSign($data) . $this->secret;

        $md5String = md5($string);

        return strtolower($md5String);

    }

    protected function signRsa(array $data)
    {
        return '';
    }

    /**
     * @param array $data
     * @return string
     */
    protected function prepareSign(array $data)
    {
        $data = array_filter($data, function ($item, $key) {
            if (is_null($item)
                || $item == ''
                || $key == 'sign_type'
                || $key == 'sign') {
                return false;
            }

            return true;

        }, ARRAY_FILTER_USE_BOTH);

        ksort($data);

        $string = '';
        foreach ($data as $key => $val) {
            if (is_array($val)) {
                $val = json_encode($val);
            }

            $string .= $key . '=' . $val . '&';
        }

        return rtrim($string, '&');
    }
}