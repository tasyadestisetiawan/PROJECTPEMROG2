<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" href="favicon.ico">
    <title>TOKO EMAS HIDUP BSI</title>
    <!-- Simple bar CSS -->
    <link rel="stylesheet" href="{{ asset('backend/css/simplebar.css') }}">
    <!-- Fonts CSS -->
    <link href="https://fonts.googleapis.com/css2?family=Overpass:ital,wght@0,100;0,200;0,300;0,400;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">
    <!-- Icons CSS -->
    <link rel="stylesheet" href="{{ asset('backend/css/feather.css') }}">
    <!-- Date Range Picker CSS -->
    <link rel="stylesheet" href="{{ asset('backend/css/daterangepicker.css') }}">
    <!-- App CSS -->
    <link rel="stylesheet" href="{{ asset('backend/css/app-light.css') }}" id="lightTheme" disabled>
    <link rel="stylesheet" href="{{ asset('backend/css/app-dark.css') }}" id="darkTheme">
</head>

<body class="dark ">
    <div class="wrapper vh-100">
        <div class="row align-items-center h-100">
            <div class="col-lg-3 col-md-4 col-10 mx-auto text-center">
                @if(session()->has('msgError'))
                <div class="alert alert-danger alert-dismissible" role="alert">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <strong>{{ session('msgError')}} </strong>
                </div>
                @endif
                <form id="loginform" action="/login" method="post">
                    @csrf
                    <a class="navbar-brand mx-auto mt-2 flex-fill text-center" href="./index.html">
                        <svg version="1.1" id="logo" class="navbar-brand-img brand-md" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 120 120" xml:space="preserve">
                            <g>
                                <polygon class="st0" points="78,105 15,105 24,87 87,87 	" />
                                <polygon class="st0" points="96,69 33,69 42,51 105,51 	" />
                                <polygon class="st0" points="78,33 15,33 24,15 87,15 	" />
                            </g>
                        </svg>
                    </a>
                    <h1 class="h6 mb-3">PENJUALAN TOKO EMAS HIDUP BSI</h1>
                    <div class="form-group">
                        <label for="inputEmail" class="sr-only">Email address</label>
                        <input type="text" name="email" class="form-control form-control-lg @error('email') is-invalid @enderror" placeholder="Username" required="" autofocus="">@error('email')
                        <span class="invalid-feedback alert-danger" role="alert">
                            {{ $message }}
                        </span>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="inputPassword" class="sr-only">Password</label>
                        <input type="password" name="password" class="form-control form-control-lg @error('password') is-invalid @enderror" placeholder="Password" required=""><i class="ti-lock"></i>
                        @error('password')
                        <span class="invalid-feedback alert-danger" role="alert">
                            {{ $message }}
                        </span>
                        @enderror
                    </div>
                    <div class="checkbox mb-3">
                        <label>
                            <input type="checkbox" value="remember-me"> Stay logged in </label>
                    </div>
                    <button class="btn btn-lg btn-primary btn-block" type="submit">Login</button>
                    <p class="mt-5 mb-3 text-muted">© 2024</p>
                </form>
            </div>
        </div>
    </div>
    <script src="{{ asset('backend/js/jquery.min.js') }}"></script>
    <script src="{{ asset('backend/js/popper.min.js') }}"></script>
    <script src="{{ asset('backend/js/moment.min.js') }}"></script>
    <script src="{{ asset('backend/js/bootstrap.min.js') }}"></script>
    <script src="{{ asset('backend/js/simplebar.min.js') }}"></script>
    <script src="{{ asset('backend/js/daterangepicker.js') }}"></script>
    <script src="{{ asset('backend/js/jquery.stickOnScroll.js') }}"></script>
    <script src="{{ asset('backend/js/tinycolor-min.js') }}"></script>
    <script src="{{ asset('backend/js/config.js') }}"></script>
    <script src="{{ asset('backend/js/apps.js') }}"></script>
    <!-- Global site tag (gtag.js) - Google Analytics -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=UA-56159088-1"></script>
    <script>
        window.dataLayer = window.dataLayer || [];

        function gtag() {
            dataLayer.push(arguments);
        }
        gtag('js', new Date());
        gtag('config', 'UA-56159088-1');
    </script>
</body>

</html>