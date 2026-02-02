<div class="offcanvas offcanvas-end role-drawer" tabindex="-1" id="editUserDrawer" aria-labelledby="editUserDrawerLabel">

    <div class="offcanvas-header border-bottom">
        <h5 class="offcanvas-title fw-bold" id="editUserDrawerLabel">
            <i class="bx bx-edit-alt me-2 text-primary"></i>Edit Admin User
        </h5>
        <button type="button" class="btn-close" data-bs-dismiss="offcanvas"></button>
    </div>

    <div class="offcanvas-body">
        <form id="editUserForm">
            @csrf
            <input type="hidden" name="user_id" id="edit_user_id" value="{{ $user->id }}">

            <div class="row">

                {{-- User Name --}}
                <div class="col-md-12 mb-3">
                    <label class="form-label fw-semibold">User Name</label>
                    <input type="text" name="user_name" id="edit_user_name" class="form-control"
                        placeholder="e.g. admin_01" value="{{ $user->user_name }}">
                </div>

                {{-- Password (Optional) --}}
                <div class="col-md-12 mb-3">
                    <label class="form-label fw-semibold">
                        Password
                        <small class="text-muted">(Leave blank to keep current)</small>
                    </label>
                    <input type="password" name="password" id="edit_password" class="form-control"
                        placeholder="Enter new password">
                </div>

                {{-- Roles --}}
                <div class="col-md-12 mb-3">
                    <label class="form-label fw-semibold">Roles</label>
                    <div class="input-group">
                        <select class="form-select select2" name="roles[]" multiple="multiple"
                            data-placeholder="Select Role">
                            @foreach ($roles as $role)
                                <option value="{{ $role->id }}"
                                    {{ in_array($role->id, $userRoleIds) ? 'selected' : '' }}>
                                    {{ $role->role_name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>

                {{-- Status --}}
                <div class="col-md-12 mb-3">
                    <label class="form-label fw-semibold">Status</label>
                    <select name="is_active" id="edit_is_active" class="form-select">
                        <option value="1" {{ $user->is_active ? 'selected' : '' }}>Active</option>
                        <option value="0" {{ !$user->is_active ? 'selected' : '' }}>Inactive</option>
                    </select>
                </div>

            </div>

            <div class="d-flex justify-content-end gap-2 pt-3">
                <button type="button" class="btn btn-light" data-bs-dismiss="offcanvas">
                    Cancel
                </button>
                <button type="submit" class="btn btn-primary px-4">
                    <i class="bx bx-save me-1"></i>Update User
                </button>
            </div>
        </form>
    </div>
</div>
