<head>
    <meta charset="utf-8" />
    <meta name="viewport"
        content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0" />


    <title>{{ config('app.name') }}</title>

    <!-- Favicon -->
    <link rel="icon" type="image/x-icon" href="{{ asset('adminPanel/assets/img/favicon/favicon.ico') }}" />
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link href="https://fonts.googleapis.com/css2?family=Public+Sans:wght@300;400;500;600;700&display=swap"
        rel="stylesheet" />

    <!-- Icons -->
    <link rel="stylesheet" href="{{ asset('adminPanel/assets/vendor/fonts/boxicons.css') }}" />

    <!-- Core CSS -->
    <link rel="stylesheet" href="{{ asset('adminPanel/assets/vendor/css/core.css') }}" />
    <link rel="stylesheet" href="{{ asset('adminPanel/assets/vendor/css/theme-default.css') }}" />
    <link rel="stylesheet" href="{{ asset('adminPanel/assets/css/demo.css') }}" />
    <link rel="stylesheet" href="{{ asset('adminPanel/assets/css/custom.css') }}" />

    <!-- Vendor CSS -->
    <link rel="stylesheet"
        href="{{ asset('adminPanel/assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.css') }}" />
    <link rel="stylesheet" href="{{ asset('adminPanel/assets/vendor/libs/apex-charts/apex-charts.css') }}" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/sweetalert2/11.23.0/sweetalert2.min.css" crossorigin="anonymous" referrerpolicy="no-referrer" />

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css" integrity="sha512-nMNlpuaDPrqlEls3IX/Q56H36qvBASwb3ipuo3MxeWbsQB1881ox0cRv7UPTgBlriqoynt35KjEwgGUeUXIPnw==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <!-- ✅ DataTables Bootstrap 5 CSS -->
    <link rel="stylesheet" href="https://cdn.datatables.net/2.3.6/css/dataTables.bootstrap5.min.css">

    <!-- Helpers -->
    <script src="{{ asset('adminPanel/assets/vendor/js/helpers.js') }}"></script>

    <!-- Theme Config -->
    <script src="{{ asset('adminPanel/assets/js/config.js') }}"></script>
</head>
