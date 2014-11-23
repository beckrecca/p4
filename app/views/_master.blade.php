<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>@yield('title', 'Cute Helper')</title>
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
        </ul>
     </div>
    @yield('content')
</div>
</body>
</html>