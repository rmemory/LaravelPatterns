@extends('layouts.master')

@section('content')
	<div class="col-sm-8 blog-main">
		@include ('posts.post', ['post' => $post])
	</div>
@endsection
