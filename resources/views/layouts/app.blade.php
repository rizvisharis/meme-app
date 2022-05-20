<html>
    <head>
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>MEME App</title>
        <link rel="stylesheet" href="{{asset('css/app.css')}}">
    </head>
    <body>
        @include('include.nav')
        <div class="container">
            @yield('content')
        </div>
    </body>
</html>
