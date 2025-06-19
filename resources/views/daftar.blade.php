@extends('layouts.app')

@section('title', 'Daftar Akun | Kolaborasi Mitra')

@section('content')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/css/bootstrap.min.css">
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.5/jquery.validate.min.js"></script>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-oBO4StEV6yIJi1NPnwlVas8QOWgPhKfpbMZltP9+0ZVHIMQ37gVnK+y9xx3+jf0A" crossorigin="anonymous">
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-qIQIVlUv8+SDyIoQ98ljb6Hfmg/rIW9XwVUMQsYoYj8TTN3OMC5Giwynw2dvWf5r" crossorigin="anonymous"></script>

<noscript>
    <style>
        .is-invalid + .invalid-feedback {
            display: block;
        }
        #app {
            display: none;
        }
    </style>
    <div>
        <h3>Untuk kelancaran dalam menggunakan aplikasi, mohon aktifkan Javascript.</h3>
    </div>
</noscript>

<div id="app" class="misc-wrapper">
    <div class="misc-content">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-12 text-center mb-4">
                    <a href="{{ route('login') }}"> 
                        <img alt="Logo" src="{{ asset('img/UNIMAL.png') }}" class="margin-r-9" width="270px" height="150px"> 
                    </a>
                    <h3 class="font-weight-bold text-primary">Kolaborasi Mitra</h3>
                    <h4 class="text-muted">Teknik Informatika | Universitas Malikussaleh</h4>
                </div>
               

                <div class="col-md-8 col-xs-12">
                    <div class="misc-box shadow-lg p-4 rounded-lg bg-white">
                        <form id="register-form" method="POST" action="{{ route('daftar') }}" enctype="multipart/form-data" novalidate>
                            @csrf
                            <h4 class="font-weight-bold mb-3 text-center text-dark">Daftar Akun Baru</h4>
                            @if ($errors->any())
                                <div class="alert alert-blue-outline">
                                    <ul>
                                        @foreach ($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif
                            <div class="form-group mb-3">
                                <label for="nama" class="form-label">Nama Lengkap</label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="fas fa-user"></i></span>
                                    </div>
                                    <input id="nama" name="nama" type="text" value="{{ old('nama') }}" placeholder="Masukkan nama lengkap" class="form-control @error('nama') is-invalid @enderror" required>
                                    @error('nama')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group mb-3">
                                <label for="email" class="form-label">Email</label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="fas fa-envelope"></i></span>
                                    </div>
                                    <input id="email" name="email" type="email" value="{{ old('email') }}" placeholder="Masukkan email" class="form-control @error('email') is-invalid @enderror" required>
                                    @error('email')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group mb-3">
                                <label for="password" class="form-label">Password</label>
                                <div class="input-group" id="show_hide_password">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="fas fa-key"></i></span>
                                    </div>
                                    <input id="password" name="password" type="password" placeholder="Masukkan password" class="form-control @error('password') is-invalid @enderror" required>
                                    @error('password')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group mb-3">
                                <label for="profile_picture" class="form-label">Foto Profil</label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="fas fa-image"></i></span>
                                    </div>
                                    <input id="profile_picture" name="profile_picture" type="file" class="form-control @error('profile_picture') is-invalid @enderror">
                                    @error('profile_picture')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group mb-3">
                                <label for="alamat" class="form-label">Alamat</label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="fas fa-map-marker-alt"></i></span>
                                    </div>
                                    <textarea id="alamat" name="alamat" placeholder="Masukkan alamat lengkap" class="form-control @error('alamat') is-invalid @enderror" required>{{ old('alamat') }}</textarea>
                                    @error('alamat')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            
                            <div class="form-group mb-3">
                                <label for="telepon" class="form-label">Nomor Telepon</label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="fas fa-phone"></i></span>
                                    </div>
                                    <input id="telepon" name="telepon" type="tel" value="{{ old('telepon') }}" placeholder="Masukkan nomor telepon" class="form-control @error('telepon') is-invalid @enderror" required>
                                    @error('telepon')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            
                            <div class="form-group mb-3">
                                <label for="bidang" class="form-label">Bidang Perusahaan</label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="fas fa-briefcase"></i></span>
                                    </div>
                                    <input id="bidang" name="bidang" type="text" value="{{ old('bidang') }}" placeholder="Masukkan bidang perusahaan" class="form-control @error('bidang') is-invalid @enderror" required>
                                    @error('bidang')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>                            
                            

                            <div class="d-grid gap-2 mb-2">
                                <button type="submit" id="submit-button" class="btn btn-primary btn-lg">
                                    <i class="fas fa-user-plus"></i> Daftar
                                </button>
                            </div>

                            <div class="border border-primary rounded mt-2 p-2 text-center">
                                Sudah punya akun? <a href="{{ route('login') }}" class="text-decoration-none">Masuk Sekarang</a>
                            </div>

                            <hr class="my-1">

                            <div class="text-center mt-2">
                                <p class="text-sm text-dark">
                                    Jika mengalami kendala, silakan hubungi 
                                    <strong style="font-weight: 700 !important;">Admin IT</strong>
                                </p>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            @section('scripts')
            <script src="{{ asset('sweetalert2@11.js') }}"></script>
            @if (session('success'))
            <script>
            document.addEventListener('DOMContentLoaded', function() {
                Swal.fire({
                    toast: true,
                    icon: 'success',
                    title: '{{ session("success") }}',
                    position: 'top-end',
                    showConfirmButton: false,
                    timer: 3000,
                    timerProgressBar: true,
                    didOpen: (toast) => {
                        toast.addEventListener('mouseenter', Swal.stopTimer);
                        toast.addEventListener('mouseleave', Swal.resumeTimer);
                    }
                });
            });
            </script>
            @endif
            
            @if (session('error'))
            <script>
            document.addEventListener('DOMContentLoaded', function() {
                Swal.fire({
                    toast: true,
                    icon: 'error',
                    title: '{{ session("error") }}',
                    position: 'top-end',
                    showConfirmButton: false,
                    timer: 3000,
                    timerProgressBar: true,
                    didOpen: (toast) => {
                        toast.addEventListener('mouseenter', Swal.stopTimer);
                        toast.addEventListener('mouseleave', Swal.resumeTimer);
                    }
                });
            });
            </script>
            @endif
            @endsection
            
            


            <div class="row justify-content-center misc-footer">
                <div class="col-md-6 col-sm-12 text-center">
                    <p class="small text-muted">
                        &copy; 2024 Kolaborasi Mitra | Teknik Informatika, Universitas Malikussaleh
                    </p>
                </div>
            </div>
        </div
        @endsection
       