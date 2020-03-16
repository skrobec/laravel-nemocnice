@extends('layouts.side-nav')
@section('content')
    <h2>Oddělení</h2>
    @foreach($sections as $section)
        ID: {{$section->id}}<br>
        Název: {{$section->name}}<br>
        Kapacita: {{$section->capacity}}<br><br>
    @endforeach

@endsection
