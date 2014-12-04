@extends('_master')

@section('title')
	{{ $event['title'] }}
@stop

@section('content')

	{{ $event['title'] }}<br>
	Where: {{ $event['location'] }} <br>
	When: <?php $date = date_create($event['when']); ?>
			{{ date_format($date, 'm/d/Y g:i A') }}<br>
	What: {{ $event['description'] }}<br>
	<a href="edit/{{$event['id']}}">Edit</a> |
	<a href="delete/{{$event['id']}}">Delete</a>

	<h2>Comments</h2> 

	@foreach ($comments as $comment)
		<p>
			{{ $comment['text'] }}
			<br>
			by {{ $comment['user_id']}}  <!-- deal with this later  -->
			at <?php $comment_timestamp = date_create($comment['created_at']); ?>
			{{ date_format($comment_timestamp, 'm/d/Y g:i A') }}
		</p>
	@endforeach

	<p>
		<a href="/comments/{{$event['id']}}">Add a Comment</a>
	</p>

@stop