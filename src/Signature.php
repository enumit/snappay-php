<?php


namespace enumit\snappay;


class Signature
{
    private $secret;
    private $signType;

    /**
     * Signature constructor.
     * @param $secret
     * @param string $signType
     */
    public function __construct($secret, $signType = 'MD5')
    {
        $this->secret = $secret;
        $this->signType = strtoupper($signType);
    }

    /**
     * @param array $data
     * @param null $signType
     * @return string
     * @throws \Exception
     */
    public function sign(array $data, $signType = null)
    {
        $signType = isset($signType) ? $signType : $this->signType;

        switch ($signType) {
            case 'MD5':
                $sign = $this->signMd5($data);
                break;
            case 'RSA':
                $sign = $this->signRsa($data);
                break;
            default:
                throw new \Exception('Sign type not supported');
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
                $val = json_encode($val, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);
            }

            $string .= $key . '=' . $val . '&';
        }

        return rtrim($string, '&');
    }
}