@extends('layouts.layout-app')

@section('title', 'Manajemen Event')

@section('content')
<div class="container py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h3>Manajemen Event</h3>
        <button class="btn btn-success" id="btn-tambah" data-bs-toggle="modal" data-bs-target="#addAcaraModal">Tambah</button>
    </div>

    <!-- Modal untuk Menambahkan Acara -->
<div class="modal fade" id="addAcaraModal" tabindex="-1" aria-labelledby="addAcaraModalLabel" aria-hidden="true">
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
                <h5 class="modal-title" id="addAcaraModalLabel"><strong>Tambah Manajemen Event</strong></h5>
            </div>
            <!-- Form Modal -->
            <form action="{{ route('store-acara') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-body">
                    <!-- Input partnership_id -->
                    <div class="mb-3">
                        <label for="partnership_id" class="form-label">Pilih Kerjasama</label>
                        <select class="form-select" id="partnership_id" name="partnership_id" required>
                            <option value="" disabled selected>Pilih Partnership</option>
                            @foreach($amitra as $partnership)
                                <option value="{{ $partnership->id }}">{{ $partnership->partnership_type}}</option>
                            @endforeach 
                        </select>
                    </div>

                    <!-- Input event_name -->
                    <div class="mb-3">
                        <label for="event_name" class="form-label">Nama Event</label>
                        <input type="text" class="form-control" id="event_name" name="event_name" required>
                    </div>

                    <!-- Input event_details -->
                    <div class="mb-3">
                        <label for="event_details" class="form-label">Deskripsi Event</label>
                        <textarea class="form-control" id="event_details" name="event_details" rows="3" required></textarea>
                    </div>

                    <!-- Input start_date -->
                    <div class="mb-3">
                        <label for="start_date" class="form-label">Tanggal Mulai</label>
                        <input type="date" class="form-control" id="start_date" name="start_date" required>
                    </div>

                    <!-- Input end_date -->
                    <div class="mb-3">
                        <label for="end_date" class="form-label">Tanggal Selesai</label>
                        <input type="date" class="form-control" id="end_date" name="end_date" required>
                    </div>

                    <!-- Input status -->
                    <div class="mb-3">
                        <label for="status" class="form-label">Status</label>
                        <select class="form-select" id="status" name="status" required>
                            <option value="" disabled selected>Pilih Status</option>
                            <option value="Ongoing">Ongoing</option>
                            <option value="Completed">Completed</option>
                            <option value="Cancelled">Cancelled</option>
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">Simpan Acara</button>
                </div>
            </form>
        </div>
    </div>
</div>

@foreach ($aevents as $event)
<div class="modal fade" id="editModal{{ $event->id }}" tabindex="-1" aria-labelledby="editModalLabel{{ $event->id }}" aria-hidden="true">
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
                <h5 class="modal-title" id="editModalLabel{{ $event->id }}"><strong>Ubah Manajemen Event</strong></h5>
            </div>
            <!-- Form Modal -->
            <form action="{{ route('update-acara', $event->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="modal-body">
                    <!-- Input partnership_id -->
                    <div class="mb-3">
                        <label for="partnership_id_{{ $event->id }}" class="form-label">Pilih Kerjasama</label>
                        <select class="form-select" id="partnership_id_{{ $event->id }}" name="partnership_id" required>
                            <option value="" disabled>Pilih Partnership</option>
                            @foreach($amitra as $partnership)
                                <option value="{{ $partnership->id }}" {{ $event->partnership_id == $partnership->id ? 'selected' : '' }}>
                                    {{ $partnership->partnership_type }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Input event_name -->
                    <div class="mb-3">
                        <label for="event_name_{{ $event->id }}" class="form-label">Nama Event</label>
                        <input type="text" class="form-control" id="event_name_{{ $event->id }}" name="event_name" value="{{ $event->event_name }}" required>
                    </div>

                    <!-- Input event_details -->
                    <div class="mb-3">
                        <label for="event_details_{{ $event->id }}" class="form-label">Detail Event</label>
                        <textarea class="form-control" id="event_details_{{ $event->id }}" name="event_details" rows="3" required>{{ $event->event_details }}</textarea>
                    </div>

                    <!-- Input start_date -->
                    <div class="mb-3">
                        <label for="start_date_{{ $event->id }}" class="form-label">Tanggal Mulai</label>
                        <input type="date" class="form-control" id="start_date_{{ $event->id }}" name="start_date" value="{{ $event->start_date ? $event->start_date->format('Y-m-d') : '' }}" required>
                    </div>

                    <!-- Input end_date -->
                    <div class="mb-3">
                        <label for="end_date_{{ $event->id }}" class="form-label">Tanggal Selesai</label>
                        <input type="date" class="form-control" id="end_date_{{ $event->id }}" name="end_date" value="{{ $event->end_date ? $event->end_date->format('Y-m-d') : ''}}" required>
                    </div>

                    <!-- Input status -->
                    <div class="mb-3">
                        <label for="status_{{ $event->id }}" class="form-label">Status</label>
                        <select class="form-select" id="status_{{ $event->id }}" name="status" required>
                            <option value="" disabled>Pilih Status</option>
                            <option value="Ongoing" {{ $event->status == 'Ongoing' ? 'selected' : '' }}>Ongoing</option>
                            <option value="Completed" {{ $event->status == 'Completed' ? 'selected' : '' }}>Completed</option>
                            <option value="Cancelled" {{ $event->status == 'Cancelled' ? 'selected' : '' }}>Cancelled</option>
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



    <table class="table table-bordered table-hover" id="table-acara">
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
                <th class="text-center">No</th>
                <th class="text-center">Kerjasama</th>
                <th class="text-center">Nama Event</th>
                <th class="text-center">Detail Event</th>
                <th class="text-center">Tanggal Mulai</th>
                <th class="text-center">Tanggal Selesai</th>
                <th class="text-center">Status</th>
                <th class="text-center">Aksi</th>
            </tr>
        </thead>
        <tbody>
            @foreach($aevents as $key => $event)
                <tr>
                    <td class="text-center" width="30px">{{ $key + 1 }}</td>
                    <td width="150px">{{ $event->_partnership->partnership_type }}</td>
                    <td width="150px">{{ $event->event_name }}</td>
                    <td>{{ $event->event_details }}</td>
                    <td class="text-center" width="150px">{{ \Carbon\Carbon::parse($event->start_date)->format('d F Y') }}</td>
                    <td class="text-center" width="150px">{{ \Carbon\Carbon::parse($event->end_date)->format('d F Y') }}</td>
                    <td class="text-center" width="130px">
                        @if ($event->status === 'Ongoing')
                            <span class="badge bg-warning text-dark">Ongoing</span>
                        @elseif ($event->status === 'Completed')
                            <span class="badge bg-success">Completed</span>
                        @elseif ($event->status === 'Cancelled')
                            <span class="badge bg-danger">Cancelled</span>
                        @else
                            <span class="badge bg-secondary">Unknown</span>
                        @endif
                    </td>
                    <td class="text-center" width="100px">
                        <button class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#editModal{{ $event->id }}">
                            <i class="bi bi-pencil"></i>
                        </button>
                        <form action="{{ route('delete-acara', $event->id) }}" method="POST" style="display:inline;" id="delete-form-{{ $event->id }}">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-danger btn-sm" type="button" onclick="confirmDelete({{ $event->id }})">
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
        $('#table-acara').DataTable({
            "language": {
                "url": "https://cdn.datatables.net/plug-ins/1.13.1/i18n/id.json"
            }
        });
    });

    function confirmDelete(eventId) {
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
                document.getElementById('delete-form-' + eventId).submit();
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
