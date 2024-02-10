<?php
namespace App\Controller;

use Throwable;

class Monolith
{
    function encrypt($text, $password) {
        $iv = openssl_random_pseudo_bytes(16);
        $encrypted = openssl_encrypt($text, 'aes-256-cbc', $password, OPENSSL_RAW_DATA, $iv);
        $encodedIV = urlencode(bin2hex($iv));
        $encodedEncryptedText = urlencode(bin2hex($encrypted));
        return $encodedIV . ':' . $encodedEncryptedText;
    }
    function decrypt($ciphered, $password): string|null {
        try {
            $data = explode(":", $ciphered);
            $iv = hex2bin(urldecode($data[0]));
            $ciphertext = hex2bin(urldecode($data[1]));
            return openssl_decrypt($ciphertext, 'aes-256-cbc', $password, OPENSSL_RAW_DATA, $iv);
        } catch (Throwable $e) {
            return null;
        }
    }
    
}