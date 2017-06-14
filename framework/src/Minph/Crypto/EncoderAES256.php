<?php


namespace Minph\Crypto;


/**
 * @class Minph\Crypt\EncoderAES256
 *
 * AES256 CBC Encoder implementation of Encoder interface.
 * includes: MAC hashing validation.
 */
class EncoderAES256 implements Encoder
{
    const METHOD = 'aes-256-cbc';

    private $key;

    /**
     * @method construct
     * @param string `$key` AES256CBC key
     */
    public function __construct($key)
    {
        $this->key = $key;
    }

    /**
     * @method encrypt
     * @param string `$message` original message
     * @return string encoded
     */
    public function encrypt($message)
    {
        $iv = openssl_random_pseudo_bytes(openssl_cipher_iv_length(self::METHOD));

        $data = openssl_encrypt($message, self::METHOD, $this->key, OPENSSL_RAW_DATA, $iv);

        $iv = base64_encode($iv);
        $data = base64_encode($data);

        $mac = $this->getMac($iv.$data);

        $json = json_encode(compact('iv', 'data', 'mac'));
        return base64_encode($json);
    }

    /**
     * @method decrypt
     * @param string `$encrypted` encoded
     * @return string decoded
     */
    public function decrypt($encrypted)
    {
        $data = json_decode(base64_decode($encrypted), true);
        if (!$this->validJsonData($data)) {
            throw new \Exception('json data is invalid');
        }
        if (!$this->validMacData($data)) {
            throw new \Exception('mac is invalid');
        }
        $iv = base64_decode($data['iv']);
        $data = base64_decode($data['data']);

        $dec = openssl_decrypt($data, self::METHOD, $this->key, OPENSSL_RAW_DATA, $iv);
        return $dec;
    }

    private function getMac($value)
    {
        return hash_hmac('sha256', $value, $this->key);
    }

    private function validJsonData($data)
    {
        return is_array($data) && isset($data['iv']) && isset($data['data']) && isset($data['mac']);
    }

    private function validMacData($data)
    {
        $mac1 = $data['mac'];
        $mac2 = $this->getMac($data['iv'].$data['data']);
        return hash_equals($mac1, $mac2);
    }
}
