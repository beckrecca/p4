@extends('_master')

@section('title')
	Comment on this event
@stop

@section('content')

	<h4>{{ $event['title'] }}</h4><br>
	Where: {{ $event['location'] }} <br>
	When: <?php $date = date_create($event['when']); ?>
			{{ date_format($date, 'm/d/Y g:i A') }}<br>
	What: {{ $event['description'] }}<br>
	<a href="/eventsedit/{{$event['id']}}">Edit</a> |
	<a href="/eventsdelete/{{$event['id']}}">Delete</a>

	 <h4>Comment on this event</h4>

	 @foreach($errors->all() as $message)
    <div class='error'>{{ $message }}</div>
	@endforeach

	{{ Form::open(array('url' => '/comments')) }}

		{{ Form::label('text' )}} (Limit 160 characters) <br>
		{{ Form::textarea('text', null, ['size' => '30x4']) }}

		<input type="hidden" name="holiday_id" value="{{ $event['id'] }}" />

		<br>
		{{ Form::submit() }}

	{{ Form::close() }}

	<h4>Comments</h4>

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