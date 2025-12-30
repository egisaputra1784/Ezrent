@extends('layouts.master')

@section('title', 'Manajemen Customer')

@section('content')
    <div class="container-fluid">

        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h3 class="mb-1">Daftar Customer</h3>
                <p class="text-muted small">Data customer milik perusahaan Anda</p>
            </div>
            <button class="btn btn-primary" data-toggle="modal" data-target="#customerModal">
                <i class="typcn typcn-plus"></i> Tambah Customer
            </button>
        </div>

        <div class="card shadow-sm">
            <div class="card-body p-0">
                <table class="table table-hover mb-0">
                    <thead>
                        <tr>
                            <th width="50">No</th>
                            <th>Nama</th>
                            <th>No HP</th>
                            <th>Alamat</th>
                            <th width="120">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($customers as $customer)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $customer->nama }}</td>
                                <td><i class="typcn typcn-phone mr-1 text-success"></i>{{ $customer->no_hp }}</td>
                                <td>{{ $customer->alamat }}</td>
                                <td>
                                    <button class="btn btn-sm btn-info btn-edit" data-id="{{ $customer->id }}"
                                        data-nama="{{ $customer->nama }}" data-nohp="{{ $customer->no_hp }}"
                                        data-alamat="{{ $customer->alamat }}" data-toggle="modal"
                                        data-target="#customerModal">
                                        <i class="typcn typcn-edit"></i>
                                    </button>

                                    <form action="{{ route('customer.destroy', $customer->id) }}" method="POST"
                                        class="d-inline" onsubmit="return confirm('Hapus customer ini?')">
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
                                    Data customer kosong
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    @include('customer.modal')
@endsection

@push('scripts')
    <script>
        $('.btn-edit').click(function() {
            $('#modalTitle').text('Edit Customer');
            $('#customerForm').attr('action', '{{ url('kasir/customer') }}/' + $(this).data('id'));
            $('#formMethod').val('PUT');

            $('#nama').val($(this).data('nama'));
            $('#no_hp').val($(this).data('nohp'));
            $('#alamat').val($(this).data('alamat'));
        });

        $('.btn-tambah').click(function() {
            $('#modalTitle').text('Tambah Customer');
            $('#customerForm').attr('action', '{{ route('customer.store') }}');
            $('#formMethod').val('POST');

            $('#nama').val('');
            $('#no_hp').val('');
            $('#alamat').val('');
        });
    </script>
@endpush
