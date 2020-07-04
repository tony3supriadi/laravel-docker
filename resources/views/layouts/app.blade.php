
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="robots" content="all,follow">

    <title>{{ $title }} - SIMKEU (Sistem Management Keuangan)</title>
    
    <link rel="stylesheet" href="{{ asset('vendor/bootstrap/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('vendor/font-awesome/css/font-awesome.min.css') }}">
    <link rel="stylesheet" href="{{ asset('vendor/font-awesome/css/font-awesome.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/fontastic.css') }}">
    <link rel="stylesheet" href="{{ asset('css/style.sea.css') }}" id="theme-stylesheet">
    <link rel="stylesheet" href="{{ asset('css/custom.css') }}">
    <link rel="shortcut icon" href="{{ asset('img/favicon.ico') }}">

    <link rel="stylesheet" href="{{ asset('css/poppins-family.font.css') }}">

    @yield('style')
</head>
<body>
    <div class="page">
        <!-- Main Navbar-->
        @include('layouts.partials.navbar')

        <div class="page-content d-flex align-items-stretch" style="margin-top:70px"> 
            <!-- Side Navbar -->
            @include('layouts.partials.sidebar')
          
            <div class="content-inner">
              <!-- Page Header-->
              @yield('header')

              <!-- Content -->
              <div class="content">
                <div class="slimscroll-content">
                  @yield('content')
                </div>
              </div>
            </div>
        </div>
    </div>
    
    <script src="{{ asset('vendor/jquery/jquery.min.js') }}"></script>
    <script src="{{ asset('vendor/daterangepicker/moment.min.js') }}"></script>
    <script src="{{ asset('vendor/popper.js/umd/popper.min.js') }}"> </script>
    <script src="{{ asset('vendor/bootstrap/js/bootstrap.min.js') }}"></script>
    <script src="{{ asset('vendor/jquery.cookie/jquery.cookie.js') }}"> </script>
    <script src="{{ asset('vendor/slimscroll/jquery.slimscroll.min.js') }}"> </script>
    <script src="{{ asset('js/front.js') }}"></script>
    <script src="{{ asset('js/init/app.js') }}"></script>

    @yield('script')
  </body>
</html>