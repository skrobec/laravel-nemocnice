
@extends('layouts.side-nav')
@section('content')

    @foreach($exams as $exam)
        ID: {{$exam->id}}<br>
        Datum: {{$exam->datum}}<br>
        Pacient: {{$exam->patient}}<br>
        Zapis: {{$exam->zapis}}<br><br>
    @endforeach

@endsection
