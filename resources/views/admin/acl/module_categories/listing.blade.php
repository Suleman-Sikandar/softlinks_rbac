@extends('admin.layout.app')
@section('navbar')
    @include('admin.includes.navbar')
@endsection
@section('sidebar')
    @include('admin.includes.sidebar')
@endsection
@section('content')
    <div class="container-xxl flex-grow-1 container-p-y pt-2">
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
                    <div>
                        @if (validatePermissions('acl/module-categories/add'))
                            <button type="button" class="btn btn-primary btn-lg shadow-sm addModuleCategoryBtn">
                                <i class="bx bx-plus me-1"></i>Add Module Category
                            </button>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-12">
            <div class="card shadow-none border-0 bg-white">
                <div
                    class="card-header d-flex justify-content-between align-items-center flex-wrap gap-3 pb-3 bg-white border-0">
                    <h5 class="mb-0 fw-bold text-dark">
                        <i class="me-2 text-primary"></i>{{ $pageTitle }}
                    </h5>
                    <div class="d-flex align-items-center gap-3">
                        <div class="input-group input-group-merge" style="width: 280px;">
                            <span class="input-group-text border-light bg-light"><i
                                    class="bx bx-search fs-5 text-muted"></i></span>
                            <input type="text" class="form-control border-light bg-light ps-0" id="rolesTableSearch"
                                placeholder="Search roles...">
                        </div>

                    </div>
                </div>
                <div class="card-body pt-0 bg-white">
                    <div class="table-responsive">
                        <table id="rolesTable" class="table table-hover border-top-0">
                            <thead>
                                <tr class="bg-white">
                                    <th class="border-bottom-1 text-uppercase text-muted small fw-bold"
                                        style="width: 50px;">#</th>
                                    <th class="border-bottom-1 text-uppercase text-muted small fw-bold text-center">Category
                                        Name</th>
                                    <th class="border-bottom-1 text-uppercase text-muted small fw-bold text-center">Display
                                        Order</th>
                                    <th class="border-bottom-1 text-uppercase text-muted small fw-bold text-center">Css
                                        Class</th>
                                    <th class="border-bottom-1 text-uppercase text-muted small fw-bold text-center">Created
                                        At</th>
                                    <th class="border-bottom-1 text-uppercase text-muted small fw-bold text-center">Actions
                                    </th>
                                </tr>
                            </thead>
                            <tbody class="table-border-bottom-0">
                                @foreach ($moduleCategories as $moduleCategory)
                                    <tr>
                                        <td class="text-center">{{ $loop->iteration }}</td>
                                        <td class="text-center">{{ $moduleCategory->category_name }}</td>
                                        <td class="text-center">{{ $moduleCategory->display_order }}</td>
                                        <td class="text-center">{{ $moduleCategory->css_class }}</td>
                                        <td class="text-center">{{ $moduleCategory->created_at->format('Y-m-d') }}</td>
                                        <td class="text-center">
                                            @if (validatePermissions('acl/module-categories/edit/{id}'))
                                                <button class="btn btn-sm btn-primary editModuleCategoryBtn"
                                                    data-id="{{ $moduleCategory->id }}">
                                                    <i class="bx bx-edit-alt"></i>
                                                </button>
                                            @endif
                                            @if (validatePermissions('acl/module-categories/delete/{id}'))
                                                <button class="btn btn-sm btn-danger deleteModuleCategoryBtn"
                                                    data-id="{{ $moduleCategory->id }}">
                                                    <i class="bx bx-trash"></i>
                                                </button>
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @include('admin.acl.module_categories.add')
    <div id="editModuleCategoryDrawerContainer"></div>
@endsection
@section('footer')
    @include('admin.includes.footer')
@endsection
@section('scripts')
    <script src="{{ asset('adminPanel/assets/custom/module_categories.js') }}"></script>
@endsection
