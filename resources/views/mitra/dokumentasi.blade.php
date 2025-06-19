@extends('layouts.layout-appm') 

@section('title', 'Dokumentasi')

@section('content')
<div class="container py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h3>Dokumentasi</h3>
        <button class="btn btn-success" id="btn-tambah" data-bs-toggle="modal" data-bs-target="#addDokumentasiModal">Tambah</button>
    </div>

    <!-- Modal untuk menambahkan Kerjasama -->
<div class="modal fade" id="addDokumentasiModal" tabindex="-1" aria-labelledby="addDokumentasiModalLabel" aria-hidden="true">
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
                <h5 class="modal-title" id="addDokumentasiModalLabel"><strong>Tambah Dokumentasi Kerjasama Mitra / Perusahaan</strong></h5>
            </div>
            <!-- Form Modal -->
            <form action="{{ route('store-dokumentasim') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-body">
                    <!-- Input partnership_id -->
                    <div class="mb-3">
                        <label for="partnership_id" class="form-label">Partnership ID</label>
                        <select class="form-select" id="partnership_id" name="partnership_id" required>
                        <option value="" disabled selected>Pilih Kerjasama</option>
                            @foreach($amitra as $partnership)
                                <option value="{{ $partnership->id }}">{{ $partnership->partnership_type }}</option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Input title -->
                    <div class="mb-3">
                        <label for="title" class="form-label">Title</label>
                        <input type="text" class="form-control" id="title" name="title" required>
                    </div>

                    <!-- Input file -->
                    <div class="mb-3">
                        <label for="file" class="form-label">Dokumentasi Kontrak</label>
                        <input type="file" class="form-control" id="file" name="file" accept=".pdf,.doc,.docx,.jpeg,.jpg,.png" required>
                    </div>

                    <div class="mb-3">
                        <label for="mou" class="form-label">MOU</label>
                        <input type="file" class="form-control" id="mou" name="mou" accept=".pdf,.doc,.docx,.jpeg,.jpg,.png" required>
                    </div>

                    <div class="mb-3">
                        <label for="moa" class="form-label">MOA</label>
                        <input type="file" class="form-control" id="moa" name="moa" accept=".pdf,.doc,.docx,.jpeg,.jpg,.png" required>
                    </div>

                    <!-- Input date -->
                    <div class="mb-3">
                        <label for="date" class="form-label">Date</label>
                        <input type="date" class="form-control" id="date" name="date" required>
                    </div>

                    <!-- Input description -->
                    <div class="mb-3">
                        <label for="description" class="form-label">Description</label>
                        <textarea class="form-control" id="description" name="description" rows="3" required></textarea>
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

