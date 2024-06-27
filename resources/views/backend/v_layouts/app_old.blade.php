<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>belajartemplate</title>
</head>

<body>
    <a href="{{route('home')}}">Beranda</a>
    <a href="{{route('akun.index')}}">Akun</a>
    <a href="{{route('customer.index')}}">Customer</a>

    <!-- isi -->
    @yield('content')
    <!-- isi end -->
</body>

</html>