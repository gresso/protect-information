<?php

namespace app\controllers;

use Yii;
use yii\web\Controller;
use app\models\Crypt;

class BackendController extends Controller
{
   public function actionTest(){
       $key = 'key';
       $text = '{"key":"val"}';
       $crypt = new Crypt();
       $crypt->setKey($key);

        // Зашифрованные данные
       echo $chifr = $crypt->encrypt($text);
       echo '<br/>';

       // Расшифрованные данные
       echo $crypt->decrypt($chifr);
       echo '<br/>';

       }
}






