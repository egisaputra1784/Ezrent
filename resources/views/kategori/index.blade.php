@extends('layouts.master')

@section('title', 'Manajemen Kategori')

@section('content')
    <div class="container-fluid">

        <div class="d-flex justify-content-between mb-4">
            <h3>Daftar Kategori</h3>
            <button class="btn btn-primary" data-toggle="modal" data-target="#kategoriModal">Tambah Kategori</button>
        </div>

        <div class="card shadow-sm">
            <div class="card-body p-0">
                <table class="table table-hover mb-0">
                    <thead>
                        <tr>
                            <th width="50">No</th>
                            <th>Nama Kategori</th>
                            <th width="120">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($kategoris as $kategori)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $kategori->nama_kategori }}</td>
                                <td>
                                    <button class="btn btn-sm btn-info btn-edit" data-id="{{ $kategori->id }}"
                                        data-nama="{{ $kategori->nama_kategori }}" data-toggle="modal"
                                        data-target="#kategoriModal"><i class="typcn typcn-edit"></i></button>

                                    <form action="{{ route('kategori.destroy', $kategori->id) }}" method="POST"
                                        class="d-inline" onsubmit="return confirm('Hapus kategori ini?')">
                                        @csrf
                                        @method('DELETE')
                                        <button class="btn btn-sm btn-danger"><i class="typcn typcn-trash"></i></button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="3" class="text-center text-muted">Belum ada kategori</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

    </div>

    @includeIf('kategori.modal')
@endsection

@push('scripts')
    <script>
        // Tombol Tambah
        $('[data-target="#kategoriModal"]').click(function() {
            $('#kategoriForm').attr('action', '{{ route('kategori.store') }}'); // route store
            $('#formMethod').val('POST');
            $('#modalTitle').text('Tambah Kategori');
            $('#nama_kategori').val('');
        });

        // Tombol Edit
        $('.btn-edit').click(function() {
            $('#kategoriForm').attr('action', '{{ url('kasir/kategori') }}/' + $(this).data('id')); // route update
            $('#formMethod').val('PUT');
            $('#modalTitle').text('Edit Kategori');
            $('#nama_kategori').val($(this).data('nama'));
        });
    </script>
@endpush
