<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <meta name="description" content="Simple todo task app.">
    <meta name="csrf-token" content="{{ csrf_token() }}">


    <!-- theme meta -->
    <meta name="ToDoApp" content="ToDo App" />

    <title>@yield('title')</title>

    <!-- GOOGLE FONTS -->
    <link href="https://fonts.googleapis.com/css?family=Montserrat:400,500|Poppins:400,500,600,700|Roboto:400,500" rel="stylesheet" />

    <link href="https://cdn.materialdesignicons.com/4.4.95/css/materialdesignicons.min.css" rel="stylesheet" />

    <!-- PLUGINS CSS STYLE -->



    <!-- No Extra plugin used -->
    @vite(['resources/css/sleek.css','resources/plugins/jquery/jquery.min.js',
    'resources/plugins/bootstrap/js/bootstrap.bundle.min.js',
    'resources/js/sleek.js'])

  </head>

  <body class="header-fixed sidebar-fixed sidebar-dark header-light" id="body">
@yield('model')
{{--     <script>
    NProgress.configure({ showSpinner: false});
    NProgress.start();
    window.onload = function() {
    NProgress.done();
    };
    </script> --}}

    <div style="position: absolute; top:20px; right: 20px; z-index:9999;">
        @if(session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        @if(session('error'))
            <div class="alert alert-danger">
                {{ session('error') }}
            </div>
        @endif

        @if ($errors->any())
            <div class="alert alert-danger" role="alert">
                @foreach ($errors->all() as $error)
                    {{$error}}<br>
                @endforeach
            </div>
        @endif
    </div>
        <div class="page-wrapper">
            @include('layouts.header')
            @yield('content')
        </div>
        @include('layouts.footer')
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    @yield('script')
</body>
</html>

