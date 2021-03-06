@extends('_master')

@section('title')
	| {{ $title }}
@stop

@section('content')

	<h4> {{ $header }} </h4>

	@if (isset($events))
		<div class="event">
			<div class="row">
				<div class="col-sm-6">
					@foreach ($events as $event)
					<div class="panel panel-default">
						<div class="panel-heading">
							<div class="title">
								<a href="/events/view/{{$event['id']}}">{{ $event['title'] }}</a><br>
							</div>
							@if ($user == $event['user_id'])
								<div class="x">
									<a href="/events/edit/{{$event['id']}}">Edit</a> |
									<a href="/events/delete/{{$event['id']}}">Delete</a> 
								</div>
							@endif
						</div>
						<div class="panel-body">
							<label>Where:</label> {{ $event['location'] }} <br>
							<label>When:</label> <?php $date = date_create($event['when']); ?>
							{{ date_format($date, 'l m/d/Y g:i A') }}<br>
							<label>What:</label> {{ $event['description'] }}<br>
							@if ($user == $event['user_id'])
								<small>You created this event.</small>
							@endif
							<div class="comment-link">
								<a href="/comments/{{$event['id']}}">Comment</a>
							</div>
						</div>
					</div>
					@endforeach
				</div>
				<div class="col-sm-6">
					@if (isset($upcoming_birthdays) || isset($upcoming_occasions))
					<h4>Celebrate!</h4>
						<ul class="upcoming">
						@foreach ($upcoming_occasions as $occasion) 
							<li>{{ $occasion }} </li>
						@endforeach
						@foreach ($upcoming_birthdays as $birthday)
							<li>{{ $birthday }} </li>
						@endforeach
						</ul>
					@endif
				</div>
			</div>
		</div>

		{{ $events->links() }}
	@else
		<p>Something went terribly wrong.</p>
	@endif

@stop