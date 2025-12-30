@extends('layouts.master')

@section('title', 'Manajemen User Owner')

@section('content')
    <div class="container-fluid">

        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h3 class="mb-1">Daftar User Owner</h3>
                <p class="text-muted small">Hanya menampilkan user dengan role Owner</p>
            </div>
            <button class="btn btn-primary btn-tambah" data-toggle="modal" data-target="#userOwnerModal">
                <i class="typcn typcn-plus"></i> Tambah User Owner
            </button>
        </div>

        <div class="card shadow-sm">
            <div class="card-body p-0">
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
                                <td>{{ $user->nama }}</td>
                                <td>{{ $user->email }}</td>
                                <td>{{ $user->no_hp }}</td>
                                <td>{{ $user->owner?->nama_usaha ?? '-' }}</td>
                                <td class="text-center">
                                    <button class="btn btn-sm btn-info btn-edit" data-id="{{ $user->id }}"
                                        data-nama="{{ $user->nama }}" data-email="{{ $user->email }}"
                                        data-nohp="{{ $user->no_hp }}" data-owner="{{ $user->owner_id }}"
                                        data-toggle="modal" data-target="#userOwnerModal">
                                        <i class="typcn typcn-edit"></i>
                                    </button>

                                    <form action="{{ route('user-owner.destroy', $user->id) }}" method="POST"
                                        class="d-inline" onsubmit="return confirm('Hapus user owner ini?')">
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
                                    Data user owner kosong
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
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

            $('#nama').val('');
            $('#email').val('');
            $('#password').val('');
            $('#no_hp').val('');
            $('#owner_id').val('');
        });

        $('.btn-edit').click(function() {
            $('#modalTitle').text('Edit User Owner');
            $('#userOwnerForm').attr('action', '/admin/user-owner/' + $(this).data('id'));
            $('#formMethod').val('PUT');

            $('#nama').val($(this).data('nama'));
            $('#email').val($(this).data('email'));
            $('#password').val(''); // kosongkan password saat edit
            $('#no_hp').val($(this).data('nohp'));
            $('#owner_id').val($(this).data('owner'));
        });
    </script>
@endpush
