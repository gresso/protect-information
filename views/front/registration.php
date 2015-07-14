<?php
/* @var $this yii\web\View */
$this->title = 'Регистрация нового пользователя';
?>


<h1><?=$this->title?></h1>

<form id="regform">
    <input type="text" name="email" placeholder="email">
    <input type="text" name="passw"  placeholder="passw">
    <input type="text" name="passw2"  placeholder="passw2">
    <button type="button" id="senddata">Зарегистрироваться</button>

</form>

