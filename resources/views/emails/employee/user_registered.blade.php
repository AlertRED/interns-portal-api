@extends('emails.layouts.base')

@section('content')
    <center>Стажер {{$fullName}} зарегистрировался на learn.2-up.ru</center>

    <b>Email:</b> {{$user->email}}<br/>
    <b>Логин:</b> {{$user->login}}<br/>
    <b>Поток:</b> {{$user->course->course}}<br/>
@endsection