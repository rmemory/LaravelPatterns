@extends('layouts.master')

@section('content')
<div class="col-sm-8 blog-main">
	<h1>Create a Post</h1>
	<hr>

	{!! Form::open(['method' => 'post', 'action' => 'PostsController@store']) !!}
		<div class="form-group">
			{!! Form::label('title', 'Title:') !!}
			{!! Form::text('title', null, ['class' => 'form-control', 'required']) !!}
		</div>

		<div class="form-group">
			{!! Form::label('body', 'Body:') !!}
			{!! Form::textarea('body', null, ['class' => 'form-control', 'required']) !!}
		</div>	

		<div class="form-group">
			{!! Form::submit('Publish', ['class' => 'btn btn-primary']) !!}
		</div>

		<div class="form-group">
			@include ('layouts.errors')
		</div>
	{!! Form::close() !!}
</div>
@endsection