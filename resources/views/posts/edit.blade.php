@extends('layout')

@section('title','Update the post')

@section('content')
<form method="POST"
    action="{{ route('posts.update',['post' => $post->id])}}" 
    enctype="multipart/form-data">
    @csrf
    @method('PUT')

    @include('posts._form')

    <div><input type="submit" value="Update" class="btn btn-primary btn-block"></div>
</form>
@endsection