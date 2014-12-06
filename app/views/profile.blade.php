@extends('_master')

@section('title')
	Profile
@stop

@section('content')
	<h2>User Profile</h2>
	<a href="/edit_profile">Edit</a>

	<br><br>
	Username: {{ $user['username'] }}
	<br><br>
	Date of Birth: <?php $dob = date_create($user['DOB']); ?>
	{{ date_format($dob, 'm/d/Y') }}

@stop