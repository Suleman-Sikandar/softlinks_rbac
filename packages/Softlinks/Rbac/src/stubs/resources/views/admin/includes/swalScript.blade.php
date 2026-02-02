<script>
    function showLoader(title = 'Saving...', text = 'Please wait') {
        Swal.fire({
            title: title,
            text: text,
            allowOutsideClick: false,
            allowEscapeKey: false,
            didOpen: () => {
                Swal.showLoading();
            }
        });
    }

    function showSuccess(message) {
        Swal.fire({
            icon: 'success',
            title: 'Success',
            text: message,
            timer: 1500,
            showConfirmButton: false
        });
    }

    function showError(message) {
        Swal.fire({
            icon: 'error',
            title: 'Error',
            text: message
        });
    }
</script>

{{-- 🔥 THIS PART WAS MISSING --}}
@if (session()->has('success'))
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            @if (session('success') === true)
                showSuccess("{{ session('message') }}");
            @else
                showError("{{ session('message') }}");
            @endif
        });
    </script>
@endif
