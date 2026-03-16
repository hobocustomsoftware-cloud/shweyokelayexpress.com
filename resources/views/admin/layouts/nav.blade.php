<nav class="app-header navbar navbar-expand bg-body">
    <!--begin::Container-->
    <div class="container-fluid">
        <!--begin::Start Navbar Links-->
        <ul class="navbar-nav">
            <li class="nav-item">
                <a class="nav-link" data-lte-toggle="sidebar" href="#" role="button">
                    <i class="fa-solid fa-bars"></i>
                </a>
            </li>
        </ul>
        <!--end::Start Navbar Links-->
        <!--begin::End Navbar Links-->
        <ul class="navbar-nav ms-auto">
            <!--begin::Fullscreen Toggle-->
            <li class="nav-item">
                <a class="nav-link" href="#" data-lte-toggle="fullscreen">
                    <i data-lte-icon="maximize" class="fa-solid fa-maximize"></i>
                    <i data-lte-icon="minimize" class="fa-solid fa-minimize" style="display: none"></i>
                </a>
            </li>
            <!--end::Fullscreen Toggle-->
            <!--begin::User Menu Dropdown-->
            <li class="nav-item dropdown user-menu">
                <a href="#" class="nav-link dropdown-toggle" data-bs-toggle="dropdown">
                    <img src="{{ public_asset('uploads/images/logo.png') }}" class="user-image rounded-circle shadow"
                        alt="" />
                    <span class="d-none d-md-inline"></span>
                </a>
                <ul class="dropdown-menu dropdown-menu-lg dropdown-menu-end">
                    <!--begin::User Image-->
                    <li class="user-header text-bg-dark">
                        <img src="{{ public_asset('uploads/images/logo.png') }}" class="rounded-circle shadow"
                            alt="User Profile" />
                        <p>
                            {{ Auth::user()->name }} - {{ Auth::user()->getRoleNames()->first() }}
                        </p>
                    </li>
                    <!--end::User Image-->
                    <!--begin::Menu Footer-->
                    <li class="user-footer">
                        <a href="{{ route('logout') }}" class="btn btn-default btn-flat text-danger"
                            onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                            ထွက်မည်
                        </a>
                        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                            @csrf
                        </form>
                    </li>
                    <!--end::Menu Footer-->
                </ul>
            </li>
            <!--end::User Menu Dropdown-->
        </ul>
        <!--end::End Navbar Links-->
    </div>
    <!--end::Container-->
</nav>
