@extends('_master')

@section('title')
	{{ $event['id'] }}
@stop

@section('content')

	{{ $event['title'] }}<br>
	Where: {{ $event['location'] }} <br>
	When: {{ $event['when'] }}<br>
	What: {{ $event['description'] }}<br>
	<a href="edit/{{$event['id']}}">Edit</a> |
	<a href="delete/{{$event['id']}}">Delete</a>

@stop