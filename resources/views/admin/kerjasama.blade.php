@extends('layouts.layout-app')

@section('title', 'Manajemen Kerjasama')

@section('content')
<div class="container py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h3>Manajemen Pengajuan Kerja Sama</h3>
        <button class="btn btn-success" id="btn-tambah" data-bs-toggle="modal" data-bs-target="#addKerjasamaModal">Tambah</button>
    </div>

    <!-- Modal untuk menambahkan Kerjasama -->
<div class="modal fade" id="addKerjasamaModal" tabindex="-1" aria-labelledby="addKerjasamaModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <!-- Header Modal -->
            <div class="modal-body text-center" style="background-color: #fff8e1; padding: 20px;">
                <div class="d-flex justify-content-center align-items-center">
                    <img src="{{ asset('img/UNIMAL.png') }}" alt="Universitas Malikussaleh" width="160" height="80" class="me-2">
                    <p style="font-size: 25px; font-weight: bold; color: #006400;">
                        Teknik Informatika | Universitas Malikussaleh
                    </p>
                </div>
            </div>
            <div class="modal-header justify-content-center align-items-center text-center" style="background-color: #006400; color: white;">
                <h5 class="modal-title" id="addMitraModalLabel"><strong> Tambah Kerjasama Mitra / Perusahaan</strong></h5>
            </div>
            <!-- Form Modal -->
            <form action="{{ route('store-kerjasama') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-body">
                  
                        <div class="mb-3">
                            <label for="title" class="form-label">Judul Kerjasama</label>
                            <input type="text" class="form-control" id="title" name="title" required>
                        </div>
                    <!-- Input organisation_id -->
                    <div class="mb-3">
                        <label for="organisation_id" class="form-label">Organisasi</label>
                        <select class="form-select" id="organisation_id" name="organisation_id" required>
                            <option value="" disabled selected>Pilih Organisasi</option>
                            @foreach($amitra as $organisation)
                                <option value="{{ $organisation->id }}">{{ $organisation->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Input partnership_type -->
                    <div class="mb-3">
                        <label for="partnership_type" class="form-label">Tipe Kerjasama</label>
                        <input type="text" class="form-control" id="partnership_type" name="partnership_type" required>
                    </div>

                    <!-- Input details -->
                    <div class="mb-3">
                        <label for="details" class="form-label">Detail</label>
                        <textarea class="form-control" id="details" name="details" rows="3"></textarea>
                    </div>

                    <!-- Input document -->
                    <div class="mb-3">
                        <label for="document" class="form-label">Dokumen</label>
                        <input type="file" class="form-control" id="document" name="document" accept=".pdf,.doc,.docx">
                    </div>

                    <!-- Input start_date -->
                    <div class="mb-3">
                        <label for="start_date" class="form-label">Tanggal Mulai</label>
                        <input type="date" class="form-control" id="start_date" name="start_date" required>
                    </div>

                    <!-- Input end_date -->
                    <div class="mb-3">
                        <label for="end_date" class="form-label">Tanggal Berakhir</label>
                        <input type="date" class="form-control" id="end_date" name="end_date" required>
                    </div>

                    <!-- Input approval_date -->
                    <div class="mb-3">
                        <label for="approval_date" class="form-label">Tanggal Persetujuan</label>
                        <input type="date" class="form-control" id="approval_date" name="approval_date">
                    </div>

                    <!-- Input status -->
                    <div class="mb-3">
                        <label for="status" class="form-label">Status</label>
                        <select class="form-select" id="status" name="status" required>
                            <option value="Pending">Pending</option>
                            <option value="Approved">Approved</option>
                            <option value="Rejected">Rejected</option>
                        </select>
                    </div>

                    <!-- Input is_active -->
                    <div class="mb-3">
                        <label for="is_active" class="form-label">Aktif</label>
                        <select class="form-select" id="is_active" name="is_active" required>
                            <option value="Active">Aktif</option>
                            <option value="Inactive">Tidak Aktif</option>
                        </select>
                    </div>

                    <!-- Input notes -->
                    <div class="mb-3">
                        <label for="notes" class="form-label">Catatan</label>
                        <textarea class="form-control" id="notes" name="notes" rows="3"></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">Simpan Kerjasama</button>
                </div>
            </form>
        </div>
    </div>
</div>

@foreach ($akerjasama as $kerjasama) 
    <!-- Modal Detail kerjasama -->
    <div class="modal fade" id="detailKerjasamaModal{{ $kerjasama->id }}" tabindex="-1" aria-labelledby="detailKerjasamaModalLabel{{ $kerjasama->id }}" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <!-- Kop Modal (Logo dan Kerjasama) -->
                <div class="modal-body text-center" style="background-color: #fff8e1; padding: 20px;">
                    <div class="d-flex justify-content-center align-items-center">
                        <img src="{{ asset('img/UNIMAL.png') }}" alt="Universitas Malikussaleh" width="160" height="80" class="me-2">
                        <p style="font-size: 25px; font-weight: bold; color: #006400;">
                            Teknik Informatika | Universitas Malikussaleh
                        </p>
                    </div>
                </div>
                <div class="modal-header justify-content-center align-items-center text-center" style="background-color: #006400; color: white;">
                    <h5 class="modal-title" id="detailModalLabel{{ $kerjasama->id }}">
                        <strong>Kerjasama Mitra / Perusahaan</strong>
                    </h5>
                </div>
                <div class="modal-body" style="background-color: #fff8e1;">
                    <div class="mb-3">
                        <strong>Judul Kerjasama:</strong> {{ $kerjasama->title ?? 'Tidak Ada' }}
                    </div>
                    <!-- Organisation ID -->
                    <div class="mb-3">
                        <strong>ID Organisasi:</strong> {{ $kerjasama->organisation_id ?? 'Tidak Ada' }}
                    </div>

                    <!-- Partnership Type -->
                    <div class="mb-3">
                        <strong>Jenis Kemitraan:</strong> {{ $kerjasama->partnership_type ?? 'Tidak Ada' }}
                    </div>

                    <!-- Details -->
                    <div class="mb-3">
                        <strong>Detail:</strong> {{ $kerjasama->details ?? 'Tidak Ada' }}
                    </div>

                    <!-- Document -->
                    <div class="mb-3">
                        <strong>Dokumen:</strong> <a href="{{ asset('files/document/'. $kerjasama->document) ?? '#' }}" target="_blank">{{ $kerjasama->document ? 'Lihat Dokumen' : 'Tidak Ada' }}</a>
                    </div>

                    <!-- Start Date -->
                    <div class="mb-3">
                        <strong>Tanggal Mulai:</strong> {{ $kerjasama->start_date ? $kerjasama->start_date->format('d F Y') : 'Tidak Ada' }}
                    </div>

                    <!-- End Date -->
                    <div class="mb-3">
                        <strong>Tanggal Berakhir:</strong> {{ $kerjasama->end_date ? $kerjasama->end_date->format('d F Y') : 'Tidak Ada' }}
                    </div>

                    <!-- Approval Date -->
                    <div class="mb-3">
                        <strong>Tanggal Persetujuan:</strong> {{ $kerjasama->approval_date ? $kerjasama->approval_date->format('d F Y') : 'Tidak Ada' }}
                    </div>

                    <!-- Status -->
                    <div class="mb-3">
                        <strong>Status:</strong>
                        @if($kerjasama->status === 'Approved')
                            <span class="badge bg-success text-light">Disetujui</span>
                        @elseif($kerjasama->status === 'Rejected')
                            <span class="badge bg-danger text-light">Ditolak</span>
                        @elseif($kerjasama->status === 'Pending')
                            <span class="badge bg-warning text-dark">Menunggu</span>
                        @else
                            <span class="badge bg-secondary text-light">Tidak Diketahui</span>
                        @endif
                    </div>

                    <!-- Is Active -->
                 <!-- Is Active -->
                <div class="mb-3">
                    <strong>Aktif:</strong>
                    @if($kerjasama->is_active == 'Active')
                            <span class="badge bg-success text-light">Aktif</span>
                        @else($kerjasama->is_active == 'Inactive')
                            <span class="badge bg-danger text-light">Tidak Aktif</span>
                        @endif
                </div>


                    <!-- Notes -->
                    <div class="mb-3">
                        <strong>Catatan:</strong> {{ $kerjasama->notes ?? 'Tidak Ada' }}
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                </div>
            </div>
        </div>
    </div>
@endforeach

@foreach ($akerjasama as $kerjasama)
    <!-- Modal Edit kerjasama -->
    <div class="modal fade" id="editKerjasamaModal{{ $kerjasama->id }}" tabindex="-1" aria-labelledby="editKerjasamaModalLabel{{ $kerjasama->id }}" aria-hidden="true">
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
                            <h5 class="modal-title text-center" id="editKerjasamaModalLabel{{ $kerjasama->id }}">
                                <strong>Ubah Kerjasama Mitra / Perusahaan</strong>
                            </h5>
                        </div>
                    </div>
                <form action="{{ route('update-kerjasama', $kerjasama->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <div class="modal-body" style="background-color: #fff8e1;">
                        <div class="mb-3">
                            <label for="title{{ $kerjasama->id }}" class="form-label">Judul Kerjasama</label>
                            <input type="text" class="form-control" id="title{{ $kerjasama->id }}" name="title" value="{{ $kerjasama->title }}" required>
                        </div>

                        <!-- Organisation ID -->
                        <div class="mb-3">
                            <label for="organisation_id{{ $kerjasama->id }}" class="form-label">Organisasi</label>
                            <select class="form-select" id="organisation_id{{ $kerjasama->id }}" name="organisation_id" required>
                                <option value="" disabled>Pilih Organisasi</option>
                                @foreach($amitra as $organisation)
                                    <option value="{{ $organisation->id }}" {{ $kerjasama->organisation_id == $organisation->id ? 'selected' : '' }}>
                                        {{ $organisation->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Partnership Type -->
                        <div class="mb-3">
                            <label for="partnership_type{{ $kerjasama->id }}" class="form-label">Tipe Kerjasama</label>
                            <input type="text" class="form-control" id="partnership_type{{ $kerjasama->id }}" name="partnership_type" value="{{ $kerjasama->partnership_type }}" required>
                        </div>

                        <!-- Details -->
                        <div class="mb-3">
                            <label for="details{{ $kerjasama->id }}" class="form-label">Detail</label>
                            <textarea class="form-control" id="details{{ $kerjasama->id }}" name="details" rows="3">{{ $kerjasama->details }}</textarea>
                        </div>

                        <!-- Document -->
                        <div class="mb-3">
                            <label for="document{{ $kerjasama->id }}" class="form-label">Dokumen</label>
                            <input type="file" class="form-control" name="document" accept=".pdf,.doc,.docx">
                            <p class="text-success">File: {{ $kerjasama->document }}</p>
                        </div>

                        <!-- Tanggal Mulai, Berakhir, Persetujuan -->
                        <div class="row">
                            <div class="col-md-4 mb-3">
                                <label for="start_date{{ $kerjasama->id }}" class="form-label">Tanggal Mulai</label>
                                <input type="date" class="form-control" id="start_date{{ $kerjasama->id }}" name="start_date" value="{{ $kerjasama->start_date ? $kerjasama->start_date->format('Y-m-d') : '' }}" required>
                            </div>
                            <div class="col-md-4 mb-3">
                                <label for="end_date{{ $kerjasama->id }}" class="form-label">Tanggal Berakhir</label>
                                <input type="date" class="form-control" id="end_date{{ $kerjasama->id }}" name="end_date" value="{{ $kerjasama->end_date ? $kerjasama->end_date->format('Y-m-d') : '' }}" required>
                            </div>
                            <div class="col-md-4 mb-3">
                                <label for="approval_date{{ $kerjasama->id }}" class="form-label">Tanggal Persetujuan</label>
                                <input type="date" class="form-control" id="approval_date{{ $kerjasama->id }}" name="approval_date" value="{{ $kerjasama->approval_date ? $kerjasama->approval_date->format('Y-m-d') : '' }}">
                            </div>
                        </div>

                        <!-- Status -->
                        <div class="mb-3">
                            <label for="status{{ $kerjasama->id }}" class="form-label">Status</label>
                            <select class="form-select" id="status{{ $kerjasama->id }}" name="status" required>
                                <option value="Pending" {{ $kerjasama->status == 'Pending' ? 'selected' : '' }}>Pending</option>
                                <option value="Approved" {{ $kerjasama->status == 'Approved' ? 'selected' : '' }}>Approved</option>
                                <option value="Rejected" {{ $kerjasama->status == 'Rejected' ? 'selected' : '' }}>Rejected</option>
                            </select>
                        </div>

                        <div class="mb-3">
                            <label for="is_active{{ $kerjasama->id }}" class="form-label">Status</label>
                            <select class="form-select" id="is_active{{ $kerjasama->id }}" name="is_active" required>
                                <option value="Active" {{ $kerjasama->is_active == 'Active' ? 'selected' : '' }}>Active</option>
                                <option value="Inactive" {{ $kerjasama->is_active == 'Inactive' ? 'selected' : '' }}>Inactive</option>
                            </select>
                        </div>

                        <!-- Notes -->
                        <div class="mb-3">
                            <label for="notes{{ $kerjasama->id }}" class="form-label">Catatan</label>
                            <textarea class="form-control" id="notes{{ $kerjasama->id }}" name="notes" rows="3">{{ $kerjasama->notes }}</textarea>
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
                <th>No</th>
                <th>Judul Kerjasama</th>
                <th>Organisasi</th>
                
                <th>Jenis Kerjasama</th>
                <th>Tanggal Disetujui</th>
                <th>Deskripsi</th>
                <th>Status</th>
                <th>Status Kerjasama</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @foreach($akerjasama as $key => $kerjasama)
                <tr>
                    <td class="text-center" width="30px">{{ $key + 1 }}</td>
                    <td width="150px">{{ $kerjasama->title }}</td>
                    <td width="150px">{{ $kerjasama->organisation->name }}</td>
                    <td>{{ $kerjasama->partnership_type }}</td>
                    <td width="160px">{{ \Carbon\Carbon::parse($kerjasama->approval_date)->translatedFormat('d F Y') }}</td>
                    <td width="150px">{{ $kerjasama->details }}</td>
                    <td class="text-center"  class="text-center" width="100px">
                        @if($kerjasama->status === 'Approved')
                            <span class="badge bg-success text-light">Disetujui</span>
                        @elseif($kerjasama->status === 'Rejected')
                            <span class="badge bg-danger text-light">Ditolak</span>
                        @elseif($kerjasama->status === 'Pending')
                            <span class="badge bg-warning text-dark">Menunggu</span>
                        @else
                            <span class="badge bg-secondary text-light">Tidak Diketahui</span>
                        @endif
                    </td>                    
                    <td class="text-center"  width="100px">
                        @if($kerjasama->is_active == 'Active')
                            <span class="badge bg-success text-light">Aktif</span>
                        @else($kerjasama->is_active == 'Inactive')
                            <span class="badge bg-secondary text-light">Tidak Aktif</span>
                        @endif
                    </td>
                    <td class="text-center" width="150px">
                        <button class="btn btn-secondary btn-sm" data-bs-toggle="modal" data-bs-target="#detailKerjasamaModal{{ $kerjasama->id }}">
                            <i class="bi bi-eye"></i>
                        </button>
                        <button class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#editKerjasamaModal{{ $kerjasama->id }}">
                            <i class="bi bi-pencil"></i>
                        </button>
                      
                        <form action="{{ route('delete-kerjasama', $kerjasama->id) }}" method="POST" style="display:inline;" id="delete-form-{{ $kerjasama->id }}">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-danger btn-sm" type="button" onclick="confirmDelete({{ $kerjasama->id }})">
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

    function confirmDelete(kerjasamaId) {
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
                document.getElementById('delete-form-' + kerjasamaId).submit();
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
