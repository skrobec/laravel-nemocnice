@extends('layouts.side-nav')
@section('content')
    <h2>Hospitalizace</h2>
    @foreach($hospitalizations as $hospitalization)
        ID: {{$hospitalization->id}}<br>
        Jméno pacienta: {{$hospitalization->patient->name}}<br>
        Oddělení: {{$hospitalization->section->name}}<br>
        Začátek a konec: {{$hospitalization->date_start}} - {{$hospitalization->date_end}}<br><br>
    @endforeach
@endsection
