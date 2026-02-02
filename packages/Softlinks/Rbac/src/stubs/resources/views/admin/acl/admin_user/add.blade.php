<div class="offcanvas offcanvas-end role-drawer" tabindex="-1" id="addUserDrawer" aria-labelledby="addUserDrawerLabel">

    <div class="offcanvas-header border-bottom">
        <h5 class="offcanvas-title fw-bold" id="addUserDrawerLabel">
            <i class="bx bx-user-plus me-2 text-primary"></i>Add Admin User
        </h5>
        <button type="button" class="btn-close" data-bs-dismiss="offcanvas"></button>
    </div>

    <div class="offcanvas-body">
        <form id="addUserForm">
            @csrf

            <div class="row">

                {{-- User Name --}}
                <div class="col-md-12 mb-3">
                    <label class="form-label fw-semibold">User Name</label>
                    <input type="text" name="user_name" class="form-control" placeholder="e.g. admin_01" required>
                </div>

                {{-- Password --}}
                <div class="col-md-12 mb-3">
                    <label class="form-label fw-semibold">Password</label>
                    <input type="password" name="password" class="form-control" placeholder="Enter password" required>
                </div>

                {{-- Roles --}}
                <div class="col-md-12 mb-3">
                    <label class="form-label fw-semibold">Roles</label>
                    <div class="input-group">
                        <select class="form-select select2" name="roles[]" multiple="multiple"
                            data-placeholder="Select Role">
                            @foreach ($roles as $role)
                                <option value="{{ $role->id }}">{{ $role->role_name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                {{-- Status --}}
                <div class="col-md-12 mb-3">
                    <label class="form-label fw-semibold">Status</label>
                    <select name="is_active" class="form-select">
                        <option value="1" selected>Active</option>
                        <option value="0">Inactive</option>
                    </select>
                </div>

            </div>

            <div class="d-flex justify-content-end gap-2 pt-3">
                <button type="button" class="btn btn-light" data-bs-dismiss="offcanvas">
                    Cancel
                </button>
                <button type="submit" class="btn btn-primary px-4">
                    <i class="bx bx-save me-1"></i>Save User
                </button>
            </div>
        </form>
    </div>
</div>
