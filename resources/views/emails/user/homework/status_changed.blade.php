@extends('emails.layouts.base')

@section('content')
<center>У домашней работы №{{$homework->homework->number}} {{$homework->homework->name}} изменился статус на {{$homework->status}}</center>

<b>Новый статус:</b> {{$homework->status}}<br/>
@endsection