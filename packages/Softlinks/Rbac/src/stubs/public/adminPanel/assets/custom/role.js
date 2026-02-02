$(document).ready(function () {

    const drawerEl = document.getElementById('addRoleDrawer');
    const drawer = new bootstrap.Offcanvas(drawerEl);

    $('.addRoleBtn').on('click', function (e) {
        e.preventDefault();
        drawer.show();
    });
    // Add Role Form Submission
    $('#addRoleForm').on('submit', function (e) {
        e.preventDefault();

        let formData = new FormData(this);

        $.ajax({
            method: 'POST',
            url: '/acl/roles/add',
            data: formData,
            processData: false,
            contentType: false,
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            beforeSend: function () {
                showLoader('Saving Role...', 'Please wait');
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


    //Delete Role AJAX
    $('.deleteRoleBtn').on('click', function (e) {
        e.preventDefault();
        let roleId = $(this).data('id');
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
                    url: '/acl/roles/delete/' + roleId,
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    beforeSend: function () {
                        showLoader('Deleting Role...', 'Please wait');
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
    // Reset form when drawer is closed
    $('#addRoleDrawer').on('hidden.bs.offcanvas', function () {
        $(this).find('form')[0].reset();
    });

});
