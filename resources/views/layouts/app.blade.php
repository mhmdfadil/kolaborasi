<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Sistem Pengecekan Plagiasi')</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">
    <link href="{{ asset('css/bootstrap.css') }}" rel="stylesheet">
    <link href="{{ asset('css/style.css') }}" rel="stylesheet">
    <link href="{{ asset('css/icon.css') }}" rel="stylesheet">
    <link href="{{ asset('css/text.css') }}" rel="stylesheet">
    <link href="{{ asset('css/button.css') }}" rel="stylesheet">
    <link href="{{ asset('css/alert.css') }}" rel="stylesheet">

</head>
<body>
    <noscript>
        <style>
            #app {
                display: none;
            }
        </style>
        <div>
            <h3>Untuk kelancaran dalam menggunakan aplikasi, mohon aktifkan Javascript.</h3>
        </div>
    </noscript>
    <div id="app">
        @yield('content')
    </div>
    <script src="{{ asset('sweetalert2@11.js') }}"></script>
    <script src="{{ asset('library/jquery/jquery.validate.min.js') }}"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-oBO4StEV6yIJi1NPnwlVas8QOWgPhKfpbMZltP9+0ZVHIMQ37gVnK+y9xx3+jf0A" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-qIQIVlUv8+SDyIoQ98ljb6Hfmg/rIW9XwVUMQsYoYj8TTN3OMC5Giwynw2dvWf5r" crossorigin="anonymous"></script>

    <script src="{{ asset('library/inputmask/inputmask.js') }}"></script>
    <script src="{{ asset('sweetalert2@11.js') }}"></script>
    @if (session('success'))
    <script>
    document.addEventListener('DOMContentLoaded', function() {
        Swal.fire({
            icon: 'success',
            title: 'Berhasil!',
            text: '{{ session("success") }}',
            showConfirmButton: false,
            timer: 3000
        });
    });
    </script>
    @endif

    @if (session('error'))
    <script>
    document.addEventListener('DOMContentLoaded', function() {
        Swal.fire({
            icon: 'error',
            title: 'Gagal!',
            text: '{{ session("error") }}',
            toast: true,
            position: 'top-end',  // Anda bisa mengubah posisi jika diperlukan
            showConfirmButton: false,
            timer: 3000,
            timerProgressBar: true
        });
    });
    </script>
    @endif
    @stack('scripts')
</body>
</html>
