<aside class="sidenav navbar navbar-vertical navbar-expand-xs border-0 border-radius-xl my-3 fixed-start ms-4 "id="sidenav-main">
    <div class="sidenav-header bg-gray-100">
        <i class="fas fa-times p-3 cursor-pointer text-secondary opacity-5 position-absolute end-0 top-0 "
            aria-hidden="true" id="iconSidenav"></i>
        <a class="navbar-brand m-0 ms-3" href="{{ route('home') }}">
            <img src="{{ asset('./img/NR_RIS_bg2.png') }}" class="navbar-brand-img" alt="main_logo" height="65">
        </a>
    </div>
    <hr class="mt-0 mb-0">
    <div class="collapse navbar-collapse w-auto" id="sidenav-collapse-main">
        <ul class="navbar-nav bg-gray-100 mb-2">
	{{-- @if (!Auth::user()->hasRole('REFERRING')) --}}
	    <li class="nav-item">
            <a class="nav-link {{ Route::currentRouteName() == 'home' ? 'active' : '' }}" href="{{ route('home') }}">
                <div
                class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
                <i class="fa fa-chart-line text-primary text-sm opacity-10"></i>
                </div>
                <span class="nav-link-text ms-1">Dashboard</span>
            </a>
	    </li>
        {{-- @endif --}}
              @if (Auth::user()->hasRoles(['MASTER_ADMIN','MANAGER']))
                <li class="nav-item">
                    <h6 class="ps-4 ms-2 text-uppercase text-xs font-weight-bolder opacity-6">Menu</h6>
                </li>
            @endif
            @if (Auth::user()->hasRoles(['MASTER_ADMIN','MANAGER','RADIOLOGIST','RADIOGRAPHER','XRAY_FACILITY','ADMIN_ACCOUNTANT','ADMIN_RADIOGRAPHER',
                                        'ACCOUNTANT','ADMIN','AMITS_ACCOUNTANT','SECONDARY','REFERRING']))
              <li class="nav-item">
                    <a class="nav-link {{ Route::currentRouteName() == 'role-access.index' ? 'active' : '' }}" href="{{ route('role-access.index') }}">
                        <div class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
                            <i class="fa fa-users-cog text-dark text-sm opacity-10"></i>
                        </div>
                        <span class="nav-link-text ms-1">Role Access</span>
                    </a>
              </li>
            @endif
            @if (Auth::user()->hasRoles(['MASTER_ADMIN','REFERRING','XRAY_FACILITY','MANAGER']))
                <li class="nav-item">
                    <a class="nav-link {{ str_contains(Route::currentRouteName(), 'patient_referral') ? 'active' : '' }}" href="{{ route('patient_referral.listing') }}">
                        <div class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
                            <i class="fa fa-stethoscope text-primary text-sm opacity-10"></i>
                        </div>
                        <span class="nav-link-text ms-1">Patient Referral</span>
                    </a>
                </li>
            @endif
            
            
        </ul>
    </div>
</aside>
