@extends('layouts.app')

<center>Вы успешно зарегистрировались</center>
<p>Ваши данные для входа</p><br/>

<b>Логин:</b> {{$user->login}}<br/>
<b>email:</b> {{$user->email}}<br/>
<b>пароль:</b> {{$password}}<br/>
