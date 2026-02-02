<div class="offcanvas offcanvas-end role-drawer" tabindex="-1" id="editModuleCategoryDrawer"
    aria-labelledby="editModuleCategoryDrawerLabel">
    <div class="offcanvas-header border-bottom">
        <h5 class="offcanvas-title fw-bold" id="editModuleCategoryDrawerLabel">
            <i class="bx bx-edit-alt me-2 text-primary"></i>Edit Module Category
        </h5>
        <button type="button" class="btn-close" data-bs-dismiss="offcanvas"></button>
    </div>

    <div class="offcanvas-body">
        <form id="editModuleCategoryForm">
            <input type="hidden" name="category_id" id="edit_category_id" value="{{ $category->id }}">

            <div class="row">
                <div class="col-md-12 mb-3">
                    <label class="form-label fw-semibold">Category Name</label>
                    <input type="text" name="category_name" id="edit_category_name" class="form-control"
                        placeholder="e.g. User Management" value="{{ $category->category_name }}">
                </div>

                <div class="col-md-12 mb-3">
                    <label class="form-label fw-semibold">CSS Class</label>
                    <input type="text" name="css_class" id="edit_css_class" class="form-control"
                        placeholder="e.g. bg-primary" value="{{ $category->css_class }}">
                </div>

                <div class="col-md-12 mb-3">
                    <label class="form-label fw-semibold">Display Order</label>
                    <input type="number" min="1" name="display_order" id="edit_display_order"
                        class="form-control" placeholder="e.g. 1" value="{{ $category->display_order }}">
                </div>
            </div>

            <div class="d-flex justify-content-end gap-2 pt-3">
                <button type="button" class="btn btn-light" data-bs-dismiss="offcanvas">Cancel</button>
                <button type="submit" class="btn btn-primary px-4">
                    <i class="bx bx-save me-1"></i>Update Category
                </button>
            </div>
        </form>
    </div>
</div>
