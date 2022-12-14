<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Finanças</title>
    <link rel="stylesheet" href="{{ asset("assets/css/_default.css") }}">
    <link rel="stylesheet" href="{{ asset("assets/css/uikit.css") }}" />

    <script src="https://code.jquery.com/jquery-3.6.1.min.js" integrity="sha256-o88AwQnZB+VDvE9tvIXrMQaPlFFSUTR+nldQm1LuPXQ=" crossorigin="anonymous"></script>
    <script src="{{ asset("assets/js/uikit.min.js") }}"></script>
    <script src="{{ asset("assets/js/uikit-icons.min.js") }}"></script>
</head>
<body>
    <div id="app-auth-wrapper">
        <div class="uk-card uk-card-default uk-card-body uk-width-1-3@m">
            @yield('main')
        </div>
    </div>
    <script src="{{ asset("assets/js/_default.js") }}"></script>
    @yield('script')
</body>
</html>