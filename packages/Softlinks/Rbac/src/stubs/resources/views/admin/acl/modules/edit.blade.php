<div class="offcanvas offcanvas-end role-drawer" tabindex="-1" id="editModuleDrawer"
    aria-labelledby="editModuleDrawerLabel">
    
    <div class="offcanvas-header border-bottom">
        <h5 class="offcanvas-title fw-bold" id="editModuleDrawerLabel">
            <i class="bx bx-edit-alt me-2 text-primary"></i>Edit Module
        </h5>
        <button type="button" class="btn-close" data-bs-dismiss="offcanvas"></button>
    </div>

    <div class="offcanvas-body">
        <form id="editModuleForm">
            <input type="hidden" name="module_id" id="edit_module_id" value="{{ $module->id }}">

            <div class="row">

                <!-- Module Category -->
                <div class="col-md-12 mb-3">
                    <label class="form-label fw-semibold">Module Category</label>
                    <div class="input-group">
                        <select name="module_category_id" id="edit_module_category_id" class="form-select select2" data-placeholder="Select Category">
                            <option value="">Select Category</option>
                            @foreach ($categories as $category)
                                <option value="{{ $category->id }}" 
                                    {{ $module->module_category_id == $category->id ? 'selected' : '' }}>
                                    {{ $category->category_name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <!-- Module Name -->
                <div class="col-md-12 mb-3">
                    <label class="form-label fw-semibold">Module Name</label>
                    <input type="text" name="module_name" id="edit_module_name" class="form-control"
                        placeholder="e.g. User Management" value="{{ $module->module_name }}">
                </div>

                <!-- Display Order -->
                <div class="col-md-6 mb-3">
                    <label class="form-label fw-semibold">Display Order</label>
                    <input type="number" min="1" name="display_order" id="edit_display_order" class="form-control"
                        placeholder="e.g. 1" value="{{ $module->display_order }}">
                </div>

                <!-- CSS Class -->
                <div class="col-md-6 mb-3">
                    <label class="form-label fw-semibold">CSS Class</label>
                    <input type="text" name="css_class" id="edit_css_class" class="form-control"
                        placeholder="e.g. bx bx-user" value="{{ $module->css_class }}">
                </div>

                <!-- Slug -->
                <div class="col-md-6 mb-3">
                    <label class="form-label fw-semibold">Slug</label>
                    <input type="text" name="route" id="edit_slug" class="form-control"
                        placeholder="e.g. user-management" value="{{ $module->route }}">
                </div>

                <!-- Show in Menu -->
                <div class="col-md-6 mb-3">
                    <label class="form-label fw-semibold">Show In Menu</label>
                    <select name="show_in_menu" id="edit_show_in_menu" class="form-select">
                        <option value="1" {{ $module->show_in_menu ? 'selected' : '' }}>Yes</option>
                        <option value="0" {{ !$module->show_in_menu ? 'selected' : '' }}>No</option>
                    </select>
                </div>

            </div>

            <div class="d-flex justify-content-end gap-2 pt-3">
                <button type="button" class="btn btn-light" data-bs-dismiss="offcanvas">Cancel</button>
                <button type="submit" class="btn btn-primary px-4">
                    <i class="bx bx-save me-1"></i>Update Module
                </button>
            </div>
        </form>
    </div>
</div>
