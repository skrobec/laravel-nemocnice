@extends('layouts.side-nav')
@section('content')
    <h2>Léky</h2>
    @foreach($drugs as $drug)
        ID: {{$drug->id}}<br>
        Název: {{$drug->name}}<br>
        Popis: {{$drug->description}}<br>
        Přehled podání: <br>
            @foreach($drug->servings as $serving)
                Jméno sestry: {{$serving->nurse->user->name}}<br>
                Jméno pacienta: {{$serving->patient->name}} {{$serving->patient->surname}}<br>
                Množství léku: {{$serving->pivot->amount}}<br><br>
            @endforeach
    @endforeach

@endsection
