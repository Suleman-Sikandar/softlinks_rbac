<!-- Core JS -->
<script src="{{ asset('adminPanel/assets/vendor/libs/jquery/jquery.js') }}"></script>
<script src="{{ asset('adminPanel/assets/vendor/libs/popper/popper.js') }}"></script>
<script src="{{ asset('adminPanel/assets/vendor/js/bootstrap.js') }}"></script>
<script src="{{ asset('adminPanel/assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.js') }}"></script>
<script src="{{ asset('adminPanel/assets/vendor/js/menu.js') }}"></script>

<!-- ✅ DataTables JS (IMPORTANT ORDER) -->
<script src="https://cdn.datatables.net/2.3.6/js/dataTables.min.js"></script>
<script src="https://cdn.datatables.net/2.3.6/js/dataTables.bootstrap5.min.js"></script>

<!-- Vendors -->
<script src="{{ asset('adminPanel/assets/vendor/libs/apex-charts/apexcharts.js') }}"></script>
<!-- Main JS -->
<script src="{{ asset('adminPanel/assets/js/main.js') }}"></script>
<script src="{{ asset('adminPanel/assets/js/dashboards-analytics.js') }}"></script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js" integrity="sha512-2ImtlRlf2VVmiGZsjm9bEyhjGW4dU7B6TNwh/hx/iSByxNENtj3WVE6o/9Lj4TJeVXPi4bnOIMXFIJJAeufa0A==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert2/11.23.0/sweetalert2.min.js" integrity="sha512-pnPZhx5S+z5FSVwy62gcyG2Mun8h6R+PG01MidzU+NGF06/ytcm2r6+AaWMBXAnDHsdHWtsxS0dH8FBKA84FlQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
@include('admin.includes.swalScript')
@yield('scripts')

<script>
    $(document).ready(function() {
        var table = $('#rolesTable').DataTable({
            pageLength: 10,
            order: [
                [1, 'asc']
            ],
            dom: 'rt<"row"<"col-12"p>>',
            language: {
                paginate: {
                    next: '<i class="bx bx-chevron-right"></i>',
                    previous: '<i class="bx bx-chevron-left"></i>'
                }
            }
        });
        $('#rolesTableSearch').on('keyup', function() {
            table.search(this.value).draw();
        });
    });

</script>
