@extends('layout')

@section('title',"Contact Page")

@section('content')
    <h1>This is a Contact Page</h1>
    <p>Hello this is contact!</p>

    @can('home.secret')
    <p>
        <a href="{{ route('secret') }}">
            Go to pecial contact details!
        </a>
    </p>
    @endcan

@endsection