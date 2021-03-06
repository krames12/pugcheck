
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8" />
    <title>{{ config('app.name', 'PugCheck') }}</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link href="https://fonts.googleapis.com/css?family=Roboto:300,400,500" rel="stylesheet">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.3.1/css/all.css" integrity="sha384-mzrmE5qonljUremFsqc01SB46JvROS7bZs3IO2EmfFsd15uHvIt+Y8vEf7N7fWAU" crossorigin="anonymous">

    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <link rel="icon" type="image/x-icon" href="{{ asset('favicon.ico') }}" />
</head>
<body>
    <h1 class="title"><a href="/"><strong>Pug</strong>Check</a></h1>
    <div class="container">
        @yield('content')
    </div>

    <script src="{{ asset('js/app.js') }}"></script>
    <script>
        // Wowhead Tooltips
        var whTooltips = {colorLinks: true, iconizeLinks: true, renameLinks: true};

        document.addEventListener('click', event => {
            if(event.target.classList.contains('collapse')) {
                let toggleElement = event.target;
                let bosses = toggleElement.closest('.raid-instance').children[1];
                bosses.classList.toggle('hidden');
                event.target.classList.toggle('fa-plus');
                event.target.classList.toggle('fa-minus');
            }
        });

        document.getElementById('region-name').addEventListener('change', event => {
            let realmOptions = document.getElementsByClassName('realm-option');
            for(let option of realmOptions) {
                option.classList.toggle('hidden');
            }
        });
    </script>
    <script src="http://wow.zamimg.com/widgets/power.js"></script>

    @include('partials.footer')
</body>
</html>
