@extends('_master')

@section('title')
	| Profile
@stop

@section('content')
	<h4>User Profile</h4>
	<a href="/edit_profile">Edit</a>

	<br><br>
	Username: {{ $user['username'] }}
	<br><br>
	Date of Birth: <?php $dob = date_create($user['DOB']); ?>
	{{ date_format($dob, 'm/d/Y') }}

@stop