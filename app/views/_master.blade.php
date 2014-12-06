<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>@yield('title', 'Dorisdays')</title>
    <!-- makes the layout responsive -->
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Bootstrap -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap.min.css">
    <!-- jQuery -->
    <link rel="stylesheet" href="//code.jquery.com/ui/1.11.2/themes/smoothness/jquery-ui.css">
    <script src="//code.jquery.com/jquery-1.10.2.js"></script>
    <script src="//code.jquery.com/ui/1.11.2/jquery-ui.js"></script>
</head>

<body>
<div class="container">
    <header class="row">
    	<h1>Dorisdays</h1>
     </header>

     <div class="navigation">
        <ul>
            <li><a href="/events">View events</a></li>
            <li><a href="/events/create">Create an event</a></li>
            <li>
                @if(Auth::check())
                <a href='/logout'>Log out {{ Auth::user()->username; }}</a>
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