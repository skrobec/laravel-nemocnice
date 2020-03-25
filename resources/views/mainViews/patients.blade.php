
@extends('layouts.side-nav')
@section('content')
<h2>Pacienti</h2>
    @foreach($patients as $patient)
        ID: {{$patient->id}}<br>
        Jmeno: {{$patient->name}}<br>
        Prijmeni: {{$patient->surname}}<br>
        Problemy: {{$patient->issues}}<br>
        Zákroky: {{$patient->interventions}}<br><br>
    @endforeach

@endsection
