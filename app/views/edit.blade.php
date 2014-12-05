@extends('_master')

@section('title')
	Edit an event
@stop

@section('content')
	<h2>Edit an event</h2>

	{{ Form::open(array('url' => '/events/edit')) }}

		{{ Form::hidden('id',$event['id']); }}

		{{ Form::label('title')}}
		{{ Form::text('title', $event['title']) }}
		<br>
		{{ Form::label('location')}}
		{{ Form::text('location', $event['location']) }}
		<br>
		{{ Form::label('date')}}
		<input type="text" id="datepicker" size="30" name="date">
		<br>

		{{Form::label('time')}}
		{{Form::selectRange('hour', 1, 12)}}
		{{Form::select('m', array(0 => "AM", 1 => "PM"), 0)}}
        <br>
		{{ Form::label('description')}}
		{{ Form::text('description', $event['description'])}}
		<br>
		{{ Form::submit() }}

	{{ Form::close() }}

@stop

@section('/body')
<script>
  $(function() {
    $("#datepicker").datepicker({dateFormat: 'yy-mm-dd'});
  });
</script>

@stop