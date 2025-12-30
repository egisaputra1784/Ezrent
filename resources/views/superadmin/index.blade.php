@extends('layouts.master')

@section('title', 'User Management')

@push('css')
    <style>
        .card {
            border: none;
            border-radius: 12px;
        }

        .table thead th {
            background: #f8f9fa;
            font-size: 11px;
            font-weight: 700;
            text-transform: uppercase;
        }

        .role-badge {
            font-size: 11px;
            padding: 6px 12px;
            border-radius: 20px;
            text-transform: uppercase;
        }
    </style>
@endpush

@section('content')
    <div class="container-fluid">

        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h3 class="mb-1">Daftar User</h3>
                <p class="text-muted small">User dengan role Superadmin & Admin</p>
            </div>
            <button class="btn btn-primary btn-tambah" data-toggle="modal" data-target="#userModal">
                <i class="typcn typcn-plus"></i> Tambah User
            </button>
        </div>

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
                                <td>{{ $user->nama }}</td>
                                <td>{{ $user->email }}</td>
                                <td><i class="typcn typcn-phone mr-1 text-success"></i> {{ $user->no_hp }}</td>
                                <td>
                                    <span
                                        class="badge {{ $user->role === 'superadmin' ? 'badge-info' : 'badge-secondary' }} role-badge">
                                        {{ strtoupper($user->role) }}
                                    </span>
                                </td>
                                <td class="text-center">
                                    <button class="btn btn-sm btn-info btn-edit" data-id="{{ $user->id }}"
                                        data-nama="{{ $user->nama }}" data-email="{{ $user->email }}" data-nohp="{{ $user->no_hp }}"
                                        data-role="{{ $user->role }}" data-toggle="modal" data-target="#userModal">
                                        <i class="typcn typcn-edit"></i>
                                    </button>

                                    <form action="{{ route('superadmin.users.destroy', $user->id) }}" method="POST"
                                        class="d-inline" onsubmit="return confirm('Hapus user ini?')">
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
                                <td colspan="5" class="text-center text-muted py-4">
                                    Data user kosong
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    @includeIf('superadmin.modal')
@endsection

@push('scripts')
    <script>
        $('.btn-tambah').click(function() {
            $('#modalTitle').text('Tambah User');
            $('#userForm').attr('action', '{{ route('superadmin.users.store') }}');
            $('#formMethod').val('POST');
            $('#nama, #email, #password', '#no_hp').val('');
            $('.password-field').show();
        });

        $('.btn-edit').click(function() {
            $('#modalTitle').text('Edit User');
            $('#userForm').attr('action', '/superadmin/users/' + $(this).data('id'));
            $('#formMethod').val('PUT');
            $('#nama').val($(this).data('nama'));
            $('#email').val($(this).data('email'));
            $('#no_hp').val($(this).data('nohp'));
            $('#role').val($(this).data('role'));
            $('#password').val('');
        });
    </script>
@endpush
