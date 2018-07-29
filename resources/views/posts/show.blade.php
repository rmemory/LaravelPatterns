@extends('layouts.master')

@section('content')
	<div class="col-sm-8 blog-main">
		@include ('posts.post', ['post' => $post])

		@if (count ($post->comments))
			<hr>

			<div class="list-group">
				<ul>
					@foreach ($post->comments as $comment)
						<l1 class="list-group-item">
							<strong>
								{{ $comment->created_at->diffForHumans() }}: &nbsp;
							</strong>
							{{ $comment->body }}
						</l1>
					@endforeach
				</ul>
			</div>

		@endif
		<div class="card">
			<div class="card-block">
				<hr>
				<div class="form-group">
						@include ('layouts.errors')
				</div>
				{!! Form::open(['method' => 'post', 'action' => array('CommentsController@store', $post->id)]) !!}
					<div class="form-group">
						{!! Form::label('body', 'Comment:') !!}
						{!! Form::textarea('body', null, ['class' => 'form-control', 'placeholder' => 'Your comment here', 'required']) !!}
					</div>

					<div class="form-group">
						{!! Form::submit('Add Comment', ['class' => 'btn btn-primary']) !!}
					</div>
				{!! Form::close() !!}
			</div>
		</div>
	</div>
@endsection
