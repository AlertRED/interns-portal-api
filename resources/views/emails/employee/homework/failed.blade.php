@extends('emails.layouts.base')

<?php
    $homework = isset($homework) ? $homework : null;
    $homeworkName = $homework ? "№" . $homework->homework->number . " - " . $homework->homework->name : "?";
    $user = $homework->user;
?>

@section('content')
    <center>Стажер {{$user->getFullName()}} провалил домашнюю работу {{$homeworkName}}</center>
@endsection