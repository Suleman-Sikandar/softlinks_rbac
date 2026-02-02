$(document).ready(function () {

    const drawerEl = document.getElementById('addModuleCategoryDrawer');
    const drawer = new bootstrap.Offcanvas(drawerEl);

    $('.addModuleCategoryBtn').on('click', function (e) {
        e.preventDefault();
        drawer.show();
    });

    // Add Module Category Form Submission
    $('#addModuleCategoryForm').on('submit', function (e) {
        e.preventDefault();

        let formData = new FormData(this);

        $.ajax({
            method: 'POST',
            url: '/acl/module-categories/add',
            data: formData,
            processData: false,
            contentType: false,
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            beforeSend: function () {
                showLoader('Saving Category...', 'Please wait');
            },
            success: function (response) {
                if (response.success) {
                    showSuccess(response.message);
                    drawer.hide();
                    setTimeout(function () {
                        location.reload();
                    }, 1500);
                } else {
                    showError(response.message);
                }
            },
            error: function (response) {
                showError(response.responseJSON.message || 'An unexpected error occurred.');
            }
        });
    });


    // Delete Module Category AJAX
    $('.deleteModuleCategoryBtn').on('click', function (e) {
        e.preventDefault();
        let categoryId = $(this).data('id');
        Swal.fire({
            title: 'Are you sure?',
            text: "You won't be able to revert this!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, delete it!'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    method: 'DELETE',
                    url: '/acl/module-categories/delete/' + categoryId,
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    beforeSend: function () {
                        showLoader('Deleting Category...', 'Please wait');
                    },
                    success: function (response) {
                        if (response.success) {
                            showSuccess(response.message);
                            setTimeout(function () {
                                location.reload();
                            }, 1500);
                        } else {
                            showError(response.message);
                        }
                    },
                    error: function (response) {
                        showError(response.responseJSON.message || 'An unexpected error occurred.');
                    }
                });
            }
        });
    });

    // Edit Module Category AJAX
    $('.editModuleCategoryBtn').on('click', function (e) {
        e.preventDefault();
        let categoryId = $(this).data('id');
        $.ajax({
            method: 'GET',
            url: '/acl/module-categories/edit/' + categoryId,
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            beforeSend: function () {
                showLoader('Fetching Data...', 'Please wait');
            },
            success: function (response) {
                if (response.success) {
                    Swal.close();
                    $('#editModuleCategoryDrawerContainer').html(response.html);
                    const drawerEl = document.getElementById('editModuleCategoryDrawer');
                    const drawer = new bootstrap.Offcanvas(drawerEl);
                    drawer.show();
                } else {
                    showError(response.message);
                }
            },
            error: function (response) {
                showError(response.responseJSON.message || 'An unexpected error occurred.');
            }
        });
    });

    // Update Module Category Form Submission (Delegated event)
    $(document).on('submit', '#editModuleCategoryForm', function (e) {
        e.preventDefault();
        let formData = new FormData(this);
        let categoryId = $('#edit_category_id').val();
        $.ajax({
            method: 'POST',
            url: '/acl/module-categories/update/' + categoryId,
            data: formData,
            processData: false,
            contentType: false,
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            beforeSend: function () {
                showLoader('Updating Category...', 'Please wait');
            },
            success: function (response) {
                if (response.success) {
                    showSuccess(response.message);
                    const drawerEl = document.getElementById('editModuleCategoryDrawer');
                    const drawer = bootstrap.Offcanvas.getInstance(drawerEl);
                    if (drawer) drawer.hide();

                    setTimeout(function () {
                        location.reload();
                    }, 1500);
                } else {
                    showError(response.message);
                }
            },
            error: function (response) {
                showError(response.responseJSON.message || 'An unexpected error occurred.');
            }
        });
    });

    // Reset form when drawer is closed
    $('#addModuleCategoryDrawer').on('hidden.bs.offcanvas', function () {
        $(this).find('form')[0].reset();
    });

});
