<div class="modal fade" id="userModal" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <form method="POST" id="userForm">
            @csrf
            <input type="hidden" name="_method" id="formMethod">

            <div class="modal-content">
                <div class="modal-header d-flex align-items-center">
                    <h5 class="modal-title" id="modalTitle">
                        <i class="typcn typcn-user-add mr-2 text-primary"></i> Tambah User
                    </h5>
                    <button type="button" class="close" data-dismiss="modal">
                        <span aria-hidden="true" style="font-size: 1.5rem;">&times;</span>
                    </button>
                </div>

                <div class="modal-body">
                    <div class="row">

                        <div class="col-md-12 mb-3">
                            <label class="form-label">Nama Lengkap</label>
                            <div class="input-group has-icon">
                                <div class="input-group-prepend">
                                    <span class="input-group-text">
                                        <i class="typcn typcn-user"></i>
                                    </span>
                                </div>
                                <input type="text" name="nama" id="nama" class="form-control"
                                    placeholder="Masukkan nama" required>
                            </div>
                        </div>

                        <div class="col-md-12 mb-3">
                            <label class="form-label">Email</label>
                            <div class="input-group has-icon">
                                <div class="input-group-prepend">
                                    <span class="input-group-text">
                                        <i class="typcn typcn-mail"></i>
                                    </span>
                                </div>
                                <input type="email" name="email" id="email" class="form-control"
                                    placeholder="email@example.com" required>
                            </div>
                        </div>

                        <div class="col-md-12 mb-3 password-field">
                            <label class="form-label">Password</label>
                            <div class="input-group has-icon">
                                <div class="input-group-prepend">
                                    <span class="input-group-text">
                                        <i class="typcn typcn-lock-closed"></i>
                                    </span>
                                </div>
                                <input type="password" name="password" id="password" class="form-control"
                                    placeholder="Input password">
                            </div>
                        </div>

                        <div class="col-md-12 mb-3">
                            <label class="form-label">No HP</label>
                            <div class="input-group has-icon">
                                <div class="input-group-prepend">
                                    <span class="input-group-text">
                                        <i class="typcn typcn-phone"></i>
                                    </span>
                                </div>
                                <input type="text" name="no_hp" id="no_hp" class="form-control"
                                    placeholder="08xxxxxxxx" required>
                            </div>
                        </div>

                        <div class="col-md-12 mb-4">
                            <label class="form-label">Role</label>
                            <select name="role" id="role" class="form-control" required style="cursor:pointer;">
                                <option value="admin">Admin</option>
                                <option value="superadmin">Superadmin</option>
                            </select>
                        </div>

                    </div>

                    <button type="submit" class="btn btn-primary btn-block" id="btnSubmit">
                        <i class="typcn typcn-database mr-1"></i> Simpan
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>
