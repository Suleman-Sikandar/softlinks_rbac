<div class="offcanvas offcanvas-end role-drawer" tabindex="-1" id="addModuleDrawer" aria-labelledby="addModuleDrawerLabel">

    <div class="offcanvas-header border-bottom">
        <h5 class="offcanvas-title fw-bold" id="addModuleDrawerLabel">
            <i class="bx bx-plus-circle me-2 text-primary"></i>Add Module
        </h5>
        <button type="button" class="btn-close" data-bs-dismiss="offcanvas"></button>
    </div>

    <div class="offcanvas-body">
        <form id="addModuleForm">
            <div class="row">

                <!-- Module Category -->
                <div class="col-md-12 mb-3">
                    <label class="form-label fw-semibold">Module Category</label>
                    <div class="input-group">
                        <select name="module_category_id" class="form-select select2" data-placeholder="Select Category">
                            <option value="">Select Category</option>
                            @foreach ($categories as $category)
                                <option value="{{ $category->id }}">
                                    {{ $category->category_name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <!-- Module Name -->
                <div class="col-md-12 mb-3">
                    <label class="form-label fw-semibold">Module Name</label>
                    <input type="text" name="module_name" class="form-control" placeholder="e.g. User Management">
                </div>

                <!-- Display Order -->
                <div class="col-md-6 mb-3">
                    <label class="form-label fw-semibold">Display Order</label>
                    <input type="number" min="1" name="display_order" class="form-control" placeholder="e.g. 1">
                </div>

                <!-- CSS Class -->
                <div class="col-md-6 mb-3">
                    <label class="form-label fw-semibold">CSS Class</label>
                    <input type="text" name="css_class" class="form-control" placeholder="e.g. bx bx-user">
                </div>

                <!-- Slug -->
                <div class="col-md-6 mb-3">
                    <label class="form-label fw-semibold">Slug</label>
                    <input type="text" name="route" class="form-control" placeholder="e.g. user-management">
                </div>

                <!-- Show in Menu -->
                <div class="col-md-6 mb-3">
                    <label class="form-label fw-semibold">Show In Menu</label>
                    <select name="show_in_menu" class="form-select">
                        <option value="1">Yes</option>
                        <option value="0">No</option>
                    </select>
                </div>

            </div>

            <div class="d-flex justify-content-end gap-2 pt-3">
                <button type="button" class="btn btn-light" data-bs-dismiss="offcanvas">
                    Cancel
                </button>
                <button type="submit" class="btn btn-primary px-4">
                    <i class="bx bx-save me-1"></i>Save Module
                </button>
            </div>
        </form>
    </div>
</div>
