@extends('_master')

@section('title')
	Sign Up
@stop

@section('content')

<h4>Sign up</h4>

@foreach($errors->all() as $message)
    <div class='error'>{{ $message }}</div>
@endforeach

{{ Form::open(array('url' => '/signup')) }}

	{{ Form::label('username') }}
	{{ Form::text('username') }} <br><br>

    {{ Form::label('email') }}
    {{ Form::text('email') }}<br><br>

    {{ Form::label('password') }}
    {{ Form::password('password') }}<br><br>

    {{ Form::label('password_confirm') }}
    {{ Form::password('password_confirm') }}<br><br>

    {{ Form::label('date of birth')}}
    <br>
    {{Form::label('month')}}
		{{Form::selectRange('month', 1, 12)}}
	{{Form::label('day')}}
		{{Form::selectRange('day', 1, 31)}}
	{{Form::label('year')}}
		{{Form::selectRange('year', 2000, 1900)}}
        <br>
    <br>
    {{ Form::submit('Submit') }}

{{ Form::close() }}

@stop