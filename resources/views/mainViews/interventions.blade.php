
@extends('layouts.side-nav')
@section('content')
    <h2>Zákroky</h2>
    @foreach($interventions as $intervention)
        ID: {{$intervention->id}}<br>
        Datum: {{$intervention->datum}}<br>
        Pacient: {{$intervention->patient}}<br>
        Doktoři: {{$intervention->doctors}}<br><br>
        Sestry: {{$intervention->nurses}}<br><br>
    @endforeach

@endsection
