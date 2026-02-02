<!DOCTYPE html>

<html lang="en" class="light-style layout-menu-fixed" dir="ltr" data-theme="theme-default"
    data-assets-path="../assets/" data-template="vertical-menu-template-free">

@include('admin.includes.header')

<body>
    <div class="layout-wrapper layout-content-navbar">
        <div class="layout-container">
            @yield('sidebar')
            <div class="layout-page">
                @yield('navbar')
                <div class="content-wrapper">
                    <div class="container-xxl flex-grow-1 container-p-y">
                        @yield('content')
                        @include('admin.includes.swalScript')
                    </div>
                @yield('footer')
                </div>
            </div>
        </div>
    </div>
    @include('admin.includes.script')
</body>

</html>
