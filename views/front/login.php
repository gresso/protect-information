<?php
$this->title = 'Вход в систему';
?>
<h1><?=$this->title?></h1>

<form id="LoginForm">
    <input type="text" name="email" placeholder="email">
    <input type="text" name="passw"  placeholder="passw">
    <input type="hidden" name="code" placeholder="ACode">
    <button type="button" id="SendLoginForm">Выслать авторизационный код</button>
</form>

<form id="VerifCode" style="display:none">
    <input type="text" name="code" placeholder="ACode">
    <input type="hidden" name="email">
    <input type="hidden" name="passw">
    <button type="button" id="SendVerifCode">Войти</button>
</form>