@foreach($adokumentasi as $key => $partnership)
<!-- Modal Edit untuk Kerjasama -->
<div class="modal fade" id="editModal{{ $partnership->id }}" tabindex="-1" aria-labelledby="editModalLabel{{ $partnership->id }}" aria-hidden="true">
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
                <h5 class="modal-title" id="editModalLabel{{ $partnership->id }}"><strong>Ubah Dokumentasi Kerjasama Mitra / Perusahaan</strong></h5>
            </div>
            <!-- Form Modal -->
            <form action="{{ route('update-dokumentasim', $partnership->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="modal-body">
                    <!-- Input partnership_id (diset ke ID kerjasama yang ada) -->
                    <div class="mb-3">
                        <label for="partnership_id" class="form-label">Partnership ID</label>
                        <select class="form-select" id="partnership_id" name="partnership_id" required>
                            <option value="" disabled>Pilih Kerjasama</option>
                            @foreach($amitra as $av)
                                <option value="{{ $av->id }}" {{ $partnership->partnership_id == $av->id ? 'selected' : '' }}>{{ $av->partnership_type }}</option>
                            @endforeach
                        </select>
                    </div>


                    <!-- Input title (nilai default diisi dengan data kerjasama yang ada) -->
                    <div class="mb-3">
                        <label for="title" class="form-label">Title</label>
                        <input type="text" class="form-control" id="title" name="title" value="{{ old('title', $partnership->title) }}" required>
                    </div>

                    <!-- Input file (tampilkan file yang sudah ada dan memungkinkan untuk mengganti) -->
                    <div class="mb-3">
                        <label for="file" class="form-label">Dokumentasi Kontrak</label>
                        <input type="file" class="form-control" id="file" name="file" accept=".pdf,.doc,.docx,.jpeg,.jpg,.png">
                        <p class="text-success">File: {{ $partnership->file }}</p>
                        
                    </div>

                    <div class="mb-3">
                        <label for="mou" class="form-label">MOU</label>
                        <input type="file" class="form-control" id="mou" name="mou" accept=".pdf,.doc,.docx,.jpeg,.jpg,.png">
                        <p class="text-success">File: {{ $partnership->mou }}</p>
                        
                    </div>

                    <div class="mb-3">
                        <label for="moa" class="form-label">MOA</label>
                        <input type="file" class="form-control" id="moa" name="moa" accept=".pdf,.doc,.docx,.jpeg,.jpg,.png">
                        <p class="text-success">File: {{ $partnership->moa }}</p>
                        
                    </div>

                    <!-- Input date (tanggal diisi dengan nilai yang ada) -->
                    <div class="mb-3">
                        <label for="date" class="form-label">Date</label>
                        <input type="date" class="form-control" id="date" name="date" value="{{ old('date', $partnership->date ? $partnership->date->format('Y-m-d') : '') }}" required>
                    </div>

                    <!-- Input description (deskripsi diisi dengan nilai yang ada) -->
                    <div class="mb-3">
                        <label for="description" class="form-label">Description</label>
                        <textarea class="form-control" id="description" name="description" rows="3" required>{{ old('description', $partnership->description) }}</textarea>
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
                <th class="text-center" width="150px">Kerjasama</th>
                <th class="text-center" width="250px">Judul</th>
                <th class="text-center" width="30px">Dokumentasi Kontrak</th>
                <th class="text-center" width="30px">MOU</th>
                <th class="text-center" width="30px">MOA</th>
                <th class="text-center" width="120px">Tanggal</th>
                <th class="text-center">Deskripsi</th>
                <th class="text-center" width="100px">Aksi</th>
            </tr>
        </thead>
        <tbody>
            @foreach($adokumentasi as $key => $partnership)
                <tr>
                    <td class="text-center" width="30px">{{ $key + 1 }}</td>
                    <td   width="180px">{{ $partnership->_partnership->partnership_type}}</td>
                    <td  width="180px">{{ $partnership->title }}</td>
                    <td class="text-center"  width="30px">
                        <a href="{{ asset('files/dokumentasi/'. $partnership->file) }}" target="_blank">
                            <i class="bi bi-file-earmark-pdf" style="font-size: 1.5rem;"></i>
                        </a>
                    </td>
                    <td class="text-center"  width="30px">
                        <a href="{{ asset('files/mou/'. $partnership->mou) }}" target="_blank">
                            <i class="bi bi-file-earmark-pdf" style="font-size: 1.5rem;"></i>
                        </a>
                    </td>
                    <td class="text-center"  width="30px">
                        <a href="{{ asset('files/moa/'. $partnership->moa) }}" target="_blank">
                            <i class="bi bi-file-earmark-pdf" style="font-size: 1.5rem;"></i>
                        </a>
                    </td>
                    <td class="text-center"  width="100px">{{ \Carbon\Carbon::parse($partnership->date)->format('d F Y') }}</td>
                    <td>{{ $partnership->description }}</td>
                    <td class="text-center"  width="100px">
                        
                        <button class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#editModal{{ $partnership->id }}">
                            <i class="bi bi-pencil"></i>
                        </button>
                      
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
