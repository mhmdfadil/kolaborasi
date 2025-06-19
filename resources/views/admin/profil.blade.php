@extends('layouts.layout-app')

@section('title', 'Beranda')

@section('content')
    <div class="container mt-4">
        <div class="card shadow-sm">
            <div class="card-header bg-success text-white d-flex justify-content-between align-items-center">
                <h4 class="mb-0">Identitas Profil</h4>
                <!-- Tombol untuk membuka modal -->
                <button class="btn btn-light btn-sm" data-bs-toggle="modal" data-bs-target="#editModal">
                    <i class="bi bi-pencil-square"></i> Ubah Data
                </button>
            </div>
            <div class="card-body">
                <div class="row mb-3">
                    <div class="col-md-3">
                        @php
                            $imagePath = 'img/profile/' . $user->profile_picture;
                            $defaultImage = 'https://dummyimage.com/150x150/edf2f7/1e3a8a.png&text=Foto+Tidak+Tersedia&font-size=24&font-family=Montserrat&font-weight=bold&rounded=true';
                        @endphp
                        <img src="{{ $user->profile_picture && file_exists(public_path($imagePath)) ? asset($imagePath) : $defaultImage }}" alt="Foto Profil" class="img-fluid rounded-circle shadow-sm" style="max-width: 150px;">
                    </div>
                    <div class="col-md-9">
                        <p><strong>Nama:</strong> {{ $user->nama }}</p>
                        <p><strong>Email:</strong> {{ $user->email }}</p>
                        <p><strong>Role:</strong>
                            <span class="badge 
                                @if($user->role === 'Admin') 
                                    bg-warning 
                                @elseif($user->role === 'Mitra') 
                                    bg-success 
                                @else
                                    bg-secondary
                                @endif">
                                {{ $user->role }}
                            </span>
                        </p>
                        
                        <p><strong>Status:</strong>
                            <span class="badge 
                                @if($user->status === 'Active') 
                                    bg-success 
                                @elseif($user->status === 'Inactive') 
                                    bg-danger 
                                @else
                                    bg-secondary
                                @endif">
                                {{ $user->status }}
                            </span>
                        </p>
                        
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal untuk mengubah data -->
<div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <!-- Kop Modal (Logo dan Identitas Mitra) -->
            <div class="modal-body text-center" style="background-color: #fff8e1; padding: 20px;">
                <div class="d-flex justify-content-center align-items-center">
                    <img src="{{ asset('img/UNIMAL.png') }}" alt="Universitas Malikussaleh" width="160" height="80" class="me-2">
                    <p style="font-size: 25px; font-weight: bold; color: #006400;">
                        Teknik Informatika | Universitas Malikussaleh
                    </p>
                </div>
            </div>
            <div class="modal-header justify-content-center align-items-center text-center" style="background-color: #006400; color: white;">
                <h5 class="modal-title" id="editModalLabel">
                    <strong>Ubah Profil Pengguna</strong>
                </h5>
            </div>
            <form action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <input type="hidden" name="id" value="{{ $user->id }}"> <!-- ID Pengguna disertakan -->
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="nama" class="form-label">Nama</label>
                        <input type="text" class="form-control" id="nama" name="nama" value="{{ old('name', $user->nama) }}">
                    </div>
                    <div class="mb-3">
                        <label for="email" class="form-label">Email</label>
                        <input type="email" class="form-control" id="email" name="email" value="{{ old('email', $user->email) }}">
                    </div>
                    <div class="mb-3">
                        <label for="profile_picture" class="form-label">Profile Picture</label>
                        <input type="file" class="form-control" id="profile_picture" name="profile_picture">
                        @if ($user->profile_picture)
                            <p class="text-success mt-2">{{ $user->profile_picture }}</p>
                        @endif
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                    <button type="submit" class="btn btn-success">Simpan Perubahan</button>
                </div>
            </form>
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
