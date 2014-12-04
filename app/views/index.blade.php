@extends('_master')

@section('title')
	Test!
@stop

@section('content')

	@if (isset($events))
		@foreach ($events as $event)
			<p>
			<a href="events/{{$event['id']}}">{{ $event['title'] }}</a><br>
			Where: {{ $event['location'] }} <br>
			When: <?php $date = date_create($event['when']); ?>
			{{ date_format($date, 'm/d/Y g:i A') }}<br>
			What: {{ $event['description'] }}<br>
			<a href="events/edit/{{$event['id']}}">Edit</a> |
			<a href="events/delete/{{$event['id']}}">Delete</a> |
			<a href="events/view/{{$event['id']}}">View</a>
		</p>
		@endforeach
	@else
		<p>Something went terribly wrong.</p>
	@endif

@stop