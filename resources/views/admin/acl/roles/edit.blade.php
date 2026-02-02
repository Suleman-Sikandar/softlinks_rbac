@extends('admin.layout.app')

@section('navbar')
    @include('admin.includes.navbar')
@endsection

@section('sidebar')
    @include('admin.includes.sidebar')
@endsection

@section('content')
    <form action="{{ url('acl/roles/update', $role->id) }}" method="POST">
        @csrf
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
                            <button type="button" class="btn btn-primary btn-lg shadow-sm addRoleBtn">
                                <i class="bx bx-plus me-1"></i>Add Role
                            </button>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row mt-4">
                <div class="col-12 mb-4">
                    <div class="card permission-card shadow-sm border-0">
                        <div class="card-body p-4">
                            <div class="row align-items-center">
                                <div class="col-md-12">
                                    <label class="fw-bold mb-0">Role Name</label>
                                    <input type="text" class="form-control form-control-lg" name="role_name" 
                                    value="{{ $role->role_name }}">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-12 mb-3">
                    <h5 class="fw-bold text-dark mb-3">
                        <i class="me-2 text-primary"></i>Role Permissions
                    </h5>
                </div>

                <!-- Country by Country Reporting Module -->
                @foreach ($moduleCategories as $moduleCategory)
                    <div class="col-12 mb-4">
                        <div class="card permission-card shadow-sm border-0 overflow-hidden">
                            <div class="card-header permission-card-header">
                                <div class="d-flex justify-content-between align-items-center">
                                    <h6 class="fw-bold mb-0">{{ $moduleCategory->category_name }}</h6>
                                </div>
                            </div>
                            <div class="card-body p-4 bg-white">
                                <div class="row g-3">
                                    @foreach ($moduleCategory->modules as $module)
                                        <div class="col-md-4 col-lg-3">
                                            <div class="permission-item">
                                                <label class="form-check d-flex align-items-center">
                                                    <input class="form-check-input permission-checkbox" type="checkbox"
                                                        name="modules[]" value="{{ $module->id }}"
                                                        {{ in_array($module->id, $roleModuleIds ?? []) ? 'checked' : '' }}>

                                                    <span class="form-check-label ms-2">{{ $module->module_name }}</span>
                                                </label>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach

                <!-- Save Button -->
                <div class="row">
                    <div class="col-12">
                        <div class="d-flex justify-content-end gap-3 pb-4">
                            <button type="button" class="btn btn-light btn-lg px-5"
                                onclick="window.location.href='{{ url('acl/roles') }}'">
                                <i class="bx bx-x me-1"></i>Cancel
                            </button>
                            <button type="submit" class="btn btn-primary btn-lg px-5 shadow-sm updateRole">
                                <i class="bx bx-save me-1"></i>Save Changes
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
    @include('admin.acl.roles.add')
@endsection

@section('footer')
    @include('admin.includes.footer')
@endsection

@section('scripts')
    <script src="{{ asset('adminPanel/assets/custom/role.js') }}"></script>
@endsection
