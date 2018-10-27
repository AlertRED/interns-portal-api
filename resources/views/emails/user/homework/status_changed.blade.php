@extends('layouts.base')

@section('content')
<center>У домашней работы {{$internHomework->homework->name}} изменился статус</center>

<b>Новый статус:</b> {{$internHomework->status}}<br/>
@endsection