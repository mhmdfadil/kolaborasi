@extends('layouts.layout-app')

@section('title', 'Beranda')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12 text-center my-4">
            <h1 class="display-4">Selamat Datang, {{ Auth::user()->nama }}</h1>
            <p class="lead">Selamat datang di <strong>Sistem Kolaborasi Mitra</strong>, platform untuk mengelola berbagai aspek kerjasama mitra dengan efisiensi dan kemudahan.</p>
        </div>
    </div>

    <div class="row g-4">
        <!-- Total Manajemen Akun -->
        <div class="col-md-4">
            <div class="card shadow border-success h-100">
                <div class="card-body text-center">
                    <h5 class="card-title">Total Manajemen Akun</h5>
                    <p class="card-text display-4 text-success fw-bold">{{ $totalAkun }}</p>
                </div>
            </div>
        </div>

        <!-- Total Manajemen -->
        <div class="col-md-4">
            <div class="card shadow border-primary h-100">
                <div class="card-body text-center">
                    <h5 class="card-title">Total Manajemen</h5>
                    <p class="card-text display-4 text-primary fw-bold">{{ $totalManajemen }}</p>
                </div>
            </div>
        </div>

        <!-- Total Pengajuan Kerjasama -->
        <div class="col-md-4">
            <div class="card shadow border-info h-100">
                <div class="card-body text-center">
                    <h5 class="card-title">Total Pengajuan Kerjasama</h5>
                    <p class="card-text display-4 text-info fw-bold">{{ $totalPengajuan }}</p>
                </div>
            </div>
        </div>
    </div>

    <div class="row g-4 mt-4">
        <!-- Total Dokumentasi -->
        <div class="col-md-4">
            <div class="card shadow border-warning h-100">
                <div class="card-body text-center">
                    <h5 class="card-title">Total Dokumentasi</h5>
                    <p class="card-text display-4 text-warning fw-bold">{{ $totalDokumentasi }}</p>
                </div>
            </div>
        </div>

        <!-- Total Manajemen Acara -->
        <div class="col-md-4">
            <div class="card shadow border-danger h-100">
                <div class="card-body text-center">
                    <h5 class="card-title">Total Manajemen Event</h5>
                    <p class="card-text display-4 text-danger fw-bold">{{ $totalAcara }}</p>
                </div>
            </div>
        </div>

        <!-- Total Manajemen Dokumentasi Acara -->
        <div class="col-md-4">
            <div class="card shadow border-dark h-100">
                <div class="card-body text-center">
                    <h5 class="card-title">Total Manajemen Dokumentasi Event</h5>
                    <p class="card-text display-4 text-dark fw-bold">{{ $totalDokumentasiAcara }}</p>
                </div>
            </div>
        </div>
    </div>
</div>

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
