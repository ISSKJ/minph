<?php


namespace Minph\Crypto;


/**
 * @interface Minph\Crypt\Encoder
 */
interface Encoder
{
    /**
     * @method encrypt
     * @param string `$message`
     * @return string enctypted message
     */
    public function encrypt($message);
    /**
     * @method decrypt
     * @param string `$encrypted`
     * @return string decrypted message
     */
    public function decrypt($encrypted);
}
