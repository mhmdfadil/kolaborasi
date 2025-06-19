@extends('layouts.layout-app')

@section('title', 'Manajemen Akun')

@section('content')
<div class="container py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h3>Manajemen Akun</h3>
        <button class="btn btn-success" id="btn-tambah" data-bs-toggle="modal" data-bs-target="#addUserModal">Tambah</button>
    </div>

    <!-- Modal untuk menambahkan akun -->
    <div class="modal fade" id="addUserModal" tabindex="-1" aria-labelledby="addUserModalLabel" aria-hidden="true">
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
                                            <strong>Tambah Akun Sistem</strong>
                                        </h5>
                                    </div>
                </div>
                <form action="{{ route('store-user') }}" method="POST">
                    @csrf
                    <div class="modal-body">
                        <!-- Form input untuk nama -->
                        <div class="mb-3">
                            <label for="nama" class="form-label">Nama</label>
                            <input type="text" class="form-control" id="nama" name="nama" required>
                        </div>
                        
                        <!-- Form input untuk email -->
                        <div class="mb-3">
                            <label for="email" class="form-label">Email</label>
                            <input type="email" class="form-control" id="email" name="email" required>
                        </div>

                        <div class="mb-3">
                            <label for="password" class="form-label">Password</label>
                            <input type="text" class="form-control" id="password" name="password" required>
                        </div>

                        <div class="mb-3">
                            <label for="bidang" class="form-label">Bidang Perusahaan</label>
                            <input type="text" class="form-control" id="bidang" name="bidang" required>
                        </div>

                        <div class="mb-3">
                            <label for="telepon" class="form-label">No. Telepon</label>
                            <input type="number" class="form-control" id="telepon" name="telepon" required>
                        </div>

                        <div class="mb-3">
                            <label for="alamat" class="form-label">Alamat</label>
                            <textarea class="form-control" id="alamat" name="alamat" required> </textarea>
                        </div>

                        <!-- Form input untuk role -->
                        <div class="mb-3">
                            <label for="role" class="form-label">Role</label>
                            <select class="form-select" id="role" name="role" required>
                                <option value="Admin">Admin</option>
                                <option value="Mitra">Mitra</option>
                            </select>
                        </div>

                        <!-- Form input untuk status -->
                        <div class="mb-3">
                            <label for="status" class="form-label">Status</label>
                            <select class="form-select" id="status" name="status" required>
                                <option value="Active">Aktif</option>
                                <option value="Inactive">Tidak Aktif</option>
                            </select>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-primary">Tambah Akun</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Modal untuk mengedit akun -->
