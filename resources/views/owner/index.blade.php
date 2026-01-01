@extends('layouts.master')

@section('title', 'Manajemen User Owner')

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
            letter-spacing: .5px;
            border-bottom: none;
        }

        .table tbody td {
            vertical-align: middle;
        }

        .btn-icon {
            width: 34px;
            height: 34px;
            padding: 0;
            display: inline-flex;
            align-items: center;
            justify-content: center;
        }

        .select2-container--default .select2-selection--single {
            height: calc(2.25rem + 2px);
            padding: 0.375rem 0.75rem;
            border-radius: 8px;
        }

        .select2-container--default .select2-selection--single .select2-selection__rendered {
            line-height: 1.5;
        }

        .select2-container--default .select2-selection--single .select2-selection__arrow {
            height: 100%;
        }
    </style>
@endpush

@section('content')
    <div class="container-fluid">

        {{-- HEADER --}}
        <div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-2">
            <div>
                <h3 class="mb-1">Daftar User Owner</h3>
                <p class="text-muted small mb-0">
                    Hanya menampilkan user dengan role <strong>Owner</strong>
                </p>
            </div>

            <div class="d-flex gap-2">
                <button class="btn btn-primary btn-tambah" data-toggle="modal" data-target="#userOwnerModal">
                    <i class="typcn typcn-plus"></i> Tambah
                </button>
                <button class="btn btn-success" id="exportExcelBtn">
                    <i class="typcn typcn-download"></i> Export
                </button>
            </div>
        </div>

        {{-- TABLE --}}
        <div class="card shadow-sm">
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover mb-0">
                        <thead>
                            <tr>
                                <th width="50" class="text-center">No</th>
                                <th>Nama User</th>
                                <th>Email</th>
                                <th>No HP</th>
                                <th>Owner Usaha</th>
                                <th width="120" class="text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($users as $user)
                                <tr>
                                    <td class="text-center">{{ $loop->iteration }}</td>
                                    <td class="fw-semibold">{{ $user->nama }}</td>
                                    <td class="text-muted">{{ $user->email }}</td>
                                    <td>
                                        <i class="typcn typcn-phone text-success mr-1"></i>
                                        {{ $user->no_hp }}
                                    </td>
                                    <td>
                                        {{ $user->owner?->nama_usaha ?? '-' }}
                                    </td>
                                    <td class="text-center">
                                        <button class="btn btn-info btn-sm btn-icon btn-edit" data-id="{{ $user->id }}"
                                            data-nama="{{ $user->nama }}" data-email="{{ $user->email }}"
                                            data-nohp="{{ $user->no_hp }}" data-owner="{{ $user->owner_id }}"
                                            data-toggle="modal" data-target="#userOwnerModal" title="Edit">
                                            <i class="typcn typcn-edit"></i>
                                        </button>

                                        <form action="{{ route('user-owner.destroy', $user->id) }}" method="POST"
                                            class="d-inline" onsubmit="return confirm('Hapus user owner ini?')">
                                            @csrf
                                            @method('DELETE')
                                            <button class="btn btn-danger btn-sm btn-icon" title="Hapus">
                                                <i class="typcn typcn-trash"></i>
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="text-center text-muted py-4">
                                        Data user owner belum tersedia
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    @includeIf('owner.modal')
@endsection

@push('scripts')
    <script>
        $('.btn-tambah').click(function() {
            $('#modalTitle').text('Tambah User Owner');
            $('#userOwnerForm').attr('action', '{{ route('user-owner.store') }}');
            $('#formMethod').val('POST');

            $('#nama, #email, #password, #no_hp').val('');
            $('#owner_id').val(null).trigger('change');
        });

        $('.btn-edit').click(function() {
            $('#modalTitle').text('Edit User Owner');
            $('#userOwnerForm').attr('action', '/admin/user-owner/' + $(this).data('id'));
            $('#formMethod').val('PUT');

            $('#nama').val($(this).data('nama'));
            $('#email').val($(this).data('email'));
            $('#password').val('');
            $('#no_hp').val($(this).data('nohp'));
            $('#owner_id').val($(this).data('owner')).trigger('change');
        });

        $('#userOwnerModal').on('shown.bs.modal', function() {
            $('#owner_id').select2({
                dropdownParent: $('#userOwnerModal'),
                width: '100%',
                placeholder: '-- Pilih Perusahaan --'
            });
        });

        $('#exportExcelBtn').click(function(e) {
            e.preventDefault();
            if (confirm('Yakin ingin mengekspor data User Owner ke Excel?')) {
                window.location.href = '{{ route('user-owner.export') }}';
            }
        });
    </script>
@endpush
