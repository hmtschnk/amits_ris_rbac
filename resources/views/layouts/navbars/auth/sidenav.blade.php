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
	
            @if (Auth::user()->hasPermission('Dashboard', null, 'VIEW'))
            {{-- || Auth::user()->hasPermission('Dashboard', null, 'EDIT')) --}}
                <li class="nav-item">
                    <a class="nav-link {{ Route::currentRouteName() == 'home' ? 'active' : '' }}" href="{{ route('home') }}">
                        <div class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
                            <i class="fa fa-chart-line text-primary text-sm opacity-10"></i>
                        </div>
                        <span class="nav-link-text ms-1">Dashboard</span>
                    </a>
                </li>
            @endif

            {{-- @if (Auth::user()->hasPermission('Worklist', null, 'VIEW') || 
                 Auth::user()->hasPermission('My Task', null, 'VIEW') || 
                 Auth::user()->hasPermission('DICOM Storage List', null, 'VIEW') ||
                 Auth::user()->hasPermission('Upload Non-DICOM ECG', null, 'VIEW')) --}}

            @if (Auth::user()->hasAnyPermission(['Worklist', 'My Task', 'DICOM Storage List', 'Upload Non-DICOM ECG'], 'VIEW'))
                <li class="nav-item">
                    <h6 class="ps-4 ms-2 text-uppercase text-xs font-weight-bolder opacity-6">Worklist</h6>
                </li>
            
                @if (Auth::user()->hasPermission('Worklist', null, 'VIEW'))
                    <li class="nav-item">
                        {{-- <a class="nav-link {{ Route::currentRouteName() == 'worklist' && Request::path() != 'worklist/stored' ? 'active' : '' }}" href="{{ route('worklist') }}"> --}}
                        <a class="nav-link {{ Route::currentRouteName() == 'home' ? 'active' : '' }}" href="{{ route('home') }}">
                            <div
                                class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
                                <i class="ni ni-bullet-list-67 text-primary text-sm opacity-10"></i>
                            </div>
                            <span class="nav-link-text ms-1">Worklist</span>
                        </a>
                    </li>
                @endif
                @if (Auth::user()->hasPermission('My Task', null, 'VIEW'))
                    <li class="nav-item">
                        {{-- <a class="nav-link {{ Request::path() == 'worklist/uploaded' ? 'active' : '' }}" href="{{ route('worklist','uploaded') }}"> --}}
                            <a class="nav-link {{ Route::currentRouteName() == 'home' ? 'active' : '' }}" href="{{ route('home') }}">
                                <div
                                    class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
                                    <i class="ni ni-bullet-list-67 text-primary text-sm opacity-10"></i>
                                </div>
                                <span class="nav-link-text ms-1">My Task</span>
                            </a>
                        </li>
                @endif
                @if (Auth::user()->hasPermission('DICOM Storage List', null, 'VIEW'))
                    <li class="nav-item">
                        {{-- <a class="nav-link {{ Request::path() == 'worklist/stored' ? 'active' : '' }}" href="{{ route('worklist','stored') }}"> --}}
                        <a class="nav-link {{ Route::currentRouteName() == 'home' ? 'active' : '' }}" href="{{ route('home') }}">
                            <div
                                class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
                                <i class="fa fa-database text-primary text-sm opacity-10"></i>
                            </div>
                            <span class="nav-link-text ms-1">DICOM Storage List</span>
                        </a>
                    </li>
                @endif
                @if (Auth::user()->hasPermission('Upload Non-DICOM ECG', null, 'VIEW'))
                    <li class="nav-item">
                        {{-- <a class="nav-link {{ Request::path() == 'worklist/uploaded' ? 'active' : '' }}" href="{{ route('uploadStressTest') }}"> --}}
                        <a class="nav-link {{ Route::currentRouteName() == 'home' ? 'active' : '' }}" href="{{ route('home') }}">
                        <div
                            class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
                            <i class="fa fa-upload text-primary text-sm opacity-10"></i>
                        </div>
                        <span class="nav-link-text ms-1">Upload Non-DICOM ECG</span>
                        </a>
                    </li>
                @endif
            @endif
{{-- _____________________________________________________________________________________________________________________________________________________________________________________ --}}
             {{-- @if (Auth::user()->hasPermission('Menu')) --}}
                <li class="nav-item">
                        <h6 class="ps-4 ms-2 text-uppercase text-xs font-weight-bolder opacity-6">Menu</h6>
                </li>
            {{-- @endif  --}}

                @if (Auth::user()->hasPermission('Role Access', null, 'VIEW'))
                    <li class="nav-item">
                        <a class="nav-link {{ Route::currentRouteName() == 'role-access.index' ? 'active' : '' }}" href="{{ route('role-access.index') }}">
                            <div class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
                                <i class="fa fa-users-cog text-dark text-sm opacity-10"></i>
                            </div>
                            <span class="nav-link-text ms-1">Role Access</span>
                        </a>
                    </li>
                @endif

                @if (Auth::user()->hasPermission('Patient Referral', null, 'VIEW'))
                    <li class="nav-item">
                        <a class="nav-link {{ str_contains(Route::currentRouteName(), 'patient_referral') ? 'active' : '' }}" href="{{ route('patient_referral.listing') }}">
                            <div class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
                                <i class="fa fa-stethoscope text-primary text-sm opacity-10"></i>
                            </div>
                            <span class="nav-link-text ms-1">Patient Referral</span>
                        </a>
                    </li>
                @endif

            @if (Auth::user()->hasAnyPermission(['Radiologist Report', 'X-Ray Type Report', 'Final Report Statistic',  'Total Clinics by State', 'Urgent Report'], 'VIEW'))
                <li class="nav-item mt-2">
                    <h6 class="ps-4 ms-2 text-uppercase text-xs font-weight-bolder opacity-6">Reporting</h6>
                </li>
           
               @if (Auth::user()->hasPermission('Radiologist Report', null, 'VIEW'))
                    <li class="nav-item">
                        {{-- <a class="nav-link {{ Route::currentRouteName() == 'report' ? 'active' : '' }}" href="{{ route('report.radiologist') }}"> --}}
                        <a class="nav-link {{ Route::currentRouteName() == 'home' ? 'active' : '' }}" href="{{ route('home') }}">
                            <div
                                class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
                                <i class="ni ni-single-copy-04 text-primary text-sm opacity-10"></i>
                            </div>
                            <span class="nav-link-text ms-1">Radiologist Report</span>
                        </a>
                    </li>
                @endif
                @if (Auth::user()->hasPermission('X-Ray Type Report', null, 'VIEW'))    
                    <li class="nav-item">
                        {{-- <a class="nav-link {{ Route::currentRouteName() == 'report' ? 'active' : '' }}" href="{{ route('report.xray_type_new') }}"> --}}
                        <a class="nav-link {{ Route::currentRouteName() == 'home' ? 'active' : '' }}" href="{{ route('home') }}">
                            <div
                                class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
                                <i class="ni ni-single-copy-04 text-primary text-sm opacity-10"></i>
                            </div>
                            <span class="nav-link-text ms-1">X-Ray Type Report</span>
                        </a>
                    </li>
                @endif
                @if (Auth::user()->hasPermission('Final Report Statistic', null, 'VIEW'))    
                    <li class="nav-item">
                        {{-- <a class="nav-link {{ Route::currentRouteName() == 'report' ? 'active' : '' }}" href="{{ route('report.final_report_statistic') }}"> --}}
                        <a class="nav-link {{ Route::currentRouteName() == 'home' ? 'active' : '' }}" href="{{ route('home') }}">
                            <div
                                class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
                                <i class="ni ni-single-copy-04 text-primary text-sm opacity-10"></i>
                            </div>
                            <span class="nav-link-text ms-1">Final Report Statistic</span>
                        </a>
                    </li>
                @endif
                @if (Auth::user()->hasPermission('Total Clinics by State', null, 'VIEW'))  
                    <li class="nav-item">
                        {{-- <a class="nav-link {{ Route::currentRouteName() == 'report' ? 'active' : '' }}" href="{{ route('report.clinic_state') }}"> --}}
                        <a class="nav-link {{ Route::currentRouteName() == 'home' ? 'active' : '' }}" href="{{ route('home') }}">
                            <div
                                class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
                                <i class="ni ni-single-copy-04 text-primary text-sm opacity-10"></i>
                            </div>
                            <span class="nav-link-text ms-1">Total Clinics by State</span>
                        </a>
                    </li>
                @endif
               @if (Auth::user()->hasPermission('Urgent Report', null, 'VIEW'))  
                    <li class="nav-item">
                        {{-- <a class="nav-link {{ Route::currentRouteName() == 'report' ? 'active' : '' }}" href="{{ route('report.urgent_report') }}"> --}}
                        <a class="nav-link {{ Route::currentRouteName() == 'home' ? 'active' : '' }}" href="{{ route('home') }}">
                            <div
                                class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
                                <i class="ni ni-single-copy-04 text-primary text-sm opacity-10"></i>
                            </div>
                            <span class="nav-link-text ms-1">Urgent Report</span>
                        </a>
                    </li>
                @endif
            @endif
            
            @if (Auth::user()->hasAnyPermission(['User'], 'VIEW'))
                <li class="nav-item mt-2">
                    <h6 class="ps-4 ms-2 text-uppercase text-xs font-weight-bolder opacity-6">User Management</h6>
                </li>
            
                 @if (Auth::user()->hasPermission('User', null, 'VIEW')) 
                    <li class="nav-item">
                        {{-- <a class="nav-link {{ Route::currentRouteName() == 'user-management' ? 'active' : '' }}" href="{{ route('user-management') }}"> --}}
                         <a class="nav-link {{ Route::currentRouteName() == 'home' ? 'active' : '' }}" href="{{ route('home') }}">
                            <div class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
                                <i class="ni ni-single-02 text-primary text-sm opacity-10"></i>
                            </div>
                            <span class="nav-link-text ms-1">User</span>
                        </a>
                    </li>
                @endif
                @if (Auth::user()->hasPermission('User Groups', null, 'VIEW')) 
                    <li class="nav-item">
                        {{-- <a class="nav-link {{ Route::currentRouteName() == 'user-group' ? 'active' : '' }}" href="{{ route('user-group') }}"> --}}
                        <a class="nav-link {{ Route::currentRouteName() == 'home' ? 'active' : '' }}" href="{{ route('home') }}">
                            <div class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
                                <i class="ni ni-single-02 text-primary text-sm opacity-10"></i>
                            </div>
                            <span class="nav-link-text ms-1">User Groups</span>
                        </a>
                    </li>
                @endif
               @if (Auth::user()->hasPermission('Company', null, 'VIEW')) 
                    <li class="nav-item">
                        {{-- <a class="nav-link {{ Route::currentRouteName() == 'company' ? 'active' : '' }}" href="{{ route('company') }}"> --}}
                        <a class="nav-link {{ Route::currentRouteName() == 'home' ? 'active' : '' }}" href="{{ route('home') }}">
                            <div class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
                                <i class="ni ni-building text-primary text-sm opacity-10"></i>
                            </div>
                            <span class="nav-link-text ms-1">Company</span>
                        </a>
                    </li>
                @endif 

                @if (Auth::user()->hasPermission('X-ray Filters', null, 'VIEW')) 
                    <li class="nav-item">
                        {{-- <a class="nav-link {{ Route::currentRouteName() == 'user-xray-filter' ? 'active' : '' }}" href="{{ route('user-xray-filter') }}"> --}}
                        <a class="nav-link {{ Route::currentRouteName() == 'home' ? 'active' : '' }}" href="{{ route('home') }}">
                            <div class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
                                <i class="ni ni-settings-gear-65 text-warning text-sm opacity-10"></i>
                            </div>
                            <span class="nav-link-text ms-1">X-ray Filters</span>
                        </a>
                    </li>
                @endif 
            @endif
{{-- _____________________________________________________________________________________________________________________________________________________________________________________ --}}
            @if (Auth::user()->hasAnyPermission(['Pre - Invoice', 'Invoice', 'Payment',  'Account Statement', 'Billing','Charges'], 'VIEW'))
                <li class="nav-item mt-2">
                    <h6 class="ps-4 ms-2 text-uppercase text-xs font-weight-bolder opacity-6">Finance</h6>
                </li>
            @endif
            @if (Auth::user()->hasPermission('Pre - Invoice', null, 'VIEW')) 
                <li class="nav-item">
                    {{-- <a class="nav-link {{ Route::currentRouteName() == 'pre-invoice' ? 'active' : '' }}" href="{{ route('pre-invoice') }}"> --}}
                        <a class="nav-link" href="#">
                        <div class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
                            <i class="ni ni-money-coins text-primary text-sm opacity-10"></i>
                        </div>
                        <span class="nav-link-text ms-1">Pre - Invoice</span>
                    </a>
                </li>
            @endif
             @if (Auth::user()->hasPermission('Invoice', null, 'VIEW')) 
                <li class="nav-item">
                    {{-- <a class="nav-link {{ Route::currentRouteName() == 'invoice' ? 'active' : '' }}" href="{{ route('invoice') }}"> --}}
                        <a class="nav-link" href="#">
                        <div class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
                            <i class="ni ni-money-coins text-primary text-sm opacity-10"></i>
                        </div>
                        <span class="nav-link-text ms-1">Invoice</span>
                    </a>
                </li>
            @endif
            @if (Auth::user()->hasPermission('Payment', null, 'VIEW')) 
                <li class="nav-item">
                    {{-- <a class="nav-link {{ Route::currentRouteName() == 'payment' ? 'active' : '' }}" href="{{ route('payment') }}"> --}}
                        <a class="nav-link" href="#">
                        <div class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
                            <i class="ni ni-money-coins text-primary text-sm opacity-10"></i>
                        </div>
                        <span class="nav-link-text ms-1">Payment</span>
                    </a>
                </li>
            @endif
            @if (Auth::user()->hasPermission('Account Statement', null, 'VIEW')) 
                <li class="nav-item">
                    {{-- <a class="nav-link {{ Route::currentRouteName() == 'ledger.listing' ? 'active' : '' }}" href="{{ route('ledger.listing') }}"> --}}
                        <a class="nav-link" href="#">
                        <div class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
                            <i class="ni ni-money-coins text-primary text-sm opacity-10"></i>
                        </div>
                        <span class="nav-link-text ms-1">Account Statement</span>
                    </a>
                </li>
            @endif
            @if (Auth::user()->hasPermission('Billing', null, 'VIEW')) 
                <li class="nav-item">
                    {{-- <a class="nav-link {{ Route::currentRouteName() == 'billing.index' ? 'active' : '' }}" href="{{ route('billing.index') }}"> --}}
                        <a class="nav-link" href="#">
                        <div class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
                            <i class="ni ni-money-coins text-primary text-sm opacity-10"></i>
                        </div>
                        <span class="nav-link-text ms-1">Billing</span>
                    </a>
                </li>
            @endif
            @if (Auth::user()->hasPermission('Charges', null, 'VIEW')) 
                <li class="nav-item">
                    {{-- <a class="nav-link {{ Route::currentRouteName() == 'charges.index' ? 'active' : '' }}" href="{{ route('charges.index') }}"> --}}
                        <a class="nav-link" href="#">
                        <div class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
                            <i class="ni ni-money-coins text-primary text-sm opacity-10"></i>
                        </div>
                        <span class="nav-link-text ms-1">Charges</span>
                    </a>
                </li>
            @endif
           @if (Auth::user()->hasAnyPermission(['Billing Configuration', 'System Configuration', 'Banner Config',  'Report Template Config'], 'VIEW'))
                <li class="nav-item mt-2">
                    <h6 class="ps-4 ms-2 text-uppercase text-xs font-weight-bolder opacity-6">Settings</h6>
                </li>
            @endif
           @if (Auth::user()->hasPermission('Billing Configuration', null, 'VIEW')) 
                <li class="nav-item">
                    {{-- <a class="nav-link {{ Route::currentRouteName() == 'billing-config' ? 'active' : '' }}" href="{{ route('billing-config') }}"> --}}
                        <a class="nav-link" href="#">
                        <div class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
                            <i class="ni ni-settings text-primary text-sm opacity-10"></i>
                        </div>
                        <span class="nav-link-text ms-1">Billing Configuration</span>
                    </a>
                </li>                
            @endif
             @if (Auth::user()->hasPermission('System Configuration', null, 'VIEW'))
                <li class="nav-item">
                    {{-- <a class="nav-link {{ Route::currentRouteName() == 'settings.system_config' ? 'active' : '' }}" href="{{ route('settings.system_config') }}"> --}}
                        <a class="nav-link" href="#">
                        <div class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
                            <i class="ni ni-settings text-primary text-sm opacity-10"></i>
                        </div>
                        <span class="nav-link-text ms-1">System Configuration</span>
                    </a>
                </li>
            @endif
           @if (Auth::user()->hasPermission('Banner Config', null, 'VIEW'))
                <li class="nav-item">
                    {{-- <a class="nav-link {{ Request::path() == 'banner-config' ? 'active' : '' }}" href="{{ route('banner-config-listing') }}"> --}}
                        <a class="nav-link" href="#">
                        <div class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
                            <i class="fa fa-images text-primary text-sm opacity-10"></i>
                        </div>
                        <span class="nav-link-text ms-1">Banner Config</span>
                    </a>
                </li>
            @endif
            @if (Auth::user()->hasPermission('Report Template Config', null, 'VIEW'))
                <li class="nav-item">
                    {{-- <a class="nav-link {{ Request::path() == 'report-template-config' ? 'active' : '' }}" href="{{ route('report-template-list') }}"> --}}
                        <a class="nav-link" href="#">
                        <div class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
                            <i class="fa fa-file-alt text-primary text-sm opacity-10"></i>
                        </div>
                        <span class="nav-link-text ms-1">Report Template Config</span>
                    </a>
                </li>
            @endif
            @if (Auth::user()->hasAnyPermission(['User Account', 'Configuration', 'Banner Config',  'Report Template Config'], 'VIEW'))               
                <li class="nav-item mt-2">
                    <h6 class="ps-4 ms-2 text-uppercase text-xs font-weight-bolder opacity-6">User Profile</h6>
                </li>
            @endif
           @if (Auth::user()->hasPermission('User Account', null, 'VIEW'))
                <li class="nav-item">
                    {{-- <a class="nav-link {{ Route::currentRouteName() == 'profile' ? 'active' : '' }}" href="{{route('profile') }}"> --}}
                        <a class="nav-link" href="#">
                        <div
                            class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
                            <i class="ni ni-single-02 text-primary text-sm opacity-10"></i>
                        </div>
                        <span class="nav-link-text ms-1">User Account</span>
                    </a>
                </li>
            @endif
           
            @if (Auth::user()->hasPermission('Configuration', null, 'VIEW'))
                <li class="nav-item">
                    {{-- <a class="nav-link {{ Route::currentRouteName() == 'user.config' ? 'active' : '' }}" href="{{ route('user.config') }}"> --}}
                        <a class="nav-link" href="#">
                        <div
                            class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
                            <i class="ni ni-settings text-primary text-sm opacity-10"></i>
                        </div>
                        <span class="nav-link-text ms-1">Configuration</span>
                    </a>
                </li>
            @endif            
           @if (Auth::user()->hasAnyPermission(['User Manual - Manager', 'User Manual - Radiologist', 'User Manual - Radiographer',  'User Manual - Xray Facility'], 'VIEW'))   
                <li class="nav-item mt-2">
                    <h6 class="ps-4 ms-2 text-uppercase text-xs font-weight-bolder opacity-6">Help</h6>
                </li>
            @endif
            @if (Auth::user()->hasPermission('User Manual - Manager', null, 'VIEW'))
                <li class="nav-item">
                    {{-- <a class="nav-link"
                        href="{{ 'https://ris.amits4u.com/assets/user-manual/UserManual-Manager.pdf' }}"
                        target="_blank" > --}}
                        <a class="nav-link" href="#">
                        <div
                            class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
                            <i class="ni ni-book-bookmark text-primary text-sm opacity-10"></i>
                        </div>
                        <span class="nav-link-text ms-1">User Manual - Manager</span>
                    </a>
                </li>
            @endif
            @if (Auth::user()->hasPermission('User Manual - Radiologist', null, 'VIEW'))
                <li class="nav-item">
                    {{-- <a class="nav-link {{ Route::currentRouteName() == 'user_manual' ? 'active' : '' }}"
                        href="{{ 'https://ris.amits4u.com/assets/user-manual/UserManual-Radiologist.pdf' }}"
                        target="_blank" > --}}
                        <a class="nav-link" href="#">
                        <div
                            class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
                            <i class="ni ni-book-bookmark text-primary text-sm opacity-10"></i>
                        </div>
                        <span class="nav-link-text ms-1">User Manual - Radiologist</span>
                    </a>
                </li>
            @endif
            @if (Auth::user()->hasPermission('User Manual - Radiographer', null, 'VIEW'))
                <li class="nav-item mb-0">
                    {{-- <a class="nav-link {{ Route::currentRouteName() == 'user_manual' ? 'active' : '' }}"
                        href="{{ 'https://ris.amits4u.com/assets/user-manual/UserManual-Radiographer.pdf' }}"
                        target="_blank" > --}}
                        <a class="nav-link" href="#">
                        <div
                            class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
                            <i class="ni ni-book-bookmark text-primary text-sm opacity-10"></i>
                        </div>
                        <span class="nav-link-text ms-1">User Manual - Radiographer</span>
                    </a>
                </li>
            @endif
            @if (Auth::user()->hasPermission('User Manual - Xray Facility', null, 'VIEW'))
                <li class="nav-item mb-0">
                    {{-- <a class="nav-link {{ Route::currentRouteName() == 'user_manual' ? 'active' : '' }}"
                        href="{{ 'https://ris.amits4u.com/assets/user-manual/UserManual-XrayFacility.pdf' }}"
                        target="_blank" > --}}
                        <a class="nav-link" href="#">
                        <div
                            class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
                            <i class="ni ni-book-bookmark text-primary text-sm opacity-10"></i>
                        </div>
                        <span class="nav-link-text ms-1">User Manual - Xray Facility</span>
                    </a>
                </li>
            @endif 


        </ul>
    </div>
</aside>
