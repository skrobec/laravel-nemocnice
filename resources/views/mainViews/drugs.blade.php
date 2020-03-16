@extends('layouts.side-nav')
@section('content')
    <h2>Léky</h2>
    @foreach($drugs as $drug)
        ID: {{$drug->id}}<br>
        Název: {{$drug->name}}<br>
        Popis: {{$drug->description}}<br><br>
    @endforeach

@endsection
