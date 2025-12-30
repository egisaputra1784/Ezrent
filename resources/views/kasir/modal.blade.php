<div class="modal fade" id="userKasirModal" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <form method="POST" id="userKasirForm">
            @csrf
            <input type="hidden" name="_method" id="formMethod">

            <div class="modal-content">
                {{-- HEADER --}}
                <div class="modal-header d-flex align-items-center">
                    <h5 class="modal-title" id="modalTitle">
                        <i class="typcn typcn-user-add mr-2 text-primary"></i> Tambah User Kasir
                    </h5>
                    <button type="button" class="close" data-dismiss="modal">
                        <span aria-hidden="true" style="font-size: 1.5rem;">&times;</span>
                    </button>
                </div>

                {{-- BODY --}}
                <div class="modal-body">
                    <div class="row">

                        {{-- Nama --}}
                        <div class="col-md-12 mb-3">
                            <label class="form-label">Nama</label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text">
                                        <i class="typcn typcn-user"></i>
                                    </span>
                                </div>
                                <input type="text" name="nama" id="nama" class="form-control"
                                    placeholder="Nama Kasir" required>
                            </div>
                        </div>

                        {{-- Email --}}
                        <div class="col-md-12 mb-3">
                            <label class="form-label">Email</label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text">
                                        <i class="typcn typcn-mail"></i>
                                    </span>
                                </div>
                                <input type="email" name="email" id="email" class="form-control"
                                    placeholder="Email" required>
                            </div>
                        </div>

                        {{-- Password --}}
                        <div class="col-md-12 mb-3">
                            <label class="form-label">Password <small>(isi jika ingin mengganti)</small></label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text">
                                        <i class="typcn typcn-key-outline"></i>
                                    </span>
                                </div>
                                <input type="password" name="password" id="password" class="form-control"
                                    placeholder="Password">
                            </div>
                        </div>

                        {{-- No HP --}}
                        <div class="col-md-12 mb-4">
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
