@extends('_master')

@section('title')
	| Sign Up
@stop

@section('content')

<div class="col-xs-12 col-sm-6 col-sm-push-6">
    <h4>Hello there!</h4>
    <br>I hope this isn't confusing! For my final project this semester, I have created a web app
    for our family to plan and discuss events. 
    <ul>
        <li>This is supposed to be private! Please do not share the link! 
            <span class="error">DO NOT share the sign up link!</span></li>
        <li>Your username can be whatever you want so long as it's less than 12 characters long.
            I suggest easy names to remember like Becky or Marbles, rather than something complicated
            like marb91BFIbin or bec129-7q. </li>
        <li>If anything goes wrong with this website, please email me so I can fix it
            when I am at my computer: rebecca.doris42@gmail.com</li>

    </ul>
</div>

<div class="col-xs-12 col-sm-6 col-sm-pull-6">
    <h4>Sign up</h4>

    @foreach($errors->all() as $message)
        <div class='error'>{{ $message }}</div>
    @endforeach

    {{ Form::open(array('url' => '/V5RDN82zU67F8oG88x4q')) }}

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
        {{ Form::submit('Submit', array('class' => 'btn btn-default')); }}

    {{ Form::close() }}
</div>

@stop