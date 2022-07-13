@extends('layout')

@section('title','Create the post')

@section('content')
    <form method="POST" action="{{ route('posts.store')}}" enctype="multipart/form-data">
        @csrf

        @include('posts._form')   
        <div><input type="submit" value="Create" class="btn btn-primary btn-block w-100 mt-2"></div>
    </form>
@endsection