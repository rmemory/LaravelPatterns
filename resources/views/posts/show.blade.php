@extends('layouts.master')

@section('content')
	<div>This will show a post</div>
	<p>{{ $post->body }}</p>
@endsection