@extends('_master')

@section('title')
	| {{ $title }}
@stop

@section('content')

	<h4> {{ $header }} </h4>

	@if (isset($events))
		@foreach ($events as $event)
		<div class="event">
			<div class="row">
				<div class="col-sm-5">
					<div class="panel panel-default">
						<div class="panel-heading">
							<div class="title">
								<a href="/events/view/{{$event['id']}}">{{ $event['title'] }}</a><br>
							</div>
							<div class="x">
								<a href="/events/edit/{{$event['id']}}">Edit</a> |
								<a href="/events/delete/{{$event['id']}}">Delete</a> |
								<a href="/events/view/{{$event['id']}}">View</a>
							</div>
						</div>
						<div class="panel-body">
							Where: {{ $event['location'] }} <br>
							When: <?php $date = date_create($event['when']); ?>
							{{ date_format($date, 'l m/d/Y g:i A') }}<br>
							What: {{ $event['description'] }}<br>
						</div>
					</div>
				</div>
			</div>
		</div>
		@endforeach

		{{ $events->links() }}
	@else
		<p>Something went terribly wrong.</p>
	@endif

@stop