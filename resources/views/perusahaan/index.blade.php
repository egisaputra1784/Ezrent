@extends('layouts.master')

@section('title', 'Manajemen Owner')

@push('css')
    <style>
        .card {
            border: none;
            border-radius: 14px;
        }

        .table thead th {
            background: #f8f9fa;
            font-size: 11px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: .6px;
        }

        .table td {
            vertical-align: middle;
        }

        .status-badge {
            font-size: 10px;
            padding: 6px 14px;
            border-radius: 20px;
            letter-spacing: .6px;
            text-transform: uppercase;
        }

        .serial-badge {
            font-family: monospace;
            letter-spacing: 1.5px;
            cursor: pointer;
            padding: 8px 14px;
            border-radius: 10px;
            transition: all .2s ease;
        }

        .serial-badge:hover {
            background: #e9ecef;
        }

        .btn-icon {
            width: 34px;
            height: 34px;
            padding: 0;
            display: inline-flex;
            align-items: center;
            justify-content: center;
        }
    </style>
@endpush

@section('content')
    <div class="container-fluid">

        {{-- HEADER --}}
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h3 class="mb-1">Daftar Owner</h3>
                <p class="text-muted small mb-0">
                    Data perusahaan / owner usaha
                </p>
            </div>

            <div class="d-flex gap-2">
                <button class="btn btn-primary btn-tambah" data-toggle="modal" data-target="#ownerModal">
                    <i class="typcn typcn-plus"></i> Tambah Owner
                </button>

                <button class="btn btn-success" id="exportExcelBtn">
                    <i class="typcn typcn-download"></i> Export Excel
                </button>
            </div>
        </div>

        {{-- TABLE --}}
        <div class="card shadow-sm">
            <div class="card-body p-0">
                <table class="table table-hover mb-0">
                    <thead>
                        <tr>
                            <th width="60" class="text-center">No</th>
                            <th>Nama Usaha</th>
                            <th>Serial Number</th>
                            <th>Expired</th>
                            <th>Status</th>
                            <th width="120" class="text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($owners as $owner)
                            <tr>
                                <td class="text-center">{{ $loop->iteration }}</td>
                                <td class="font-weight-medium">{{ $owner->nama_usaha }}</td>
                                <td>
                                    <span class="badge badge-light serial-badge serial-copy"
                                        data-serial="{{ $owner->serial_number }}">
                                        {{ $owner->serial_number }}
                                    </span>
                                </td>
                                <td>
                                    {{ \Carbon\Carbon::parse($owner->expired_at)->format('d M Y') }}
                                </td>
                                <td>
                                    <span
                                        class="badge
                                    {{ $owner->status === 'aktif' ? 'badge-success' : 'badge-danger' }}
                                    status-badge">
                                        {{ $owner->status }}
                                    </span>
                                </td>
                                <td class="text-center">
                                    <button class="btn btn-sm btn-info btn-icon btn-edit" data-id="{{ $owner->id }}"
                                        data-nama="{{ $owner->nama_usaha }}" data-serial="{{ $owner->serial_number }}"
                                        data-expired="{{ $owner->expired_at }}" data-status="{{ $owner->status }}"
                                        data-toggle="modal" data-target="#ownerModal">
                                        <i class="typcn typcn-edit"></i>
                                    </button>

                                    <form action="{{ route('owner.destroy', $owner->id) }}" method="POST" class="d-inline"
                                        onsubmit="return confirm('Hapus owner ini?')">
                                        @csrf
                                        @method('DELETE')
                                        <button class="btn btn-sm btn-danger btn-icon">
                                            <i class="typcn typcn-trash"></i>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center text-muted py-4">
                                    Data owner kosong
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

    </div>

    {{-- MODAL --}}
    @include('perusahaan.modal')
@endsection

@push('scripts')
    <script>
        // COPY SERIAL
        $('.serial-copy').click(function() {
            navigator.clipboard.writeText($(this).data('serial'));
            alert('Serial number berhasil disalin');
        });

        // TAMBAH OWNER
        $('.btn-tambah').click(function() {
            $('#modalTitle').text('Tambah Owner');
            $('#ownerForm').attr('action', '{{ route('owner.store') }}');
            $('#formMethod').val('POST');

            $('#nama_usaha').val('');
            $('#serial_number').val('');
            $('#expired_at').val('');
            $('#status').val('aktif');
        });

        // EDIT OWNER
        $('.btn-edit').click(function() {
            $('#modalTitle').text('Edit Owner');
            $('#ownerForm').attr(
                'action',
                '{{ url('admin/owner') }}/' + $(this).data('id')
            );
            $('#formMethod').val('PUT');

            $('#nama_usaha').val($(this).data('nama'));
            $('#expired_at').val($(this).data('expired'));
            $('#status').val($(this).data('status'));
        });

        // EXPORT EXCEL
        $('#exportExcelBtn').click(function(e) {
            e.preventDefault();
            if (confirm('Yakin ingin mengekspor data perusahaan ke Excel?')) {
                window.location.href = '{{ route('owner.export') }}';
            }
        });
    </script>
@endpush
