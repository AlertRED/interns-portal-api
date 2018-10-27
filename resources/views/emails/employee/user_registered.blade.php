@extends('emails.layouts.base')

@section('content')
    <center>Стажер {{$fullName}} зарегистрировался на learn.2-up.ru</center>

    <b>email:</b> {{$user->email}}<br/>
    <b>логин:</b> {{$user->login}}<br/>
@endsection