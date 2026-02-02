@php
    use Illuminate\Support\Facades\Auth;
    use App\Models\ACL\AdminRolePrivillege;
    use App\Models\ACL\ModuleCategory;
    use App\Models\ACL\ModuleRolePrivillege;

    // Logged-in admin roles
    $roleIds = AdminRolePrivillege::where(
        'admin_id',
        Auth::guard('admin')->user()->id
    )->pluck('role_id')->toArray();

    // All categories
    $categories = ModuleCategory::orderBy('display_order', 'ASC')->get();
@endphp

<aside id="layout-menu" class="layout-menu menu-vertical menu bg-menu-theme">

    <div class="app-brand demo">
        <a href="{{ url('admin') }}" class="app-brand-link">
            <span class="app-brand-text fw-bolder">Softlinks RBAC</span>
        </a>
    </div>

    <ul class="menu-inner py-1">

        {{-- Dashboard --}}
        <li class="menu-item {{ request()->is('admin') ? 'active' : '' }}">
            <a href="{{ url('admin') }}" class="menu-link">
                <i class="menu-icon bx bx-home-circle"></i>
                <div>Dashboard</div>
            </a>
        </li>

        {{-- Dynamic Category Menus --}}
        @foreach ($categories as $category)

            @php
                $modules = ModuleRolePrivillege::join(
                        'tbl_modules',
                        'tbl_role_privileges.module_id',
                        '=',
                        'tbl_modules.id'
                    )
                    ->whereIn('tbl_role_privileges.role_id', $roleIds)
                    ->where('tbl_modules.module_category_id', $category->id)
                    ->where('tbl_modules.show_in_menu', 1)
                    ->orderBy('tbl_modules.display_order')
                    ->select('tbl_modules.*')
                    ->distinct()
                    ->get();

                $isActive = false;
                foreach ($modules as $m) {
                    if (request()->is($m->route . '*')) {
                        $isActive = true;
                        break;
                    }
                }
            @endphp

            @if ($modules->isEmpty())
                @continue
            @endif

            <li class="menu-item {{ $isActive ? 'active open' : '' }}">
                <a href="javascript:void(0);" class="menu-link menu-toggle">
                    <i class="menu-icon {{ $category->icon_class ?? 'bx bx-folder' }}"></i>
                    <div>{{ $category->category_name }}</div>
                </a>

                <ul class="menu-sub">
                    @foreach ($modules as $module)
                        <li class="menu-item {{ request()->is($module->route . '*') ? 'active' : '' }}">
                            <a href="{{ url($module->route) }}" class="menu-link">
                                <div>{{ $module->module_name }}</div>
                            </a>
                        </li>
                    @endforeach
                </ul>
            </li>

        @endforeach

    </ul>
</aside>
