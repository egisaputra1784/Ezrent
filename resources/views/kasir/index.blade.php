@extends('layouts.master')

@section('title', 'Manajemen User Kasir')

@section('content')
    <div class="container-fluid">

        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h3 class="mb-1">Daftar User Kasir</h3>
                <p class="text-muted small">Hanya menampilkan user dengan role Kasir</p>
            </div>
            <button class="btn btn-primary btn-tambah" data-toggle="modal" data-target="#userKasirModal">
                <i class="typcn typcn-plus"></i> Tambah User Kasir
            </button>
        </div>

        <div class="card shadow-sm">
            <div class="card-body p-0">
                <table class="table table-hover mb-0">
                    <thead>
                        <tr>
                            <th width="50" class="text-center">No</th>
                            <th>Nama</th>
                            <th>Email</th>
                            <th>No HP</th>
                            <th width="120" class="text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($users as $user)
                            <tr>
                                <td class="text-center">{{ $loop->iteration }}</td>
                                <td>{{ $user->nama }}</td>
                                <td>{{ $user->email }}</td>
                                <td><i class="typcn typcn-phone mr-1 text-success"></i>{{ $user->no_hp }}</td>
                                <td class="text-center">
                                    <button class="btn btn-sm btn-info btn-edit" data-id="{{ $user->id }}"
                                        data-nama="{{ $user->nama }}" data-email="{{ $user->email }}"
                                        data-nohp="{{ $user->no_hp }}" data-toggle="modal" data-target="#userKasirModal">
                                        <i class="typcn typcn-edit"></i>
                                    </button>

                                    <form action="{{ route('user-kasir.destroy', $user->id) }}" method="POST"
                                        class="d-inline" onsubmit="return confirm('Hapus user kasir ini?')">
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
                                    Data user kasir kosong
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

    </div>

    @includeIf('kasir.modal')
@endsection

@push('scripts')
    <script>
        $(document).ready(function() {
            $('.btn-tambah').click(function() {
                $('#modalTitle').text('Tambah User Kasir');
                $('#userKasirForm').attr('action', '{{ route('user-kasir.store') }}');
                $('#formMethod').val('POST');

                $('#nama').val('');
                $('#email').val('');
                $('#password').val('');
                $('#no_hp').val('');

                $('#userKasirModal').modal('show');
            });

            $('.btn-edit').click(function() {
                const id = $(this).data('id');
                const nama = $(this).data('nama');
                const email = $(this).data('email');
                const nohp = $(this).data('nohp');

                $('#modalTitle').text('Edit User Kasir');
                $('#userKasirForm').attr('action', '{{ url('owner/user-kasir') }}/' + $(this).data('id'));
                $('#formMethod').val('PUT');

                $('#nama').val(nama);
                $('#email').val(email);
                $('#password').val('');
                $('#no_hp').val(nohp);

                $('#userKasirModal').modal('show');
            });
        });
    </script>
@endpush
