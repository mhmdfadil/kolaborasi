@extends('layouts.layout-app')

@section('title', 'Manajemen Mitra')

@section('content')
<div class="container py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h3>Manajemen Mitra</h3>
        <button class="btn btn-success" id="btn-tambah" data-bs-toggle="modal" data-bs-target="#addMitraModal">Tambah</button>
    </div>

    <!-- Modal untuk menambahkan mitra -->
    <div class="modal fade" id="addMitraModal" tabindex="-1" aria-labelledby="addMitraModalLabel" aria-hidden="true">
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
                                <div class="d-flex align-items-center text-center justify-content-center align-items-center">
                                    <h5 class="modal-title text-center" id="addMitraModalLabel">
                                        <strong> Tambah Identitas Mitra / Perusahaan</strong>
                                    </h5>
                                </div>
                            </div>
                <form action="{{ route('store-mitra') }}" method="POST">
                    @csrf
                    <div class="modal-body">
                        <!-- Form input untuk nama -->
                        <div class="mb-3">
                            <label for="name" class="form-label">Nama</label>
                            <input type="text" class="form-control" id="name" name="name" required>
                        </div>

                        <!-- Form input untuk email -->
                        <div class="mb-3">
                            <label for="email" class="form-label">Email</label>
                            <input type="email" class="form-control" id="email" name="email" required>
                        </div>

                        <!-- Form input untuk address -->
                        <div class="mb-3">
                            <label for="address" class="form-label">Alamat</label>
                            <textarea class="form-control" id="address" name="address" rows="3" required></textarea>
                        </div>

                        <!-- Form input untuk description -->
                        <div class="mb-3">
                            <label for="description" class="form-label">Deskripsi</label>
                            <textarea class="form-control" id="description" name="description" rows="3"></textarea>
                        </div>

                        <!-- Form input untuk phone_number -->
                        <div class="mb-3">
                            <label for="phone_number" class="form-label">Nomor Telepon</label>
                            <input type="text" class="form-control" id="phone_number" name="phone_number" required>
                        </div>

                        <!-- Form input untuk website -->
                        <div class="mb-3">
                            <label for="website" class="form-label">Website</label>
                            <input type="url" class="form-control" id="website" name="website">
                        </div>

                        <!-- Form input untuk type -->
                        <div class="mb-3">
                            <label for="type" class="form-label">Tipe Mitra</label>
                            <select class="form-select" id="type" name="type" required>
                                <option value="Company">Company</option>
                                <option value="NGO">NGO</option>
                                <option value="University">University</option>
                                <option value="Other">Other</option>
                            </select>
                        </div>
                        

                        <!-- Form input untuk user_id -->
                        <div class="mb-3">
                            <label for="user_id" class="form-label">Pengguna</label>
                            <select class="form-select" id="user_id" name="user_id" required>
                                <option value="" disabled selected>Pilih Pengguna</option>
                                @foreach($ausers as $userk)
                                    <option value="{{ $userk->id }}">{{ $userk->nama }}</option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Form input untuk is_verified -->
                        <div class="mb-3">
                            <label for="is_verified" class="form-label">Verifikasi</label>
                            <select class="form-select" id="is_verified" name="is_verified" required>
                                <option value="1">Terverifikasi</option>
                                <option value="0">Belum Terverifikasi</option>
                            </select>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-primary">Tambah Mitra</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    @foreach ($amitra as $mitra)
    <!-- Modal Detail Mitra -->
    <div class="modal fade" id="detailMitraModal{{ $mitra->id }}" tabindex="-1" aria-labelledby="detailMitraModalLabel{{ $mitra->id }}" aria-hidden="true">
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
                    <div class="d-flex align-items-center text-center justify-content-center align-items-center">
                        <h5 class="modal-title text-center" id="detailMitraModalLabel{{ $mitra->id }}">
                            <strong>Identitas Mitra / Perusahaan</strong>
                        </h5>
                    </div>
                    
                </div>
                <div class="modal-body" style="background-color: #fff8e1;">
                    <!-- Nama Mitra -->
                    <div class="mb-3">
                        <strong>Nama:</strong> {{ $mitra->name ?? 'Tidak Ada' }}
                    </div>

                    <!-- Email Mitra -->
                    <div class="mb-3">
                        <strong>Email:</strong> {{ $mitra->email ?? 'Tidak Ada' }}
                    </div>

                    <!-- Alamat Mitra -->
                    <div class="mb-3">
                        <strong>Alamat:</strong> {{ $mitra->address ?? 'Tidak Ada' }}
                    </div>

                    <!-- Deskripsi Mitra -->
                    <div class="mb-3">
                        <strong>Deskripsi:</strong> {{ $mitra->description ?? 'Tidak Ada' }}
                    </div>

                    <!-- Nomor Telepon Mitra -->
                    <div class="mb-3">
                        <strong>Nomor Telepon:</strong> {{ $mitra->phone_number ?? 'Tidak Ada' }}
                    </div>

                    <!-- Website Mitra -->
                    <div class="mb-3">
                        <strong>Website:</strong> <a href="{{ $mitra->website ?? '#' }}" target="_blank">{{ $mitra->website ?? 'Tidak Ada' }}</a>
                    </div>

                    <!-- Tipe Mitra dengan Badge -->
                    <div class="mb-3">
                        <strong>Tipe Mitra:</strong>
                        @if($mitra->type === 'Company')
                            <span class="badge bg-warning text-dark">Perusahaan</span>
                        @elseif($mitra->type === 'NGO')
                            <span class="badge bg-info text-dark">Organisasi</span>
                        @elseif($mitra->type === 'University')
                            <span class="badge bg-success text-light">Universitas</span>
                        @else
                            <span class="badge bg-secondary text-light">Lainnya</span>
                        @endif
                    </div>

                    <!-- Pengguna Mitra -->
                    <div class="mb-3">
                        <strong>Pengguna:</strong> {{ $mitra->user->nama ?? 'Tidak Ada' }}
                    </div>

                    <!-- Verifikasi dengan Badge -->
                    <div class="mb-3">
                        <strong>Verifikasi:</strong>
                        <span class="badge {{ $mitra->is_verified ? 'bg-success' : 'bg-danger' }}">
                            {{ $mitra->is_verified ? 'Terverifikasi' : 'Belum Terverifikasi' }}
                        </span>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                </div>
            </div>
        </div>
    </div>
