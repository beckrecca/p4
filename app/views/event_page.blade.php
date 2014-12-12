@extends('_master')

@section('title')
	| {{ $event['title'] }}
@stop

@section('content')

	<h4>{{ $event['title'] }}</h4><br>
	Created by: {{ $username }} <br>
	Where: {{ $event['location'] }} <br>
	When: <?php $date = date_create($event['when']); ?>
			{{ date_format($date, 'm/d/Y g:i A') }}<br>
	What: {{ $event['description'] }}<br>
	<a href="/events/edit/{{$event['id']}}">Edit</a> |
	<a href="/events/delete/{{$event['id']}}">Delete</a>

	<h4>Comments</h4> 

	<p>
		<a href="/comments/{{$event['id']}}">Add a Comment</a>
	</p>

	@foreach ($comments as $comment)
		<p>
			{{ $comment['text'] }}
			<br>
			by {{ $users[$comment['id']] }} 
			at <?php $comment_timestamp = date_create($comment['created_at']); ?>
			{{ date_format($comment_timestamp, 'm/d/Y g:i A') }}
		</p>
	@endforeach

@stop