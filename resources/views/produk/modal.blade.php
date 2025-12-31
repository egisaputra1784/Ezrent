<div class="modal fade" id="produkModal" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <form method="POST" id="produkForm" enctype="multipart/form-data">
            @csrf
            <input type="hidden" name="_method" id="formMethod">

            <div class="modal-content">
                {{-- HEADER --}}
                <div class="modal-header d-flex align-items-center">
                    <h5 class="modal-title" id="modalTitle">
                        <i class="typcn typcn-box mr-2 text-primary"></i> Tambah Produk
                    </h5>
                    <button type="button" class="close" data-dismiss="modal">
                        <span aria-hidden="true" style="font-size: 1.5rem;">&times;</span>
                    </button>
                </div>

                {{-- BODY --}}
                <div class="modal-body">
                    <div class="row">

                        {{-- Kategori --}}
                        <div class="col-md-12 mb-3">
                            <label class="form-label">Kategori</label>
                            <select name="kategori_id" id="kategori_id" class="form-control" required>
                                <option value="">-- Pilih Kategori --</option>
                                @foreach ($kategoris as $kategori)
                                    <option value="{{ $kategori->id }}">{{ $kategori->nama_kategori }}</option>
                                @endforeach
                            </select>
                        </div>

                        {{-- Nama Produk --}}
                        <div class="col-md-12 mb-3">
                            <label class="form-label">Nama Produk</label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text"><i class="typcn typcn-tags"></i></span>
                                </div>
                                <input type="text" name="nama_produk" id="nama_produk" class="form-control"
                                    placeholder="Nama Produk" required>
                            </div>
                        </div>

                        {{-- Harga Sewa --}}
                        <div class="col-md-12 mb-3">
                            <label class="form-label">Harga Sewa</label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text"><i class="typcn typcn-credit-card"></i></span>
                                </div>
                                <input type="number" name="harga_sewa" id="harga_sewa" class="form-control"
                                    placeholder="Harga Sewa" required>
                            </div>
                        </div>

                        {{-- Denda --}}
                        <div class="col-md-12 mb-3">
                            <label class="form-label">Denda</label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text"><i class="typcn typcn-warning-outline"></i></span>
                                </div>
                                <input type="number" name="denda" id="denda" class="form-control"
                                    placeholder="Denda" required>
                            </div>
                        </div>

                        {{-- Status --}}
                        <div class="col-md-12 mb-3">
                            <label class="form-label">Status</label>
                            <select name="status" id="status" class="form-control">
                                <option value="tersedia">Tersedia</option>
                                <option value="disewa">Disewa</option>
                            </select>
                        </div>

                        {{-- Gambar --}}
                        <div class="col-md-12 mb-4">
                            <label class="form-label">Gambar</label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text"><i class="typcn typcn-camera"></i></span>
                                </div>
                                <input type="file" name="gambar" id="gambar" class="form-control">
                            </div>
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
