@extends('layouts.master')

@section('title', 'User Management')

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

        .role-badge {
            font-size: 10px;
            padding: 6px 14px;
            border-radius: 20px;
            letter-spacing: .6px;
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
                <h3 class="mb-1">Daftar User</h3>
                <p class="text-muted small mb-0">
                    User dengan role Superadmin & Admin
                </p>
            </div>

            <div class="d-flex gap-2">
                <button class="btn btn-primary btn-tambah" data-toggle="modal" data-target="#userModal">
                    <i class="typcn typcn-plus"></i> Tambah User
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
                            <th>Nama</th>
                            <th>Email</th>
                            <th>Kontak</th>
                            <th>Role</th>
                            <th width="120" class="text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($users as $user)
                            <tr>
                                <td class="text-center">{{ $loop->iteration }}</td>
                                <td class="font-weight-medium">{{ $user->nama }}</td>
                                <td>{{ $user->email }}</td>
                                <td>
                                    <i class="typcn typcn-phone text-success mr-1"></i>
                                    {{ $user->no_hp }}
                                </td>
                                <td>
                                    <span
                                        class="badge
                                    {{ $user->role === 'superadmin' ? 'badge-info' : 'badge-secondary' }}
                                    role-badge">
                                        {{ strtoupper($user->role) }}
                                    </span>
                                </td>
                                <td class="text-center">
                                    <button class="btn btn-sm btn-info btn-icon btn-edit" data-id="{{ $user->id }}"
                                        data-nama="{{ $user->nama }}" data-email="{{ $user->email }}"
                                        data-nohp="{{ $user->no_hp }}" data-role="{{ $user->role }}" data-toggle="modal"
                                        data-target="#userModal">
                                        <i class="typcn typcn-edit"></i>
                                    </button>

                                    <form action="{{ route('superadmin.users.destroy', $user->id) }}" method="POST"
                                        class="d-inline" onsubmit="return confirm('Hapus user ini?')">
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
                                    Data user kosong
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

    </div>

    {{-- MODAL --}}
    @includeIf('superadmin.modal')
@endsection

@push('scripts')
    <script>
        // TAMBAH USER
        $('.btn-tambah').click(function() {
            $('#modalTitle').text('Tambah User');
            $('#userForm').attr('action', '{{ route('superadmin.users.store') }}');
            $('#formMethod').val('POST');

            $('#nama, #email, #password, #no_hp').val('');
            $('#role').val('');
            $('.password-field').show();
        });

        // EDIT USER
        $('.btn-edit').click(function() {
            $('#modalTitle').text('Edit User');
            $('#userForm').attr('action', '/superadmin/users/' + $(this).data('id'));
            $('#formMethod').val('PUT');

            $('#nama').val($(this).data('nama'));
            $('#email').val($(this).data('email'));
            $('#no_hp').val($(this).data('nohp'));
            $('#role').val($(this).data('role'));
            $('#password').val('');
            $('.password-field').hide();
        });

        // EXPORT EXCEL
        $('#exportExcelBtn').click(function(e) {
            e.preventDefault();
            if (confirm('Yakin ingin mengekspor data user ke Excel?')) {
                window.location.href = '{{ route('superadmin.superadmin.users.export') }}';
            }
        });
    </script>
@endpush
