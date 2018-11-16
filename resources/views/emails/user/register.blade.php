@extends('emails.layouts.base')

@section('content')
<center>Вы успешно зарегистрировались на learn.2-up.ru</center>

<p>Ваши данные для входа:</p>

<b>логин:</b> {{$user->login}}<br/>
<b>пароль:</b> {{$password}}<br/>
@endsection