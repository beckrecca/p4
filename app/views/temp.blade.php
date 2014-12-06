@extends('_master')

@section('title')
	Lame landing page
@stop

@section('content')

<h1>It's a work in progress, folks!</h1>

<p>
	Hello, everyone. My final project is supposed to (very basically) mimic the Event application of Facebook. I created it for my family to use, since half of them don't use Facebook for whatever reason.

</p>

@foreach($errors->all() as $message)
    <div class='error'>{{ $message }}</div>
@endforeach

<h3>A running to do list...</h3>
<li>Adjust time zone (for comments)</li>
<li>Layout/CSS MAKE PRETTY etc</li>
<li>Create seeds</li>
<li>Launch to production</li>
<a href='/events'>Continue anyway</a>

@stop