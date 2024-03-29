<?php
require __DIR__ . "/php-jwt/vendor/autoload.php";
// require __DIR__ . '/vendor/autoload.php';

// Dotenv\Dotenv::createUnsafeImmutable(__DIR__ . '/')->load();
// $key =  $_ENV['JWT_KEY'];

use Firebase\JWT\JWT;
use Firebase\JWT\Key;

class JwtHandler
{
    protected $secrect;
    protected $issuedAt;
    protected $expire;

    function __construct()
    {
        // set your default time-zone
        date_default_timezone_set('	Asia/Tomsk');
        $this->issuedAt = time();

        // Token Validity (3600 second = 1hr)
        $this->expire = $this->issuedAt + (12*3600);

        // Set your strong secret or signature
        // $this->secrect = "this_is_my_secrect";
        $this->secrect = "some_key_787885123";
        // $this->secrect = $key;
    }

    public function encode($iss, $data)
    {

        $token = array(
            //Adding the identifier to the token (who issue the token)
            "iss" => $iss,
            "aud" => $iss,
            // Adding the current timestamp to the token, for identifying that when the token was issued.
            "iat" => $this->issuedAt,
            // Token expiration
            "exp" => $this->expire,
            // Payload
            "data" => $data
        );

        return JWT::encode($token, $this->secrect, 'HS256');
    }

    public function decode($token)
    {
        try {
            $decode = JWT::decode($token, new Key($this->secrect, 'HS256'));
            return $decode->data;
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }
}