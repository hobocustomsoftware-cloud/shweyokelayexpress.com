<aside class="app-sidebar bg-dark shadow" data-bs-theme="dark">
    <!--begin::Sidebar Brand-->
    <div class="sidebar-brand">
        <!--begin::Brand Link-->
        <a href="{{ route('admin.dashboard') }}" class="brand-link">
            <!--begin::Brand Image-->
            <img src="{{ public_asset('uploads/images/logo-shweyokelay.png') }}" alt="Logo" class="brand-image opacity-75" />
            <!--end::Brand Image-->
            <!--begin::Brand Text-->
            <!-- <span class="brand-text fw-light">ရွှေရုပ်လေး</span> -->
            <!--end::Brand Text-->
        </a>
        <!--end::Brand Link-->
    </div>
    <!--end::Sidebar Brand-->
    <!--begin::Sidebar Wrapper-->
    <div class="sidebar-wrapper">
        <nav class="mt-2">
            <!--begin::Sidebar Menu-->
            <ul class="nav sidebar-menu flex-column" data-lte-toggle="treeview" role="menu" data-accordion="false">
                @if (Auth::user()->hasRole('Admin'))
                <li class="nav-item">
                    <a href="{{ route('admin.dashboard') }}" class="nav-link {{ request()->is('/') ? 'active' : '' }}">
                        <i class="fa-solid fa-house"></i>
                        <p>ပင်မစာမျက်နှာ</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="#" class="nav-link">
                        <i class="fa-solid fa-file-pen"></i>
                        <p>အချက်အလက်များ</p>
                        <i class="nav-arrow fa-solid fa-chevron-right"></i>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item mb-2">
                            <a href="{{ route('admin.cities.index') }}"
                                class="nav-link {{ request()->is('admin/cities*') ? 'active' : '' }}">
                                <i class="fa-solid fa-city"></i>
                                <p>မြို့များ</p>
                            </a>
                        </li>

                        <li class="nav-item mb-2">
                            <a href="{{ route('admin.gates.index') }}"
                                class="nav-link {{ request()->is('admin/gates*') ? 'active' : '' }}">
                                <i class="fa-solid fa-truck"></i>
                                <p>ဂိတ်များ</p>
                            </a>
                        </li>
                        <li class="nav-item mb-2">
                            <a href="{{ route('admin.cars.index') }}"
                                class="nav-link {{ request()->is('admin/cars*') ? 'active' : '' }}">
                                <i class="fa-solid fa-car"></i>
                                <p>ကားများစာရင်း</p>
                            </a>
                        </li>

                        <li class="nav-item mb-2">
                            <a href="{{ route('admin.cargo_types.index') }}"
                                class="nav-link {{ request()->is('admin/cargo_types*') ? 'active' : '' }}">
                                <i class="fa-solid fa-truck-ramp-box"></i>
                                <p>ကုန်အမျိုးအစားများ</p>
                            </a>
                        </li>

                        <li class="nav-item mb-2">
                            <a href="{{ route('admin.merchants.index') }}"
                                class="nav-link {{ request()->is('admin/merchants*') ? 'active' : '' }}">
                                <i class="fa-solid fa-user"></i>
                                <p>ကုန်သည်များ</p>
                            </a>
                        </li>
                    </ul>
                </li>
                @endif
                @if (!Auth::user()->hasRole('Accountant'))
                <li class="nav-item">
                    <a href="#" class="nav-link">
                        <i class="fa-solid fa-truck-ramp-box"></i>
                        <p>ကုန်ပစ္စည်းများ</p>
                        <i class="nav-arrow fa-solid fa-chevron-right"></i>
                    </a>
                    <ul class="nav nav-treeview">
                        @if (Auth::user()->hasRole('Admin') || Auth::user()->hasRole('Staff'))
                        <li class="nav-item mb-2">
                            <a href="{{ route('admin.cargos.index') }}"
                                class="nav-link {{ request()->is('admin/cargos*') ? 'active' : '' }}">
                                <i class="fa-solid fa-truck"></i>
                                <p>ပုံမှန်ကုန်ပစ္စည်းများ</p>
                            </a>
                        </li>
                        @endif
                        @if (Auth::user()->hasRole('Admin') || Auth::user()->hasRole('Staff') || Auth::user()->hasRole('Spare'))
                        <li class="nav-item mb-2">
                            <a href="{{ route('admin.transit_cargos.index') }}"
                                class="nav-link {{ request()->is('admin/transit_cargos*') ? 'active' : '' }}">
                                <i class="fa-solid fa-truck"></i>
                                <p>လမ်းတင်ကုန်ပစ္စည်းများ</p>
                            </a>
                        </li>
                        <li class="nav-item mb-2">
                            <a href="{{ route('admin.transit_passengers.index') }}"
                                class="nav-link {{ request()->is('admin/transit_passengers*') ? 'active' : '' }}">
                                <i class="fa-solid fa-person"></i>
                                <p>လမ်းတင်လူစာရင်းများ</p>
                            </a>
                        </li>
                        @endif
                        @if (Auth::user()->hasRole('Admin') || Auth::user()->hasRole('Staff'))
                        <li class="nav-item mb-2">
                            <a href="{{ route('admin.putin_cargos.index') }}"
                                class="nav-link {{ request()->is('admin/putin_cargos*') ? 'active' : '' }}">
                                <i class="fa-solid fa-truck"></i>
                                <p>ကားပေါ်တင်ရန် ကုန်ပစ္စည်းများ</p>
                            </a>
                        </li>
                        @endif
                    </ul>
                </li>
                @endif
                @if (Auth::user()->hasRole('Admin') || Auth::user()->hasRole('Accountant'))
                <li class="nav-item">
                    <a href="#" class="nav-link">
                        <i class="fa-solid fa-file-invoice"></i>
                        <p>အစီရင်ခံစာများ</p>
                        <i class="nav-arrow fa-solid fa-chevron-right"></i>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item mb-2">
                            <a href="{{ route('admin.reports.index') }}"
                                class="nav-link {{ request()->is('admin/reports*') ? 'active' : '' }}">
                                <i class="fa-solid fa-file-invoice"></i>
                                <p>ကုန်စာရင်း အစီရင်ခံစာများ</p>
                            </a>
                        </li>
                        <li class="nav-item mb-2">
                            <a href="{{ route('admin.reports.passenger_reports') }}"
                                class="nav-link {{ request()->is('admin/passenger_reports*') ? 'active' : '' }}">
                                <i class="fa-solid fa-file-invoice"></i>
                                <p>လူစာရင်း အစီရင်ခံစာများ</p>
                            </a>
                        </li>
                    </ul>
                </li>
                @endif
                @if (Auth::user()->hasRole('Admin'))
                <li class="nav-item mb-2">
                    <a href="{{ route('admin.users.index') }}"
                        class="nav-link {{ request()->is('admin/users*') ? 'active' : '' }}">
                        <i class="fa-solid fa-users"></i>
                        <p>အသုံးပြုသူများ</p>
                    </a>
                </li>
                <li class="nav-item mb-2">
                    <a href="{{ route('admin.permissions.index') }}"
                        class="nav-link {{ request()->is('admin/permissions*') ? 'active' : '' }}">
                        <i class="fa-solid fa-lock"></i>
                        <p>ခွင့်ပြုချက်များ</p>
                    </a>
                </li>
                <li class="nav-item mb-2">
                    <a href="{{ route('admin.role_permissions.index') }}"
                        class="nav-link {{ request()->is('admin/role_permissions*') ? 'active' : '' }}">
                        <i class="fa-solid fa-lock"></i>
                        <p>ရာထူးနှင့်ခွင့်ပြုချက်များ</p>
                    </a>
                </li>
                @endif
            </ul>
            <!--end::Sidebar Menu-->
        </nav>
    </div>
    <!--end::Sidebar Wrapper-->
</aside>