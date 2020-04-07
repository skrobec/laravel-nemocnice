@extends('layouts.side-nav')
@section('content')
    <h2>Uživatelé</h2>
    @foreach($users as $user)
        ID: {{$user->id}}<br>
        Jmeno: {{$user->name}}<br>
        Email: {{$user->email}}<br>

        <br>
    @endforeach
@endsection
