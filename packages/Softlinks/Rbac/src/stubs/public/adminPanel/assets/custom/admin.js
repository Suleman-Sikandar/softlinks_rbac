$(document).ready(function () {

    const drawerEl = document.getElementById('addUserDrawer');
    const drawer = new bootstrap.Offcanvas(drawerEl);

    $('.addUserBtn').on('click', function (e) {
        e.preventDefault();
        drawer.show();
    });

    // Initialize Select2 when drawer is shown
    $('#addUserDrawer').on('shown.bs.offcanvas', function () {
        $('#addUserDrawer .select2').select2({
            dropdownParent: $('#addUserDrawer'),
            width: '100%'
        });
    });

    // Add User Form Submission
    $('#addUserForm').on('submit', function (e) {
        e.preventDefault();

        let formData = new FormData(this);

        $.ajax({
            method: 'POST',
            url: '/acl/users/add',
            data: formData,
            processData: false,
            contentType: false,
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            beforeSend: function () {
                showLoader('Saving User...', 'Please wait');
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

    // Delete User AJAX
    $('.deleteUserBtn').on('click', function (e) {
        e.preventDefault();
        let userId = $(this).data('id');

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
                    url: '/acl/users/delete/' + userId,
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    beforeSend: function () {
                        showLoader('Deleting User...', 'Please wait');
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

    // Edit User AJAX
    $('.editUserBtn').on('click', function (e) {
        e.preventDefault();
        let userId = $(this).data('id');

        $.ajax({
            method: 'GET',
            url: '/acl/users/edit/' + userId,
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            beforeSend: function () {
                showLoader('Fetching Data...', 'Please wait');
            },
            success: function (response) {
                if (response.success) {
                    Swal.close();
                    $('#editUserDrawerContainer').html(response.html);

                    const drawerEl = document.getElementById('editUserDrawer');
                    const drawer = new bootstrap.Offcanvas(drawerEl);
                    drawer.show();

                    // Initialize Select2 for edit drawer
                    $('#editUserDrawer').on('shown.bs.offcanvas', function () {
                        $('#editUserDrawer .select2').select2({
                            dropdownParent: $('#editUserDrawer'),
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

    // Update User Form Submission (Delegated)
    $(document).on('submit', '#editUserForm', function (e) {
        e.preventDefault();

        let formData = new FormData(this);
        let userId = $('#edit_user_id').val();

        $.ajax({
            method: 'POST',
            url: '/acl/users/update/' + userId,
            data: formData,
            processData: false,
            contentType: false,
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            beforeSend: function () {
                showLoader('Updating User...', 'Please wait');
            },
            success: function (response) {
                if (response.success) {
                    showSuccess(response.message);

                    const drawerEl = document.getElementById('editUserDrawer');
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

    // Reset Add User form when drawer is closed
    $('#addUserDrawer').on('hidden.bs.offcanvas', function () {
        $('#addUserDrawer .select2').select2('destroy');
        $(this).find('form')[0].reset();
    });

});
