<?php

namespace app\models;


class Crypt
    {
    // Конфигурируем шифровщик
    static $crypt_cipher	=	MCRYPT_RIJNDAEL_256;
    static $crypt_mode		=	MCRYPT_MODE_ECB;
    static $crypt_rand		=	MCRYPT_DEV_URANDOM;
    private $key;
    private $iv;


    public function setKey($key){
        $this->key = md5($key);
    }

    public function setIv(){
       $this->iv = mcrypt_create_iv(mcrypt_get_iv_size(self::$crypt_cipher, self::$crypt_mode), self::$crypt_rand);
    }

    public function encrypt($encrypt) {
        $passcrypt = trim(mcrypt_encrypt(self::$crypt_cipher, $this->key, trim($encrypt), self::$crypt_mode, $this->iv));
        $encode = base64_encode($passcrypt);
        return $encode;
    }


    public function decrypt($decrypt) {
        $decoded = base64_decode($decrypt);
        $iv = mcrypt_create_iv(mcrypt_get_iv_size(self::$crypt_cipher, self::$crypt_mode), self::$crypt_rand);
        $decrypted = trim(mcrypt_decrypt(self::$crypt_cipher, $this->key, trim($decoded), self::$crypt_mode, $this->iv));
        return $decrypted;
    }


}

