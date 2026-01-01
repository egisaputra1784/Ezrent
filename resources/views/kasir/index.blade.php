@extends('layouts.master')

@section('title', 'Manajemen User Kasir')

@section('content')
    <div class="container-fluid">

        {{-- Header --}}
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h3 class="mb-1">Daftar User Kasir</h3>
                <p class="text-muted small">Hanya menampilkan user dengan role Kasir</p>
            </div>
            <div class="d-flex gap-2">
                <button class="btn btn-primary btn-tambah" data-toggle="modal" data-target="#userKasirModal">
                    <i class="typcn typcn-plus"></i> Tambah User Kasir
                </button>
                <button class="btn btn-success" id="exportExcelBtn">
                    <i class="typcn typcn-download"></i> Export Excel
                </button>
            </div>
        </div>

        {{-- Table --}}
        <div class="card shadow-sm">
            <div class="card-body p-0">
                <table class="table table-hover mb-0">
                    <thead class="thead-light">
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
                                        data-nohp="{{ $user->no_hp }}">
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
            // Tambah User Kasir
            $('.btn-tambah').click(function() {
                resetForm('Tambah User Kasir', '{{ route('user-kasir.store') }}', 'POST');
            });

            // Edit User Kasir
            $('.btn-edit').click(function() {
                const id = $(this).data('id');
                resetForm('Edit User Kasir', '{{ url('owner/user-kasir') }}/' + id, 'PUT', {
                    nama: $(this).data('nama'),
                    email: $(this).data('email'),
                    no_hp: $(this).data('nohp')
                });
            });

            // Fungsi reset form modal
            function resetForm(title, action, method, data = {}) {
                $('#modalTitle').text(title);
                $('#userKasirForm').attr('action', action);
                $('#formMethod').val(method);

                $('#nama').val(data.nama || '');
                $('#email').val(data.email || '');
                $('#password').val('');
                $('#no_hp').val(data.no_hp || '');

                $('#userKasirModal').modal('show');
            }
        });
        $('#exportExcelBtn').click(function(e) {
            e.preventDefault();
            if (confirm('Yakin ingin mengekspor data Kasir ke Excel?')) {
                window.location.href = '{{ route('user-kasir.export') }}';
            }
        });
    </script>
@endpush
