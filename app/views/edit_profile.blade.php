@extends('_master')

@section('title')
	Edit Profile
@stop

@section('content')

<h1>Edit Profile</h1>

@foreach($errors->all() as $message)
    <div class='error'>{{ $message }}</div>
@endforeach

{{ Form::open(array('url' => '/edit_profile')) }}

	{{ Form::label('username') }}
	{{ Form::text('username', $user['username']) }} <br><br>

    {{ Form::label('email') }}
    {{ Form::text('email', $user['email']) }}<br><br>

    {{ Form::label('new_password') }}
    {{ Form::password('new_password') }}<br><br>

    {{ Form::label('new_password_confirmation') }}
    {{ Form::password('new_password_confirmation') }}<br><br>

    {{ Form::label('date of birth')}}
    <br>
    {{Form::label('month')}}
		{{Form::selectRange('month', 1, 12, $dob['month'])}}
	{{Form::label('day')}}
		{{Form::selectRange('day', 1, 31, $dob['day'])}}
	{{Form::label('year')}}
		{{Form::selectRange('year', 2000, 1900, $dob['year'])}}
        <br>
    <br>
    {{ Form::submit('Submit') }}

{{ Form::close() }}

@stop