@endforeach

@foreach ($amitra as $mitra)
<!-- Modal untuk mengedit mitra -->
<div class="modal fade" id="editMitraModal{{ $mitra->id }}" tabindex="-1" aria-labelledby="editMitraModalLabel" aria-hidden="true">
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
                    <div class="d-flex align-items-center text-center justify-content-center align-items-center">
                        <h5 class="modal-title text-center" id="editMitraModalLabel{{ $mitra->id }}">
                            <strong>Ubah Identitas Mitra / Perusahaan</strong>
                        </h5>
                    </div>
                </div>
            <form action="{{ route('update-mitra', $mitra->id) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="modal-body">
                    <!-- Form input untuk nama -->
                    <div class="mb-3">
                        <label for="name" class="form-label">Nama</label>
                        <input type="text" class="form-control" id="name" name="name" value="{{ old('name', $mitra->name) }}" required>
                    </div>

                    <!-- Form input untuk email -->
                    <div class="mb-3">
                        <label for="email" class="form-label">Email</label>
                        <input type="email" class="form-control" id="email" name="email" value="{{ old('email', $mitra->email) }}" required>
                    </div>

                    <!-- Form input untuk address -->
                    <div class="mb-3">
                        <label for="address" class="form-label">Alamat</label>
                        <textarea class="form-control" id="address" name="address" rows="3" required>{{ old('address', $mitra->address) }}</textarea>
                    </div>

                    <!-- Form input untuk description -->
                    <div class="mb-3">
                        <label for="description" class="form-label">Deskripsi</label>
                        <textarea class="form-control" id="description" name="description" rows="3">{{ old('description', $mitra->description) }}</textarea>
                    </div>

                    <!-- Form input untuk phone_number -->
                    <div class="mb-3">
                        <label for="phone_number" class="form-label">Nomor Telepon</label>
                        <input type="text" class="form-control" id="phone_number" name="phone_number" value="{{ old('phone_number', $mitra->phone_number) }}" required>
                    </div>

                    <!-- Form input untuk website -->
                    <div class="mb-3">
                        <label for="website" class="form-label">Website</label>
                        <input type="url" class="form-control" id="website" name="website" value="{{ old('website', $mitra->website) }}">
                    </div>

                    <!-- Form input untuk type -->
                    <div class="mb-3">
                        <label for="type" class="form-label">Tipe Mitra</label>
                        <select class="form-select" id="type" name="type" required>
                            <option value="Company" {{ $mitra->type == 'Company' ? 'selected' : '' }}>Company</option>
                            <option value="NGO" {{ $mitra->type == 'NGO' ? 'selected' : '' }}>NGO</option>
                            <option value="University" {{ $mitra->type == 'University' ? 'selected' : '' }}>University</option>
                            <option value="Other" {{ $mitra->type == 'Other' ? 'selected' : '' }}>Other</option>
                        </select>
                    </div>

                    <!-- Form input untuk user_id -->
                    <div class="mb-3">
                        <label for="user_id" class="form-label">Pengguna</label>
                        <select class="form-select" id="user_id" name="user_id" required>
                            <option value="" disabled>Pilih Pengguna</option>
                            @foreach($ausers as $userk)
                                <option value="{{ $userk->id }}" {{ $userk->id == $mitra->user_id ? 'selected' : '' }}>{{ $userk->nama }}</option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Form input untuk is_verified -->
                    <div class="mb-3">
                        <label for="is_verified" class="form-label">Verifikasi</label>
                        <select class="form-select" id="is_verified" name="is_verified" required>
                            <option value="1" {{ $mitra->is_verified == 1 ? 'selected' : '' }}>Terverifikasi</option>
                            <option value="0" {{ $mitra->is_verified == 0 ? 'selected' : '' }}>Belum Terverifikasi</option>
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endforeach




    <table class="table table-bordered table-hover" id="abc">
        @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
        <thead class="table-light">
            <tr class="text-center">
                <th class="text-center" width="30px">No</th>
                <th class="text-center" width="100px">Nama</th>
                <th class="text-center" width="150px">Email</th>
                <th class="text-center" width="150px">No. Telpon</th>
                <th class="text-center" width="150px">Alamat</th>
                <th class="text-center">Website</th>
                <th class="text-center">Bidang Perusahaan</th>
                <th class="text-center" width="100px">Tipe</th>
                <th class="text-center" width="100px">Status</th>
                <th class="text-center" width="200px">Aksi</th>
            </tr>
        </thead>
        <tbody>
            @foreach($amitra as $key => $mitra)
                <tr>
                    <td class="text-center" width="30px">{{ $key + 1 }}</td>
                    <td width="150px">{{ $mitra->name }}</td>
                    <td width="100px">{{ $mitra->email }}</td>
                    <td width="100px">{{ $mitra->phone_number }}</td>
                    
                    <td width="100px">{{ $mitra->address }}</td>
                    <td >
                        @if($mitra->website)
                            <a href="{{ $mitra->website }}" style="text-decoration: none" target="_blank" rel="noopener noreferrer">{{ $mitra->website }}</a>
                        @else
                            <span class="text-muted">Tidak ada</span>
                        @endif
                    </td>
                    <td>{{ $mitra->user->bidang }}</td>
                    <td class="text-center" width="100px">
                        @if($mitra->type === 'Company')
                            <span class="badge bg-primary text-light">Perusahaan</span>
                        @elseif($mitra->type === 'NGO')
                            <span class="badge bg-info text-dark">Organisasi</span>
                        @elseif($mitra->type === 'University')
                            <span class="badge bg-success text-light">Universitas</span>
                        @else
                            <span class="badge bg-secondary text-light">Lainnya</span>
                        @endif
                    </td>
                    <td class="text-center" width="100px">
                        @if($mitra->is_verified === true)
                            <span class="badge bg-success text-light">Terverifikasi</span>
                        @else
                            <span class="badge bg-danger text-light">Belum Terverifikasi</span>
                        @endif
                    </td>
                    <td class="text-center items-sm" width="400px">
                        <button class="btn btn-secondary btn-sm text-light" data-bs-toggle="modal" data-bs-target="#detailMitraModal{{ $mitra->id }}">
                            <i class="bi bi-eye"></i>
                        </button>
                        <button class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#editMitraModal{{ $mitra->id }}">
                            <i class="bi bi-pencil"></i>
                        </button>
                        @if ($mitra->is_verified == 0)
                            <form action="{{ route('update-verifikasi', $mitra->id) }}" method="POST" style="display:inline;" id="verifikasi-form-{{ $mitra->id }}">
                                @csrf
                                @method('PUT')
                                <button class="btn btn-warning btn-sm" type="button" onclick="confirmUpdateStatus({{ $mitra->id }})">
                                    <i class="bi bi-check-circle"></i> 
                                </button>
                            </form>
                        @endif
                    
                        <form action="{{ route('delete-mitra', $mitra->id) }}" method="POST" style="display:inline;" id="delete-form-{{ $mitra->id }}">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-danger btn-sm" type="button" onclick="confirmDelete({{ $mitra->id }})">
                                <i class="bi bi-trash"></i>
                            </button>
                        </form>
                    </td>
                    
                </tr>
            @endforeach
        </tbody>
    </table>
</div>

<script>
    $(document).ready(function() {
        $('#abc').DataTable({
            "language": {
                "url": "https://cdn.datatables.net/plug-ins/1.13.1/i18n/id.json"
            }
        });
    });

    function confirmDelete(mitraId) {
        Swal.fire({
            title: 'Apakah Anda yakin?',
            text: 'Data ini akan dihapus permanen!',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Hapus',
            cancelButtonText: 'Batal',
            reverseButtons: true
        }).then((result) => {
            if (result.isConfirmed) {
                document.getElementById('delete-form-' + mitraId).submit();
            }
        });
    }

    function confirmUpdateStatus(mitraId) {
        Swal.fire({
            title: 'Apakah Anda yakin?',
            text: 'Data ini akan diubah status menjadi terverifikasi!',
            icon: 'info',
            showCancelButton: true,
            confirmButtonText: 'Verifikasi',
            cancelButtonText: 'Batal',
            reverseButtons: true
        }).then((result) => {
            if (result.isConfirmed) {
                document.getElementById('verifikasi-form-' + mitraId).submit();
            }
        });
    }
</script>

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
        timerProgressBar: true
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
        timerProgressBar: true
    });
});
</script>
@endif

@endsection
