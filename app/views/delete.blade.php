@extends('_master')

@section('title')
	| Delete this event
@stop

@section('content')
	<h2>Are you sure you want to delete "{{ $event['title'] }}"?</h2>

	{{ Form::open(array('url' => '/events/delete')) }}

		{{ Form::hidden('id',$event['id']); }}

	{{ Form::submit('Yes', array('class' => 'btn btn-default')); }}

	<a href="/events/view/{{$event['id']}}">NO, take me back!</a>

	{{ Form::close() }}

@stop