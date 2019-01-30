@extends('emails.layouts.base')

<?php
    $homework = isset($homework) ? $homework : null;
    $homeworkName = $homework ? "№" . $homework->homework->number . " - " . $homework->homework->name : "?";
    $user = $homework->user;
?>

@section('content')
    <center>Стажер {{$user->fullName()}} изменил статус домашней работы {{$homeworkName}} c {{ $prevStatus }} на {{$newStatus}}</center>
@endsection