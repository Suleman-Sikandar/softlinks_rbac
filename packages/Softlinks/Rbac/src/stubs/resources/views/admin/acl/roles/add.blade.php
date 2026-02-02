<div class="offcanvas offcanvas-end role-drawer" tabindex="-1" id="addRoleDrawer" aria-labelledby="addRoleDrawerLabel">
    <div class="offcanvas-header border-bottom">
        <h5 class="offcanvas-title fw-bold" id="addRoleDrawerLabel">
            <i class="bx bx-plus-circle me-2 text-primary"></i>Add Role
        </h5>
        <button type="button" class="btn-close" data-bs-dismiss="offcanvas"></button>
    </div>

    <div class="offcanvas-body">
        <form id="addRoleForm">
            <div class="row">
                <div class="col-md-12 mb-3">
                    <label class="form-label fw-semibold">Role Name</label>
                    <input type="text" name="role_name" class="form-control" placeholder="e.g. super_admin">
                </div>

                <div class="col-md-12 mb-3">
                    <label class="form-label fw-semibold">Display Order</label>
                    <input type="number" min="1" name="display_order" class="form-control" placeholder="e.g. 1">
                </div>
            </div>

            <div class="d-flex justify-content-end gap-2 pt-3">
                <button type="button" class="btn btn-light" data-bs-dismiss="offcanvas">Cancel</button>
                <button type="submit" class="btn btn-primary px-4">
                    <i class="bx bx-save me-1"></i>Save Role
                </button>
            </div>
        </form>
    </div>
</div>
