@extends('admin.layout.app')

@section('sidebar')
    @include('admin.includes.sideBar')
@endsection
@section('navbar')
    @include('admin.includes.navBar')
@endsection
@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="row">
            <div class="col-12">
                <div class="d-flex align-items-center justify-content-between py-1">
                    <div>
                        <h4 class="fw-bold mb-0">{{ $pageTitle }}</h4>
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb mb-0">
                                <li class="breadcrumb-item text-muted">
                                    {{ $parentTitle ?? 'Dashboard' }}
                                </li>
                                <li class="breadcrumb-item active" aria-current="page">
                                    {{ $subTitle }}
                                </li>
                            </ol>
                        </nav>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">

            <!-- BIG CARD : TOTAL DOWNLOADER -->
            <div class="col-12 col-lg-8 order-2 order-md-3 order-lg-2 mb-4">
                <div class="card">
                    <div class="row row-bordered g-0">
                        <div class="col-md-8">
                            <h5 class="card-header m-0 me-2 pb-3">Total Downloader</h5>
                            <div id="totalRevenueChart" class="px-2"></div>
                        </div>
                        <div class="col-md-4">
                            <div class="card-body">
                                <div class="text-center">

                                </div>
                            </div>
                            <div id="growthChart"></div>
                            <div class="text-center fw-semibold pt-3 mb-2">62% Package Growth</div>

                            <div class="d-flex px-xxl-4 px-lg-2 p-4 gap-xxl-3 gap-lg-1 gap-3 justify-content-between">
                                <div class="d-flex">
                                    <div class="me-2">
                                        <span class="badge bg-label-primary p-2"><i
                                                class="bx bx-dollar text-primary"></i></span>
                                    </div>
                                    <div class="d-flex flex-column">
                                        <small>2022</small>
                                        <h6 class="mb-0">$32.5k</h6>
                                    </div>
                                </div>
                                <div class="d-flex">
                                    <div class="me-2">
                                        <span class="badge bg-label-info p-2"><i class="bx bx-wallet text-info"></i></span>
                                    </div>
                                    <div class="d-flex flex-column">
                                        <small>2021</small>
                                        <h6 class="mb-0">$41.2k</h6>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- SMALL CARDS -->
            <div class="col-lg-4">
                <div class="row">

                    <!-- SMALL CARD 1 -->
                    <div class="col-6 mb-4">
                        <div class="card">
                            <div class="card-body text-center">
                                <span class="badge bg-label-info mb-2">
                                    <i class="bx bx-user"></i>
                                </span>
                                <h4 class="mb-1">{{ $users }}</h4>
                                <small class="text-muted">Active Users</small>
                            </div>
                        </div>
                    </div>

                    <!-- SMALL CARD 2 -->
                    <div class="col-6 mb-4">
                        <div class="card">
                            <div class="card-body text-center">
                                <span class="badge bg-label-success mb-2">
                                    <i class="bx bx-shield"></i>
                                </span>
                                <h4 class="mb-1">{{ $roles }}</h4>
                                <small class="text-muted">Roles</small>
                            </div>
                        </div>
                    </div>

                    <!-- SMALL CARD 3 -->
                    <div class="col-6 mb-4">
                        <div class="card">
                            <div class="card-body text-center">
                                <span class="badge bg-label-warning mb-2">
                                    <i class="bx bx-lock"></i>
                                </span>
                                <h4 class="mb-1">{{ $permissions }}</h4>
                                <small class="text-muted">Permissions</small>
                            </div>
                        </div>
                    </div>

                    <!-- SMALL CARD 4 -->
                    <div class="col-6 mb-4">
                        <div class="card">
                            <div class="card-body text-center">
                                <span class="badge bg-label-danger mb-2">
                                    <i class="bx bx-history"></i>
                                </span>
                                <h4 class="mb-1">1,284</h4>
                                <small class="text-muted">Access Logs</small>
                            </div>
                        </div>
                    </div>

                </div>
            </div>

        </div>
    </div>
@endsection
@section('footer')
    @include('admin.includes.footer')
@endsection
