@extends('layouts.layout-app')

@section('title', 'Manajemen Dokumentasi Event')

@section('content')
<div class="container py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h3>Manajemen Dokumentasi Event</h3>
        <button class="btn btn-success" id="btn-tambah" data-bs-toggle="modal" data-bs-target="#addDocumentModal">Tambah</button>
    </div>

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <!-- Modal untuk menambahkan Kerjasama -->
<div class="modal fade" id="addDocumentModal" tabindex="-1" aria-labelledby="addDocumentModalLabel" aria-hidden="true">
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
                <h5 class="modal-title" id="addDocumentModalLabel"><strong> Tambah Dokumentasi Event</strong></h5>
            </div>
            <!-- Form Modal -->
            <form action="{{ route('store-dokumentasia') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-body">
                    <!-- Input event_id -->
                    <div class="mb-3">
                        <label for="event_id" class="form-label">Event</label>
                        <select class="form-select" id="event_id" name="event_id" required>
                            <option value="" disabled selected>Pilih Event</option>
                            @foreach($amitra as $event)
                                <option value="{{ $event->id }}">{{ $event->event_name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Input document_name -->
                    <div class="mb-3">
                        <label for="document_name" class="form-label">Nama Dokumen</label>
                        <input type="text" class="form-control" id="document_name" name="document_name" required>
                    </div>

                    <!-- Input file -->
                    <div class="mb-3">
                        <label for="file" class="form-label">File</label>
                        <input type="file" class="form-control" id="file" name="file" accept=".jpeg,.jpg,.png" required>
                    </div>

                    <!-- Input description -->
                    <div class="mb-3">
                        <label for="description" class="form-label">Deskripsi</label>
                        <textarea class="form-control" id="description" name="description" rows="3"></textarea>
                    </div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">Simpan Dokumentasi</button>
                </div>
            </form>
        </div>
    </div>
</div>

@foreach($adocuments as $key => $document)
<!-- Modal for displaying document details -->
<div class="modal fade" id="detailDocumentModal{{ $document->id }}" tabindex="-1" aria-labelledby="detailDocumentModalLabel{{ $document->id }}" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <!-- Modal Header -->
            <div class="modal-body text-center" style="background-color: #fff8e1; padding: 20px;">
                <div class="d-flex justify-content-center align-items-center">
                    <img src="{{ asset('img/UNIMAL.png') }}" alt="Universitas Malikussaleh" width="160" height="80" class="me-2">
                    <p style="font-size: 25px; font-weight: bold; color: #006400;">
                        Teknik Informatika | Universitas Malikussaleh
                    </p>
                </div>
            </div>
            <div class="modal-header justify-content-center align-items-center text-center" style="background-color: #006400; color: white;">
                <h5 class="modal-title" id="detailDocumentModalLabel{{ $document->id }}"><strong>Detail Dokumentasi Event</strong></h5>
            </div>
            <!-- Modal Body displaying the document details -->
            <div class="modal-body">
                <!-- Document Event -->
                <div class="mb-3">
                    <label for="event_name" class="form-label"><strong>Event</strong></label>
                    <p>{{ $document->_event->event_name }}</p>
                </div>

                <!-- Document Name -->
                <div class="mb-3">
                    <label for="document_name" class="form-label"><strong>Nama Dokumen</strong></label>
                    <p>{{ $document->document_name }}</p>
                </div>

                <!-- Document File -->
                <div class="mb-3">
                    <label for="file" class="form-label"><strong>File</strong></label>
                    <p>
                        @if($document->file)
                        <img src="{{ asset('img/dokumentasi/' . $document->file) }}" alt="Dokumentasi" style="max-width: 700px; max-height: 400px;">
                        @else
                            <span>No file available</span>
                        @endif
                    </p>
                </div>

                <!-- Document Description -->
                <div class="mb-3">
                    <label for="description" class="form-label"><strong>Deskripsi</strong></label>
                    <p>{{ $document->description }}</p>
                </div>
            </div>
            <!-- Modal Footer -->
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
            </div>
        </div>
    </div>
</div>
@endforeach

@foreach($adocuments as $key => $document)
<!-- Modal for editing document details -->
<div class="modal fade" id="editDocumentModal{{ $document->id }}" tabindex="-1" aria-labelledby="editDocumentModalLabel{{ $document->id }}" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <!-- Modal Header -->
            <div class="modal-body text-center" style="background-color: #fff8e1; padding: 20px;">
                <div class="d-flex justify-content-center align-items-center">
                    <img src="{{ asset('img/UNIMAL.png') }}" alt="Universitas Malikussaleh" width="160" height="80" class="me-2">
                    <p style="font-size: 25px; font-weight: bold; color: #006400;">
                        Teknik Informatika | Universitas Malikussaleh
                    </p>
                </div>
            </div>
            <div class="modal-header justify-content-center align-items-center text-center" style="background-color: #006400; color: white;">
                <h5 class="modal-title" id="editDocumentModalLabel{{ $document->id }}"><strong>Edit Dokumentasi Event</strong></h5>
            </div>
            <!-- Modal Body for the Edit Form -->
            <form action="{{ route('update-dokumentasia', $document->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="modal-body">
                    <!-- Document Event -->
                    <div class="mb-3">
                        <label for="event_id" class="form-label"><strong>Event</strong></label>
                        <select class="form-select" id="event_id" name="event_id" required>
                            <option value="" disabled>Pilih Event</option>
                            @foreach($amitra as $event)
                                <option value="{{ $event->id }}" {{ $event->id == $document->event_id ? 'selected' : '' }}>{{ $event->event_name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Document Name -->
                    <div class="mb-3">
                        <label for="document_name" class="form-label"><strong>Nama Dokumen</strong></label>
                        <input type="text" class="form-control" id="document_name" name="document_name" value="{{ $document->document_name }}" required>
                    </div>

                    <!-- Document File (Optional) -->
                    <div class="mb-3">
                        <label for="file" class="form-label"><strong>File</strong></label>
                        <input type="file" class="form-control" id="file" name="file" accept=".jpeg,.jpg,.png">
                        @if($document->file)
                            <p class="text-success">File: {{  $document->file }}</p>
                        @endif
                    </div>

                    <!-- Document Description -->
                    <div class="mb-3">
                        <label for="description" class="form-label"><strong>Deskripsi</strong></label>
                        <textarea class="form-control" id="description" name="description" rows="3">{{ $document->description }}</textarea>
                    </div>
                </div>

                <!-- Modal Footer -->
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endforeach


    <table class="table table-bordered table-hover" id="documentation-table">
        <thead class="table-light">
            <tr class="text-center">
                <th class="text-center">No</th>
                <th class="text-center">Event</th>
                <th class="text-center">Nama Dokumen</th>
                <th class="text-center">File</th>
                <th class="text-center">Deskripsi</th>
                <th class="text-center">Aksi</th>
            </tr>
        </thead>
        <tbody>
            @foreach($adocuments as $key => $document)
                <tr>
                    <td class="text-center" width="30px">{{ $key + 1 }}</td>
                    <td width="180px">{{ $document->_event->event_name }}</td>
                    <td  width="190px">{{ $document->document_name }}</td>
                    <td  width="130px">
                        <img src="{{ asset('img/dokumentasi/' . $document->file) }}" alt="Dokumentasi" style="max-width: 100px; max-height: 100px;">
                    </td>
                    
                    <td>{{ $document->description }}</td>
                    <td class="text-center" width="150px">
                        <button class="btn btn-secondary btn-sm" data-bs-toggle="modal" data-bs-target="#detailDocumentModal{{ $document->id }}">
                            <i class="bi bi-eye"></i>
                        </button>
                        <button class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#editDocumentModal{{ $document->id }}">
                            <i class="bi bi-pencil"></i>
                        </button>
                        <form action="{{ route('delete-dokumentasia', $document->id) }}" method="POST" style="display:inline;" id="delete-form-{{ $document->id }}">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-danger btn-sm" type="button" onclick="confirmDelete({{ $document->id }})">
                                <i class="bi bi-trash"></i>
                            </button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>

<!-- SweetAlert for success and error messages -->
<script>
    document.addEventListener('DOMContentLoaded', function() {
        @if (session('success'))
            Swal.fire({
                toast: true,
                icon: 'success',
                title: '{{ session("success") }}',
                position: 'top-end',
                showConfirmButton: false,
                timer: 3000,
                timerProgressBar: true
            });
        @elseif (session('error'))
            Swal.fire({
                toast: true,
                icon: 'error',
                title: '{{ session("error") }}',
                position: 'top-end',
                showConfirmButton: false,
                timer: 3000,
                timerProgressBar: true
            });
        @endif
    });

    function confirmDelete(documentId) {
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
                document.getElementById('delete-form-' + documentId).submit();
            }
        });
    }
</script>

<script>
    $(document).ready(function() {
        $('#documentation-table').DataTable({
            "language": {
                "url": "https://cdn.datatables.net/plug-ins/1.13.1/i18n/id.json"
            }
        });
    });
</script>

@endsection
