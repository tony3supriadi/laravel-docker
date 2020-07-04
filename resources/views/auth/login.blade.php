
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    
    <title>Login - SIMKeu | Sistem Informasi Managemen Keuangan</title>

    <link rel="shortcut icon" href="{{ asset('img/logo.png') }}" type="image/x-icon">
    
    <link rel="stylesheet" href="{{ asset('vendor/bootstrap/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('vendor/font-awesome/css/font-awesome.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/fontastic.css') }}">
    <link rel="stylesheet" href="{{ asset('css/style.sea.css') }}">
    <link rel="stylesheet" href="{{ asset('css/custom.css') }}">
    
    <link rel="stylesheet" href="{{ asset('fonts/google-fonts.css') }}">
</head>
<body>
    <div class="container-fluid px-3">
        <div class="row min-vh-100">
            <div class="col-md-5 col-lg-6 col-xl-4 px-lg-5 d-flex align-items-center">
                <div class="w-100 py-4">
                    <div class="text-center mx-auto mb-3 border rounded-circle" style="width:120px;height:120px;padding:20px">
                        <img src="{{ asset('img/logo.png') }}" alt="logo" style="max-width: 5rem;" class="img-fluid">
                    </div>
                    <p class="text-center mb-5 font-weight-bold">SIMKEU-APP<br /></p>

                    <form method="POST" action="{{ route('login') }}">
                        @csrf

                        <div class="form-group">
                            <label>Username atau E-Mail </label>
                            <input name="username" type="text" value="{{ old('username') }}" autocomplete="off" class="form-control @error('username') is-invalid @enderror">

                            @error('username')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                        <div class="form-group mb-4">
                            <label>Kata Sandi</label>
                            <input name="password" type="password" class="form-control @error('password') is-invalid @enderror">

                            @error('password')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>

                        <button class="btn btn-block btn-primary mb-3">
                            <span class="fa fa-sign-in mr-2"></span>Login
                        </button>
                    </form>
                    <div class="pt-5 text-center text-muted">
                        <small>
                            Copyright &copy; {{ date('Y') }}. All right recerved.
                        </small>
                    </div>
                </div>
            </div>

            <div class="col-12 col-md-7 col-lg-6 col-xl-8 d-none d-lg-block">
                <div style="background-image: url(img/photos/victor-ene-1301123-unsplash.jpg);" class="bg-cover h-100 mr-n3"></div>
            </div>
        </div>
    </div>
    
    <!-- JavaScript files-->
    <script src="{{ asset('vendor/jquery/jquery.min.js') }}"></script>
    <script src="{{ asset('vendor/popper.js/umd/popper.min.js') }}"></script>
    <script src="{{ asset('vendor/bootstrap/js/bootstrap.min.js') }}"></script>
    <script src="{{ asset('vendor/jquery.cookie/jquery.cookie.js') }}"> </script>
    <script src="{{ asset('vendor/chart.js/Chart.min.js') }}"></script>
    <script src="{{ asset('vendor/jquery-validation/jquery.validate.min.js') }}"></script>
    <!-- Main File-->
    <script src="{{ asset('js/front.js') }}"></script>
  </body>
</html>