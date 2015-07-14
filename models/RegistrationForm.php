<?
namespace app\models;
use Yii;
use yii\base\Model;
use yii\debug\models\search\Db;


class registrationForm extends Model
{

    public $email;
    public $passw;
    public $passw2;
    public $u_reg = false;
    public $_errors;


    public function rules()
    {
        return [
            [['email', 'passw', 'passw2'], 'required'],
            ['email', 'originAttrDb'],
            [['passw','passw2'], 'validatePassw'],
            [['passw'], 'validateСonfirmPass'],
            ['email', 'email']
        ];

    }

    /**
    Пишет Юзера в базу
     */

    public function UserReg(){
        if ($this->validate()){
           $db = Yii::$app->db;
           if ($db->createCommand()->insert('user',['email'=>$this->email, 'passw'=>md5($this->passw)])->execute()){
               $this->u_reg = true;
               //Оттправить уведомление о успешной регистрации
               $this->mailConfurm();
            }
        }
        $this->_errors = $this->errors;

    }


    /**
     * Отправляем почтовое уведомление об успешной регистрации
     */
    public function mailConfurm()
    {

            Yii::$app->mailer->compose('registration', ['model'=>$this])
                ->setTo($this->email)
                ->setFrom([Yii::$app->params['appEmail'] => Yii::$app->params['appName']])
                ->setSubject('Registration Good!')
                ->send();
            return true;

    }



    /**
     * Проверка занятости в базе
     */
    public function originAttrDb($attr){
        $us = Yii::$app->db
            ->createCommand("select count(*) as `count` from `user` where `{$attr}` = '{$this->$attr}'")
            ->queryOne();

        if ($us['count']>0){
            $this->addError($attr,"Пользователь с таким {$attr} уже зарегистрирован в нашей системе");
        }


    }
    /**
     * Валидация паролей на совпадение
     */
    public function validateСonfirmPass($attr){
        if ($this->passw !== $this->passw2){
            $this->addError($attr,'Поля пароль и подтверждение не совпадают');
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


?>