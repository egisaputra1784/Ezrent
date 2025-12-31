<div class="modal fade" id="kategoriModal" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <form method="POST" id="kategoriForm">
            @csrf
            <input type="hidden" name="_method" id="formMethod">

            <div class="modal-content">
                {{-- HEADER --}}
                <div class="modal-header d-flex align-items-center">
                    <h5 class="modal-title" id="modalTitle">
                        <i class="typcn typcn-tag mr-2 text-primary"></i> Tambah Kategori
                    </h5>
                    <button type="button" class="close" data-dismiss="modal">
                        <span aria-hidden="true" style="font-size: 1.5rem;">&times;</span>
                    </button>
                </div>

                {{-- BODY --}}
                <div class="modal-body">
                    <div class="form-group">
                        <label>Nama Kategori</label>
                        <input type="text" name="nama_kategori" id="nama_kategori" class="form-control"
                            placeholder="Nama Kategori" required>
                    </div>

                    <button type="submit" class="btn btn-primary btn-block">
                        <i class="typcn typcn-database mr-1"></i> Simpan
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>
