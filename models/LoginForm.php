<?php

namespace app\models;

use Yii;
use yii\base\Model;

/**
 * LoginForm is the model behind the login form.
 */
class LoginForm extends Model
{
    public $email;
    public $passw;
    public $code;
    public $_errors;

    /**
     * @return array the validation rules.
     */
    public function rules()
    {
        return [
            [['email', 'passw'], 'required'],
            ['passw', 'validatePassw'],
            ['email', 'email'],
            ['email', 'isSetAttrDb'],
        ];
    }



    /**
     * Отсылаем код авторизации
     */
    public function SendCode(){

        //Если данные валидны и пользователь есть в базе данных
        if ($this->validate() && $this->isUserInDb()){
            $this->generateVerifCode();
        }
        $this->_errors = $this->errors;

    }

    /**
     * Генерит и записывает хеш кода верификации
     */

    public  function generateVerifCode(){
        $code = Yii::$app->security->generateRandomString(4);
        //Пишем хеш в базу
        Yii::$app->db
            ->createCommand("UPDATE user SET AuthKey='".md5($code)."' WHERE email = '$this->email';")
            ->execute();
        //Отправляем код пользователю
        $this->SendMailVerifCod($code);
    }


    /**
     * Отправляет письмо с кодом верификации
     */

    public  function SendMailVerifCod($code){
        Yii::$app->mailer->compose('verificode', ['code'=>$code])
            ->setTo($this->email)
            ->setFrom([Yii::$app->params['appEmail'] => Yii::$app->params['appName']])
            ->setSubject('Verification Code.')
            ->send();
        return true;

    }

    /**
     * Проверяет есть ли юзер с указанным логином и паролем
     */

    public  function isUserInDb(){
        $ur = Yii::$app->db
            ->createCommand("select count(*) as `count` from `user` where `email` = '{$this->email}' and `passw`='".md5($this->passw)."';")
            ->queryOne();

        if ($ur['count']!=1){
            $this->addError('form',"Пара логин и пароль не совпадают");
            return false;
        }
        if ($ur['count']==1){
            return true;
        }

    }

    /**
     * Логиним пользователя
     */
    public function login(){
        if ($this->validate()){

        }
        $this->_errors = $this->errors;

    }


    /**
     * Проверка занятости в базе
     */
    public function isSetAttrDb($attr){
        $us = Yii::$app->db
            ->createCommand("select count(*) as `count` from `user` where `{$attr}` = '{$this->$attr}'")
            ->queryOne();

        if ($us['count']!=1){
            $this->addError($attr,"Пользователь с таким {$attr} не зарегистрирован в нашей системе");
        }
    }

    /**
     * Валидация пароля
     */
    public function validatePassw($attr){

        if (strlen($this->$attr)<=3){
            $this->addError($attr, 'Пароль менее 4-х символов');
        }

        if (!preg_match("/^[0-9a-z]+$/i", $this->$attr)){
            $this->addError($attr, 'Пароль должен состоять из A-Z;a-z;0-9.');
            return false;
        }

        if (preg_match("/^[0-9]+$/i", $this->$attr) || preg_match("/^[a-z]+$/i", $this->$attr)){
            $this->addError($attr, 'Пароль должен состоять из сочетаний букв и цифр.');
            return false;
        }
        return true ;
    }

}
