@extends('_master')

@section('title')
	| Add a new event
@stop

@section('content')
	<h4>Add a new event</h4>
	@foreach($errors->all() as $message)
    <div class='error'>{{ $message }}</div>
	@endforeach

	{{ Form::open(array('url' => '/events/create', 'id' => 'validateForm')) }}

		{{ Form::label('title')}}
		{{ Form::text('title') }}
		<br>
		{{ Form::label('location')}}
		{{ Form::text('location') }}
		<br>
		{{ Form::label('date')}}
		<input type="text" id="validDefaultDatepicker" size="30" name="date">
		<br>

		{{Form::label('time')}}
		{{Form::selectRange('hour', 1, 12)}}
		{{Form::select('m', array(0 => "AM", 1 => "PM"), 0)}}
        <br>
		{{ Form::label('description')}} <br>
		{{ Form::textarea('description', null, ['size' => '30x4']) }}
		<br>
		{{ Form::submit() }}

	{{ Form::close() }}

@stop

@section('/body')
<script>
  $(function() {
    $("#validDefaultDatepicker").datepicker({dateFormat: 'yy-mm-dd'});
  });
</script>

@stop