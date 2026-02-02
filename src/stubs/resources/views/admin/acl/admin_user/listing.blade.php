@extends('admin.layout.app')

@section('navbar')
    @include('admin.includes.navbar')
@endsection

@section('sidebar')
    @include('admin.includes.sidebar')
@endsection

@section('content')
    <div class="container-xxl flex-grow-1 container-p-y pt-2">

        {{-- Page Header --}}
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
                                <li class="breadcrumb-item active">
                                    {{ $subTitle }}
                                </li>
                            </ol>
                        </nav>
                    </div>

                    <div>
                        @if (validatePermissions('acl/users/add'))
                            <button type="button" class="btn btn-primary btn-lg shadow-sm addUserBtn">
                                <i class="bx bx-plus me-1"></i>Add New Admin
                            </button>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
    {{-- Table --}}
    <div class="row">
        <div class="col-12">
            <div class="card shadow-none border-0 bg-white">
                <div
                    class="card-header d-flex justify-content-between align-items-center flex-wrap gap-3 pb-3 bg-white border-0">
                    <h5 class="mb-0 fw-bold text-dark">{{ $pageTitle }}</h5>

                    <div class="input-group input-group-merge" style="width: 280px;">
                        <span class="input-group-text border-light bg-light">
                            <i class="bx bx-search fs-5 text-muted"></i>
                        </span>
                        <input type="text" class="form-control border-light bg-light ps-0" id="rolesTableSearch"
                            placeholder="Search users...">
                    </div>
                </div>

                <div class="card-body pt-0 bg-white">
                    <div class="table-responsive">
                        <table id="rolesTable" class="table table-hover border-top-0">
                            <thead>
                                <tr>
                                    <th class="text-center" style="width: 50px;">#</th>
                                    <th class="text-center">User Name</th>
                                    <th class="text-center">User Roles</th>
                                    <th class="text-center">Status</th>
                                    <th class="text-center">Created At</th>
                                    <th class="text-center">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($users as $user)
                                    <tr>
                                        <td class="text-center">{{ $loop->iteration }}</td>
                                        <td class="text-center">{{ $user->user_name }}</td>
                                        <td class="text-center">
                                            @foreach ($user->roles as $role)
                                                <span class="badge bg-label-primary mb-1">{{ $role->role_name }}</span>
                                            @endforeach
                                        </td>
                                        <td class="text-center">
                                            <span class="badge bg-{{ $user->is_active ? 'success' : 'danger' }}">
                                                {{ $user->is_active ? 'Active' : 'Inactive' }}
                                            </span>
                                        </td>
                                        <td class="text-center">{{ $user->created_at->format('d M Y') }}</td>
                                        <td class="text-center">
                                            @if (validatePermissions('acl/users/edit/{id}'))
                                                <button class="btn btn-sm btn-primary editUserBtn"
                                                    data-id="{{ $user->id }}">
                                                    <i class="bx bx-edit-alt"></i>
                                                </button>
                                            @endif
                                            @if (validatePermissions('acl/users/delete/{id}'))
                                                <button class="btn btn-sm btn-danger deleteUserBtn"
                                                    data-id="{{ $user->id }}">
                                                    <i class="bx bx-trash"></i>
                                                </button>
                                            @endif
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="text-center text-muted">
                                            No admin users found
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>

            </div>
        </div>
    </div>

    </div>

    {{-- Drawers --}}
    @include('admin.acl.admin_user.add')
    <div id="editUserDrawerContainer"></div>
@endsection

@section('footer')
    @include('admin.includes.footer')
@endsection

@section('scripts')
    <script src="{{ asset('adminPanel/assets/custom/admin.js') }}"></script>
@endsection
