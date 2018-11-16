@extends('emails.layouts.base')

@section('content')
У домашней работы №{{$homework->homework->number}} - {{$homework->homework->name}} изменился статус c {{$prevStatus}} на {{$newStatus}}
@endsection