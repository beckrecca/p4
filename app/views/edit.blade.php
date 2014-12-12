@extends('_master')

@section('title')
	Edit an event
@stop

@section('content')
	<h4>Edit an event</h4>

	@foreach($errors->all() as $message)
    <div class='error'>{{ $message }}</div>
	@endforeach

	{{ Form::open(array('url' => '/events/edit')) }}

		{{ Form::hidden('id',$event['id']); }}

		{{ Form::label('title')}}
		{{ Form::text('title', $event['title']) }}
		<br>
		{{ Form::label('location')}}
		{{ Form::text('location', $event['location']) }}
		<br>
		{{ Form::label('date')}}
		<input type="text" id="datepicker" size="30" name="date" value="{{ $when['date']}}">
		<br>

		{{Form::label('time')}}
		{{Form::selectRange('hour', 1, 12, $when['time']) }}
		{{Form::select('m', array(0 => "AM", 1 => "PM"), $when['timeofday'])}}
        <br>
		{{ Form::label('description')}} <br>
		{{ Form::textarea('description', null, ['size' => '30x4']) }}
		<br>
		{{ Form::submit() }}
		<a href="/events" class="btn btn-default btn-sm">Cancel</a>
	{{ Form::close() }}


@stop

@section('/body')
<script>
  $(function() {
    $("#datepicker").datepicker({dateFormat: 'yy-mm-dd'});
  });
</script>

@stop