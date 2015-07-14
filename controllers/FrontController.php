<?php

namespace app\controllers;


use Yii;
use app\models\LoginForm;
use app\models\registrationForm;
use yii\web\Controller;


class FrontController extends Controller
{



    /**
     * Рисует форму авторизации
     */
    public  function actionLogin(){
        if (Yii::$app->user->isGuest) {
            return $this->render('login');
        }
        else{
            return $this->goHome();
        }
    }

    /**
     *  Валидация + авторизация пользователя
     */

    public function actionApi_login(){
        $post = Yii::$app->request->post();
        $model = new LoginForm();
        if (!$model->load($post,'')){
            return false;
        }

        if (isset($post['code'])){
            $model->login();
            return json_encode($model);
        }

        $model->SendCode();
        return json_encode($model);

    }



    /**
     * Рисует форму регистрации
     */
    public  function actionRegistration(){
        if (Yii::$app->user->isGuest) {
            return $this->render('registration');
        }
        else{
            return $this->goHome();
        }
    }


    /**
     *  Валидация + регистрация пользователя
     */

    public function actionApi_registration(){
       $model = new registrationForm();
       if (!$model->load(Yii::$app->request->post(),'')){
          return false;
       }
       $model->UserReg();
       return json_encode($model);
    }


    public function actionIndex()
    {
        return $this->render('index');
    }


    public function actionTest(){
    echo '<pre>';
    print_r(Yii::$app->security->generateRandomString(4));
    echo '</pre>';
}
}






