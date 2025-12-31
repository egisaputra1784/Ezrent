@extends('layouts.master')

@section('title', 'Manajemen Produk')

@section('content')
    <div class="container-fluid">

        <h3 class="mb-0">Daftar Produk</h3>
        <div class="d-flex justify-content-between mb-4 align-items-center">
            <input type="text" id="searchProduk" class="form-control mr-2" placeholder="Cari produk...">
            <button class="btn btn-primary" data-toggle="modal" data-target="#produkModal">
                <i class="typcn typcn-plus mr-1"></i> Tambah Produk
            </button>
        </div>

        <div class="row">
            @forelse($produks as $produk)
                <div class="col-md-4 mb-4">
                    <div class="card shadow-sm h-100">
                        @if ($produk->gambar)
                            <img src="{{ asset('storage/' . $produk->gambar) }}" class="card-img-top"
                                alt="{{ $produk->nama_produk }}" style="height: 180px; object-fit: cover;">
                        @else
                            <div class="bg-light text-center py-5" style="height:180px;">
                                <i class="typcn typcn-image text-muted" style="font-size: 3rem;"></i>
                            </div>
                        @endif
                        <div class="card-body d-flex flex-column">
                            <h5 class="card-title font-weight-bold">{{ $produk->nama_produk }}</h5>
                            <p class="mb-1"><strong>Kategori:</strong> {{ $produk->kategori?->nama_kategori ?? '-' }}</p>
                            <p class="mb-1"><strong>Harga sewa:</strong> Rp
                                {{ number_format($produk->harga_sewa, 0, ',', '.') }}</p>
                               <p class="mb-1"><strong>Denda:</strong> {{ $produk->denda, 0, }}%</p>

                            <span
                                class="badge {{ $produk->status === 'tersedia' ? 'badge-success' : 'badge-warning' }} mb-2">
                                {{ strtoupper($produk->status) }}
                            </span>
                            <div class="mt-auto d-flex justify-content-between">
                                <button class="btn btn-sm btn-info btn-edit" data-id="{{ $produk->id }}"
                                    data-nama="{{ $produk->nama_produk }}" data-kategori="{{ $produk->kategori_id }}"
                                    data-harga="{{ $produk->harga_sewa }}" data-denda="{{ $produk->denda }}"
                                    data-status="{{ $produk->status }}" data-toggle="modal" data-target="#produkModal">
                                    <i class="typcn typcn-edit"></i>
                                </button>
                                <form action="{{ route('produk.destroy', $produk->id) }}" method="POST" class="d-inline"
                                    onsubmit="return confirm('Hapus produk ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-sm btn-danger"><i class="typcn typcn-trash"></i></button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-12 text-center text-muted py-5">
                    <i class="typcn typcn-th-large" style="font-size:3rem;"></i>
                    <p class="mt-2">Belum ada produk</p>
                </div>
            @endforelse
        </div>
    </div>

    @includeIf('produk.modal')
@endsection

@push('scripts')
    <script>
        $('.btn-edit').click(function() {
            $('#produkForm').attr('action', '{{ url('kasir/produk') }}/' + $(this).data('id'));
            $('#formMethod').val('PUT');

            $('#kategori_id').val($(this).data('kategori'));
            $('#nama_produk').val($(this).data('nama'));
            $('#harga_sewa').val($(this).data('harga'));
            $('#denda').val($(this).data('denda'));
            $('#status').val($(this).data('status'));
            $('#gambar').val('');
            $('#modalTitle').text('Edit Produk');
        });

        $('#produkModal').on('hidden.bs.modal', function() {
            $('#produkForm').attr('action', '{{ route('produk.store') }}');
            $('#formMethod').val('POST');
            $('#produkForm')[0].reset();
            $('#modalTitle').text('Tambah Produk');
            $('#kategori_id').val(null).trigger('change'); // reset select2
        });

        $('#searchProduk').on('keyup', function() {
            var value = $(this).val().toLowerCase();
            $('.row > .col-md-4').filter(function() {
                $(this).toggle($(this).find('.card-title').text().toLowerCase().indexOf(value) > -1 ||
                    $(this).find('p').first().text().toLowerCase().indexOf(value) > -1);
            });
        });
        $('#kategori_id').select2({
            dropdownParent: $('#produkModal'), // biar dropdown muncul di modal
            width: '100%',
            placeholder: '-- Pilih Kategori --'
        });
    </script>
@endpush
