@extends('_master')

@section('title')
	Add a new event
@stop

@section('content')
	<h2>Add a new event</h2>

	{{ Form::open(array('url' => '/events/create')) }}

		{{ Form::label('title')}}
		{{ Form::text('title') }}
		<br>
		{{ Form::label('location')}}
		{{ Form::text('location') }}
		<br>
		{{ Form::label('date')}}
		<input type="text" id="datepicker" size="30" name="date">
		<br>

		{{Form::label('time')}}
		{{Form::selectRange('hour', 1, 12)}}
		{{Form::select('m', array(0 => "AM", 1 => "PM"), 0)}}
        <br>
		{{ Form::label('description')}}
		{{ Form::text('description')}}
		<br>
		{{ Form::submit() }}

	{{ Form::close() }}

<script>
  $(function() {
    $("#datepicker").datepicker({dateFormat: 'yy-mm-dd'});
  });
</script>

@stop