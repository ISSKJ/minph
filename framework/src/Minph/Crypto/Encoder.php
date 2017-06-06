<?php

/**
 * {LICENSE}
 */

namespace Minph\Crypt;


/**
 *
 * Encoder
 * Encryption / Decryption class.
 *
 *
 */
class Encoder
{
    const METHOD = 'aes-256-cbc';

    private $key;

    public function __construct(string $key)
    {
        $this->key = $key;
    }

    public function encryptAES256(string $message)
    {
        $iv = openssl_random_pseudo_bytes(openssl_cipher_iv_length(self::METHOD));

        $data = openssl_encrypt($message, self::METHOD, $this->key, OPENSSL_RAW_DATA, $iv);

        $iv = base64_encode($iv);
        $data = base64_encode($data);

        $mac = $this->getMac($iv.$data);

        $json = json_encode(compact('iv', 'data', 'mac'));
        return base64_encode($json);
    }

    public function decryptAES256(string $enc)
    {
        $data = json_decode(base64_decode($enc), true);
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
