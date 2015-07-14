<?php

namespace app\models;
use yii\db\Query;

class User extends \yii\base\Object implements \yii\web\IdentityInterface

{
    public $id;
    public $email;
    public $passw;
    public $authKey;




    public static function findIdentity($id){
        return (new Query())->from('user')->where(['id'=>$id])->one();
    }

    public static function findIdentityByAccessToken($token, $type = null){}

    public function getId(){
        return $this->id;
    }

    public function getAuthKey(){}

    public function validateAuthKey($authKey){}


    public function getUserByLogin($login){
        $u = (new Query())->from('user')->where(['email'=>$login])->one();
        return new static($u);
    }

}
