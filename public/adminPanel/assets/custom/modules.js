$(document).ready(function () {

    const drawerEl = document.getElementById('addModuleDrawer');
    const drawer = new bootstrap.Offcanvas(drawerEl);

    $('.addModuleBtn').on('click', function (e) {
        e.preventDefault();
        drawer.show();
    });

    // Initialize Select2 when drawer is shown
    $('#addModuleDrawer').on('shown.bs.offcanvas', function () {
        $('#addModuleDrawer .select2').select2({
            dropdownParent: $('#addModuleDrawer'),
            width: '100%'
        });
    });

    // Add Module Form Submission
    $('#addModuleForm').on('submit', function (e) {
        e.preventDefault();

        let formData = new FormData(this);

        $.ajax({
            method: 'POST',
            url: '/acl/modules/add',
            data: formData,
            processData: false,
            contentType: false,
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            beforeSend: function () {
                showLoader('Saving Module...', 'Please wait');
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


    // Delete Module AJAX
    $('.deleteModuleBtn').on('click', function (e) {
        e.preventDefault();
        let moduleId = $(this).data('id');
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
                    url: '/acl/modules/delete/' + moduleId,
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    beforeSend: function () {
                        showLoader('Deleting Module...', 'Please wait');
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

    // Edit Module AJAX
    $('.editModuleBtn').on('click', function (e) {
        e.preventDefault();
        let moduleId = $(this).data('id');
        $.ajax({
            method: 'GET',
            url: '/acl/modules/edit/' + moduleId,
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            beforeSend: function () {
                showLoader('Fetching Data...', 'Please wait');
            },
            success: function (response) {
                if (response.success) {
                    Swal.close();
                    $('#editModuleDrawerContainer').html(response.html);
                    const drawerEl = document.getElementById('editModuleDrawer');
                    const drawer = new bootstrap.Offcanvas(drawerEl);
                    drawer.show();

                    // Initialize Select2 for edit drawer after it's shown
                    $('#editModuleDrawer').on('shown.bs.offcanvas', function () {
                        $('#editModuleDrawer .select2').select2({
                            dropdownParent: $('#editModuleDrawer'),
                            width: '100%'
                        });
                    });
                } else {
                    showError(response.message);
                }
            },
            error: function (response) {
                showError(response.responseJSON.message || 'An unexpected error occurred.');
            }
        });
    });

    // Update Module Form Submission (Delegated event)
    $(document).on('submit', '#editModuleForm', function (e) {
        e.preventDefault();
        let formData = new FormData(this);
        let moduleId = $('#edit_module_id').val();
        $.ajax({
            method: 'POST',
            url: '/acl/modules/update/' + moduleId,
            data: formData,
            processData: false,
            contentType: false,
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            beforeSend: function () {
                showLoader('Updating Module...', 'Please wait');
            },
            success: function (response) {
                if (response.success) {
                    showSuccess(response.message);
                    const drawerEl = document.getElementById('editModuleDrawer');
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
    $('#addModuleDrawer').on('hidden.bs.offcanvas', function () {
        // Destroy Select2 before resetting form
        $('#addModuleDrawer .select2').select2('destroy');
        $(this).find('form')[0].reset();
    });

});
