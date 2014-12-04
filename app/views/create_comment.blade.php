@extends('_master')

@section('title')
	Comment on this event
@stop

@section('content')
	<h2>Comment on this event</h2>

	{{ $event['title'] }}<br>
	Where: {{ $event['location'] }} <br>
	When: <?php $date = date_create($event['when']); ?>
			{{ date_format($date, 'm/d/Y g:i A') }}<br>
	What: {{ $event['description'] }}<br>

	{{ Form::open(array('url' => '/comments')) }}

		{{ Form::label('text')}}
		{{ Form::textarea('text') }}

		<input type="hidden" name="holiday_id" value="{{ $event['id'] }}" />

		{{ Form::submit() }}

	{{ Form::close() }}

@stop