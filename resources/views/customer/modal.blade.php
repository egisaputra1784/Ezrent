<div class="modal fade" id="customerModal" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <form method="POST" id="customerForm">
            @csrf
            <input type="hidden" name="_method" id="formMethod">

            <div class="modal-content">
                {{-- HEADER --}}
                <div class="modal-header d-flex align-items-center">
                    <h5 class="modal-title" id="modalTitle">
                        <i class="typcn typcn-user-add mr-2 text-primary"></i> Tambah Customer
                    </h5>
                    <button type="button" class="close" data-dismiss="modal">
                        <span aria-hidden="true" style="font-size: 1.5rem;">&times;</span>
                    </button>
                </div>

                {{-- BODY --}}
                <div class="modal-body">
                    <div class="row">

                        {{-- Nama Customer --}}
                        <div class="col-md-12 mb-3">
                            <label class="form-label">Nama Customer</label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text">
                                        <i class="typcn typcn-user"></i>
                                    </span>
                                </div>
                                <input type="text" name="nama" id="nama" class="form-control"
                                    placeholder="Nama Customer" required>
                            </div>
                        </div>

                        {{-- No HP --}}
                        <div class="col-md-12 mb-3">
                            <label class="form-label">No HP</label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text">
                                        <i class="typcn typcn-phone"></i>
                                    </span>
                                </div>
                                <input type="text" name="no_hp" id="no_hp" class="form-control"
                                    placeholder="No HP" required>
                            </div>
                        </div>

                        {{-- Alamat --}}
                        <div class="col-md-12 mb-4">
                            <label class="form-label">Alamat</label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text">
                                        <i class="typcn typcn-location"></i>
                                    </span>
                                </div>
                                <textarea name="alamat" id="alamat" class="form-control" placeholder="Alamat Customer" required></textarea>
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
