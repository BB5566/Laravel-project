<!DOCTYPE html>
<html lang="en">

<head>
    <title>@yield('title')</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</head>

<body>
    {{-- nav --}}
    <nav class="navbar navbar-expand-sm bg-danger navbar-dark">
        <div class="container-fluid">
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('pages.html') }}">HTML</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('pages.js') }}">JS</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('pages.php') }}">PHP</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('pages.python') }}">PYTHON</a>
                </li>
            </ul>
        </div>
    </nav>
    {{-- nav end --}}


    {{-- content --}}
    @yield('content')
    {{-- content  end --}}

</body>

</html>