@foreach ($ausers as $userk)
<div class="modal fade" id="editUserModal{{ $userk->id }}" tabindex="-1" aria-labelledby="editUserModalLabel{{ $userk->id }}" aria-hidden="true">
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
                                    <h5 class="modal-title text-center" id="editMitraModalLabel{{ $userk->id }}">
                                        <strong>Ubah Akun Sistem</strong>
                                    </h5>
                                </div>
            </div>
            <form action="{{ route('update-user', $userk->id) }}" method="POST" id="editUserForm{{ $userk->id }}">
                @csrf
                @method('PUT')
                <div class="modal-body">
                    <!-- Form input untuk nama -->
                    <div class="mb-3">
                        <label for="editNama{{ $userk->id }}" class="form-label">Nama</label>
                        <input type="text" class="form-control" id="editNama{{ $userk->id }}" name="nama" value="{{ $userk->nama }}" required>
                    </div>

                    <!-- Form input untuk email -->
                    <div class="mb-3">
                        <label for="editEmail{{ $userk->id }}" class="form-label">Email</label>
                        <input type="email" class="form-control" id="editEmail{{ $userk->id }}" name="email" value="{{ $userk->email }}" required>
                    </div>

                    <div class="mb-3">
                        <label for="editPassword{{ $userk->id }}" class="form-label">Password</label>
                        <input type="text" class="form-control" id="password" value="{{ $userk->password }}" name="password" required>
                    </div>

                    <div class="mb-3">
                        <label for="bidang" class="form-label">Bidang Perusahaan</label>
                        <input type="text" class="form-control" id="bidang" name="bidang" value="{{ $userk->bidang }}" required>
                    </div>

                    <div class="mb-3">
                        <label for="telepon" class="form-label">No. Telepon</label>
                        <input type="number" class="form-control" id="telepon" name="telepon" value="{{ $userk->telepon }}" required>
                    </div>

                    <div class="mb-3">
                        <label for="alamat" class="form-label">Alamat</label>
                        <textarea class="form-control" id="alamat" name="alamat" required>{{ $userk->alamat }}</textarea>
                    </div>

                    <!-- Form input untuk role -->
                    <div class="mb-3">
                        <label for="editRole{{ $userk->id }}" class="form-label">Role</label>
                        <select class="form-select" id="editRole{{ $userk->id }}" name="role" required>
                            <option value="Admin" {{ $userk->role == 'Admin' ? 'selected' : '' }}>Admin</option>
                            <option value="Mitra" {{ $userk->role == 'Mitra' ? 'selected' : '' }}>Mitra</option>
                        </select>
                    </div>

                    <!-- Form input untuk status -->
                    <div class="mb-3">
                        <label for="editStatus{{ $user->id }}" class="form-label">Status</label>
                        <select class="form-select" id="editStatus{{ $userk->id }}" name="status" required>
                            <option value="Active" {{ $userk->status == 'Active' ? 'selected' : '' }}>Aktif</option>
                            <option value="Inactive" {{ $userk->status == 'Inactive' ? 'selected' : '' }}>Tidak Aktif</option>
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
        <thead class="table-light">
            <tr class="text-center">
                <th class="text-center">No</th>
                <th class="text-center">Nama</th>
                <th class="text-center">Email</th>
                <th class="text-center">No. Telepon</th>
                <th class="text-center">Alamat</th>
                <th class="text-center">Bidang Perusahaan</th>
                <th class="text-center">Role</th>
                <th class="text-center">Status</th>
                <th class="text-center">Aksi</th>
            </tr>
        </thead>
        <tbody>
            @foreach($ausers as $key => $userk)
                <tr>
                    <td class="text-center">{{ $key + 1 }}</td>
                    <td>{{ $userk->nama }}</td>
                    <td>{{ $userk->email }}</td>
                    <td>{{ $userk->telepon }}</td>
                    <td>{{ $userk->alamat }}</td>
                    <td>{{ $userk->bidang }}</td>
                    <td class="text-center">
                        @if($userk->role == 'Admin')
                            <span class="badge bg-info text-dark">{{ $userk->role }}</span>
                        @elseif($userk->role == 'Mitra')
                            <span class="badge bg-primary text-light">{{ $userk->role }}</span>
                        @endif
                    </td>
                    <td class="text-center">
                        @if($userk->status == 'Active')
                            <span class="badge bg-success text-light">Aktif</span>
                        @elseif($userk->status == 'Inactive')
                            <span class="badge bg-danger text-light">Tidak Aktif</span>
                        @endif
                    </td>
                    <td class="text-center">
                        <!-- Edit Button membuka modal -->
                        <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#editUserModal{{ $userk->id }}"  
                                data-id="{{ $userk->id }}" 
                                data-nama="{{ $userk->nama }}" 
                                data-email="{{ $userk->email }}" 
                                data-role="{{ $userk->role }}" 
                                data-status="{{ $userk->status }}">
                            <i class="bi bi-pencil"></i>
                        </button>
                        <!-- Delete Button menggunakan Form dan SweetAlert konfirmasi -->
                        <form action="{{ route('delete-user', $userk->id) }}" method="POST" style="display:inline;" id="delete-form-{{ $userk->id }}">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-danger" type="button" onclick="confirmDelete({{ $userk->id }})">
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
            "url": "https://cdn.datatables.net/plug-ins/1.13.1/i18n/id.json"  // URL untuk indonesia.json
            }
        });
    });
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

<script>
    // Fungsi konfirmasi SweetAlert untuk Hapus
    function confirmDelete(userId) {
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
                // Kirim form penghapusan jika user mengonfirmasi
                document.getElementById('delete-form-' + userId).submit();
            }
        });
    }
</script>

@endsection
