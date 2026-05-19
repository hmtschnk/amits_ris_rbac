 <nav class="navbar navbar-main navbar-expand-lg px-0 shadow-none bg-primary" id="navbarBlur" data-scroll="false">
    <div class="container-fluid py-1 px-3">
        <!-- LEFT SIDE: Toggler and Title -->
        <div class="d-flex align-items-center">
            <a href="javascript:;" class="nav-link text-white p-0 me-3" id="iconNavbarSidenav">
                <div class="sidenav-toggler-inner">
                    <i class="sidenav-toggler-line bg-white"></i>
                    <i class="sidenav-toggler-line bg-white"></i>
                    <i class="sidenav-toggler-line bg-white"></i>
                </div>
            </a>
            <nav aria-label="breadcrumb">
                <h6 class="font-weight-bolder text-white mb-0 text-capitalize">
                    {{ str_replace('-', ' ', Request::path()) }}
                </h6>
            </nav>
        </div>

        <!-- RIGHT SIDE: Aligned Items -->
        <div class="collapse navbar-collapse mt-sm-0 mt-2 me-md-0 me-sm-4" id="navbar">
            <ul class="navbar-nav ms-md-auto justify-content-end align-items-center">
                
                {{-- 1. Hotline --}}
                <li class="nav-item d-flex align-items-center me-4">
                    <a href="javascript:;" class="nav-link text-white font-weight-bold p-0">
                        <i class="fa fa-comments me-1"></i>
                        <span class="d-sm-inline d-none small">Hotline +60 14-5556060</span>
                    </a>
                </li>

                {{-- 2. User Profile --}}
                <li class="nav-item d-flex align-items-center me-4">
                    <a href="{{ route('role-access.index') }}" class="nav-link text-white font-weight-bold p-0 text-uppercase">
                        <i class="fa fa-user me-1"></i>
                        <span class="d-sm-inline d-none small">{{ auth()->user()->username ?? 'Admin' }}</span>
                    </a>
                </li>

                {{-- 3. Logout --}}
                <li class="nav-item d-flex align-items-center">
                    <form method="POST" action="{{ route('auth.destroy') }}" class="m-0">
                        @csrf
                        <button type="submit" class="nav-link text-white font-weight-bold p-0 border-0 bg-transparent d-flex align-items-center">
                            <i class="fa fa-power-off me-1"></i>
                            <span class="d-sm-inline d-none small">Log out</span>
                        </button>
                    </form>
                </li>
            </ul>
        </div>
    </div>
</nav>