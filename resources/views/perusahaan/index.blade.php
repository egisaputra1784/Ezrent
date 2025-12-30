@extends('layouts.master')

@section('title', 'Manajemen Owner')

@section('content')
    <div class="container-fluid">

        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h3 class="mb-1">Daftar Owner</h3>
                <p class="text-muted small">Data perusahaan / owner usaha</p>
            </div>
            <button class="btn btn-primary btn-tambah" data-toggle="modal" data-target="#ownerModal">
                <i class="typcn typcn-plus"></i> Tambah Owner
            </button>
        </div>

        <div class="card shadow-sm">
            <div class="card-body p-0">
                <table class="table table-hover mb-0">
                    <thead>
                        <tr>
                            <th width="50" class="text-center">No</th>
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
                                <td>{{ $owner->nama_usaha }}</td>
                                <td>
                                    <span class="badge badge-light font-monospace px-3 py-2 serial-copy"
                                        data-serial="{{ $owner->serial_number }}"
                                        style="cursor:pointer; letter-spacing:1px; font-weight:bold;">
                                        {{ $owner->serial_number }}
                                    </span>
                                </td>
                                <td>{{ \Carbon\Carbon::parse($owner->expired_at)->format('d M Y') }}</td>
                                <td>
                                    <span class="badge {{ $owner->status === 'aktif' ? 'badge-success' : 'badge-danger' }}">
                                        {{ strtoupper($owner->status) }}
                                    </span>
                                </td>
                                <td class="text-center">
                                    <button class="btn btn-sm btn-info btn-edit" data-id="{{ $owner->id }}"
                                        data-nama="{{ $owner->nama_usaha }}" data-serial="{{ $owner->serial_number }}"
                                        data-expired="{{ $owner->expired_at }}" data-status="{{ $owner->status }}"
                                        data-toggle="modal" data-target="#ownerModal">
                                        <i class="typcn typcn-edit"></i>
                                    </button>

                                    <form action="{{ route('owner.destroy', $owner->id) }}" method="POST" class="d-inline"
                                        onsubmit="return confirm('Hapus owner ini?')">
                                        @csrf
                                        @method('DELETE')
                                        <button class="btn btn-sm btn-danger">
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

    @include('perusahaan.modal')
@endsection


@push('scripts')
    <script>
        $('.serial-copy').click(function() {
            navigator.clipboard.writeText($(this).data('serial'));
            alert('Serial number copied!');
        });

        $('.btn-tambah').click(function() {
            $('#modalTitle').text('Tambah Owner');
            $('#ownerForm').attr('action', '{{ route('owner.store') }}');
            $('#formMethod').val('POST');

            $('#nama_usaha').val('');
            $('#serial_number').val('');
            $('#expired_at').val('');
            $('#status').val('aktif');
        });

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
    </script>
@endpush
