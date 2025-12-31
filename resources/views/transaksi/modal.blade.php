<div class="modal fade" id="transaksiModal" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <form method="POST" action="{{ route('transaksi.store') }}" id="transaksiForm">
            @csrf
            <div class="modal-content">

                {{-- HEADER --}}
                <div class="modal-header d-flex align-items-center">
                    <h5 class="modal-title">
                        <i class="typcn typcn-shopping-cart mr-2 text-primary"></i> Tambah Transaksi
                    </h5>
                    <button type="button" class="close" data-dismiss="modal">
                        <span aria-hidden="true" style="font-size: 1.5rem;">&times;</span>
                    </button>
                </div>

                {{-- BODY --}}
                <div class="modal-body">
                    <div class="row">

                        {{-- Customer --}}
                        <div class="col-md-12 mb-3">
                            <label>Customer</label>
                            <select name="customer_id" class="form-control" required>
                                <option value="">-- Pilih Customer --</option>
                                @foreach ($customers as $c)
                                    <option value="{{ $c->id }}">{{ $c->nama }}</option>
                                @endforeach
                            </select>
                        </div>

                        {{-- Produk --}}
                        <div class="col-md-12 mb-3">
                            <label>Produk</label>
                            <select name="produk_id" class="form-control" required>
                                <option value="">-- Pilih Produk --</option>
                                @foreach ($produks as $p)
                                    <option value="{{ $p->id }}" data-harga="{{ $p->harga_sewa }}">
                                        {{ $p->nama_produk }} (Rp {{ number_format($p->harga_sewa, 0, ',', '.') }})
                                    </option>
                                @endforeach

                            </select>
                        </div>

                        {{-- Harga Sewa --}}
                        <div class="col-md-12 mb-3">
                            <label>Harga Sewa</label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text"><i class="typcn typcn-credit-card"></i></span>
                                </div>
                                <input type="number" name="harga" class="form-control" required>
                            </div>
                        </div>

                        {{-- Tanggal Sewa & Kembali --}}
                        <div class="col-md-6 mb-3">
                            <label>Tanggal Sewa</label>
                            <input type="date" name="tanggal_sewa" class="form-control" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label>Tanggal Kembali</label>
                            <input type="date" name="tanggal_kembali" class="form-control" required>
                        </div>

                        {{-- Status --}}
                        <div class="col-md-12 mb-3">
                            <label>Status</label>
                            <select name="status" class="form-control">
                                <option value="aktif">Aktif</option>
                                <option value="selesai">Selesai</option>
                                <option value="terlambat">Terlambat</option>
                            </select>
                        </div>

                        <hr>

                        {{-- Jaminan --}}
                        <div class="col-md-12 mb-3">
                            <h6><i class="typcn typcn-lock-closed mr-1"></i> Jaminan (Opsional)</h6>
                        </div>

                        <div class="col-md-12 mb-3">
                            <label>Tipe Jaminan</label>
                            <select name="jaminan_tipe" class="form-control" id="jaminan_tipe">
                                <option value="">-- Tidak Ada --</option>
                                <option value="uang">Uang</option>
                                <option value="identitas">Identitas</option>
                            </select>
                        </div>

                        <div class="col-md-12 mb-3" id="jaminan_uang" style="display:none;">
                            <label>Nominal DP</label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text"><i class="typcn typcn-credit-card"></i></span>
                                </div>
                                <input type="number" name="jaminan_nilai" class="form-control">
                            </div>
                        </div>

                        <div class="col-md-12 mb-3" id="jaminan_identitas" style="display:none;">
                            <label>Detail Identitas (KTP, SIM, dsb.)</label>
                            <textarea name="jaminan_detail" class="form-control"></textarea>
                        </div>

                    </div>

                    {{-- BUTTON SIMPAN --}}
                    <button type="submit" class="btn btn-primary btn-block">
                        <i class="typcn typcn-database mr-1"></i> Simpan
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>
