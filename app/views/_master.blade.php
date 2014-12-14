<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Dorisdays @yield('title')</title>
    <!-- makes the layout responsive -->
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Bootstrap -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap.min.css">
    <!-- jQuery datepicker -->
    <link rel="stylesheet" href="//code.jquery.com/ui/1.11.2/themes/smoothness/jquery-ui.css">
    <!-- custom CSS -->
    <link rel="stylesheet" href="/css/custom.css">

    <!-- Javascript -->
    <script src="//code.jquery.com/jquery-1.10.2.js"></script>
    <script src="//code.jquery.com/ui/1.11.2/jquery-ui.js"></script>
</head>

<body>
<div class="container">

     <div class="header">
        <nav role ="navigation">
            <ul class="nav nav-pills pull-right">
                <li><a href="/events" id="active">Home</a></li>
                <li><a href="/events/all">View all events</a></li>
                <li><a href="/events/create">Create an event</a></li>
                @if(Auth::check())
                    <li><a href="/edit_profile">Edit profile</a></li>
                    <li><a href='/logout'>Log out {{ Auth::user()->username; }}</a></li>
                @else 
                    <li><a href='/signup'>Sign up</a></li>
                    <li><a href='/login'>Log in</a></li>
                @endif
            </ul>
        </nav>
        <h3 class="project-name">Dorisdays</h3>
        <small>Let's all be on the same page.</small>
     </div>


     @if(Session::get('flash_message'))
        <div class="row">
            <div class="flash-message">{{ Session::get('flash_message') }}</div>
        </div>
     @endif

     <div class="content">
        <div class="row">
            @yield('content')
        </div>
    </div>
</div>

@yield('/body')
</body>
</html>