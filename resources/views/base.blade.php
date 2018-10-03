
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8" />
    <title>{{ config('app.name', 'PugCheck') }}</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link href="https://fonts.googleapis.com/css?family=Roboto:300,400,500" rel="stylesheet">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.3.1/css/all.css" integrity="sha384-mzrmE5qonljUremFsqc01SB46JvROS7bZs3IO2EmfFsd15uHvIt+Y8vEf7N7fWAU" crossorigin="anonymous">

    <link rel="stylesheet" href="{{ asset('css/reset.css') }}">
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <link rel="icon" type="image/x-icon" href="{{ asset('favicon.ico') }}" />
</head>
<body>
    <a href="/"><h1 class="title"><strong>Pug</strong>Check</h1></a>
    <div class="container">
        @include('partials.messages')
        @yield('content')
    </div>

    <script src="{{ asset('js/app.js') }}"></script>

    @include('partials.footer')
</body>
</html>
