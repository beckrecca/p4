<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>@yield('title', 'A work in progress')</title>
    <!-- makes the layout responsive -->
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Bootstrap -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap.min.css">
    <!-- jQuery datepicker -->
    <link rel="stylesheet" href="//code.jquery.com/ui/1.11.2/themes/smoothness/jquery-ui.css">
    <script src="//code.jquery.com/jquery-1.10.2.js"></script>
    <script src="//code.jquery.com/ui/1.11.2/jquery-ui.js"></script>
</head>

<body>
<div class="container">

     <div class="navigation">
        <ul>
            <li><a href="/events">Home</a></li>
            <li><a href="/events/all">View all events</a></li>
            <li><a href="/events/create">Create an event</a></li>
            <li>
                @if(Auth::check())
                <a href="/edit_profile">Edit profile</a>
            </li>
            <li>
                <a href='/logout'>Log out {{ Auth::user()->username; }}</a>
            </li>
                @else 
                <a href='/signup'>Sign up</a> or <a href='/login'>Log in</a>
                @endif
            </li>
        </ul>
     </div>

     @if(Session::get('flash_message'))
        <div class="flash-message">{{ Session::get('flash_message') }}</div>
     @endif

    @yield('content')
</div>

@yield('/body')
</body>
</html>