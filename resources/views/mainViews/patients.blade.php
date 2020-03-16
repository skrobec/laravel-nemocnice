
@extends('layouts.side-nav')
@section('content')

    @foreach($patients as $patient)
        ID: {{$patient->id}}<br>
        Jmeno: {{$patient->name}}<br>
        Prijmeni: {{$patient->surname}}<br>
        Problemy: {{$patient->issues}}<br><br>
    @endforeach

@endsection
