<div class="modal fade" id="ownerModal" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <form method="POST" id="ownerForm">
            @csrf
            <input type="hidden" name="_method" id="formMethod">

            <div class="modal-content">
                <div class="modal-header d-flex align-items-center">
                    <h5 class="modal-title" id="modalTitle">
                        <i class="typcn typcn-briefcase mr-2 text-primary"></i> Tambah Owner
                    </h5>
                    <button type="button" class="close" data-dismiss="modal">
                        <span aria-hidden="true" style="font-size: 1.5rem;">&times;</span>
                    </button>
                </div>

                <div class="modal-body">
                    <div class="row">

                        {{-- Nama Usaha --}}
                        <div class="col-md-12 mb-3">
                            <label class="form-label">Nama Usaha</label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text">
                                        <i class="typcn typcn-building"></i>
                                    </span>
                                </div>
                                <input type="text" name="nama_usaha" id="nama_usaha" class="form-control"
                                    placeholder="Nama usaha" required>
                            </div>
                        </div>

                        {{-- Expired --}}
                        <div class="col-md-12 mb-3">
                            <label class="form-label">Expired At</label>
                            <input type="date" name="expired_at" id="expired_at" class="form-control" required>
                        </div>

                        {{-- Status --}}
                        <div class="col-md-12 mb-4">
                            <label class="form-label">Status</label>
                            <select name="status" id="status" class="form-control" required>
                                <option value="aktif">Aktif</option>
                                <option value="nonaktif">Nonaktif</option>
                            </select>
                        </div>

                    </div>

                    <button type="submit" class="btn btn-primary btn-block">
                        <i class="typcn typcn-database mr-1"></i> Simpan
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>
