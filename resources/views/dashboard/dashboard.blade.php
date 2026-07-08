@extends('layouts.app', ['class' => 'g-sidenav-show bg-gray-100'])
@section('content')
    <style>
        .ads-wrapper {
            position: relative;
            width: 100%;
            display: flex;
            align-items: center;            
        }

        .ads-container {
            display: flex;
            overflow-x: auto;
            scroll-snap-type: x mandatory;
            scroll-behavior: smooth;
            width: 100%;
            padding: 10px 40px; /* give space for arrows */            
        }

        .ads-container::-webkit-scrollbar {
            display: none;
        }

        .ad-item {
            flex: 0 0 25%; /* show 4 per screen */
            scroll-snap-align: start;
            padding-right: 10px;
            box-sizing: border-box; /* ✅ added */
        }

        .ad-item img {
            width: 100%;
            aspect-ratio: 2 / 1;
            object-fit: cover;
            border-radius: 8px;
            cursor: pointer;
            transition: transform 0.2s ease;

            border: 2px solid rgba(0,0,0,0.08);        /* ✅ added visible border */
            background-clip: padding-box;              /* ✅ added to preserve border radius edge */
            box-shadow: 0 2px 6px rgba(0,0,0,0.06);    /* ✅ added subtle shadow for depth */
            
        }
        .ad-item img:hover {
            transform: scale(1.05);
            box-shadow: 0 6px 18px rgba(0,0,0,0.12);   /* ✅ added */
            border-color: rgba(0,0,0,0.14);            /* ✅ added */
        }

        /* If no link (not clickable), remove hover effect */
        .ad-item:not(:has(a)) img {
            cursor: default;
            transform: none;
        }

        .arrow:hover {
            background: rgba(0,0,0,0.8);
        }

        .arrow {
            position: absolute;
            top: 50%;
            transform: translateY(-50%);
            background: rgba(0,0,0,0.25);   /* light transparent circle */
            color: white;
            border: none;
            outline: none;
            border-radius: 50%;
            font-size: 22px;                /* slightly bigger so visible */
            padding: 8px 12px;
            cursor: pointer;
            z-index: 10;
            opacity: 0.5;                   /* always slightly visible */
            transition: opacity 0.3s ease, background-color 0.3s ease;
        }

        .arrow.left {
            left: 5px;
        }
        .arrow.right {
            right: 5px;
        }

        .arrow:hover {
            background: rgba(0,0,0,0.4);   /* darker on hover */
            opacity: 1;                    /* fully visible on hover */
        }

        @media (min-width: 769px) {
            .ad-item.placeholder {
                flex: 0 0 25%;           /* same width as real ads */
                scroll-snap-align: start;
                padding-right: 10px;     /* same gap as ads */
                display: flex;
                align-items: center;
                justify-content: center;
                background: none !important; /* force remove bg */
                cursor: default;
            }

            .ad-item.placeholder::before {
                content: "";
                display: block;
                width: 100%;
                aspect-ratio: 2 / 1;     /* same height as ads */
                border: 2px dashed #ccc; /* border only */
                border-radius: 8px;
                background: none !important; /* ensure no grey fill */
                cursor: default;
            }

            /* remove last item’s extra padding */
            .ads-container .ad-item:last-child {
                padding-right: 0;
            }
        }

        /* Mobile: keep vertical scroll, hide arrows */
        @media (max-width: 768px) {
            .ads-wrapper {
                flex-direction: column;
            }
            .arrow {
                display: none;
            }
            .ads-container {
                flex-direction: column;
                overflow-y: auto;
                overflow-x: hidden;
                padding: 10px;
                max-height: calc((100vw / 2) * 3); /* fit 3 ads (2:1 ratio each) */
            }          
            .ad-item {
                flex: 0 0 auto;
                width: 100%;
                padding-right: 0;
                margin-bottom: 10px;
            }

            .ad-item.placeholder {
                display: none;
            }

            .ad-item img {
                border: 2px solid rgba(0,0,0,0.06); /* ✅ added */
            }
        }
    </style>

     {{-- @if (auth()->user()->hasRoles(['MASTER_ADMIN','MANAGER'])) --}}
    @if (Auth::user()->hasPermission('Dashboard', 'dsb_topnav_selectGroup', 'VIEW'))
        @include('layouts.navbars.auth.topnav', ['title' => 'Dashboard','selectOption' => $userGroupSel,'groupname'=> $userGroupName, 'submitform' => $submit])
    @else
        @include('layouts.navbars.auth.topnav', ['title' => 'Dashboard'])
    @endif
            
    <div class="container-fluid py-2">
        <div class="row">
         {{-- @include('components.alert') --}}


        @php
            $visibleCardCount = collect([
                     'dsb_card_uploaded',
                     'dsb_card_stored',
                     'dsb_card_new',
                     'dsb_card_assigned',
                     'dsb_card_final',
                 ])
                 ->filter(function ($permission) {
                     return Auth::user()->hasPermission('Dashboard', $permission, 'VIEW') ||
                            Auth::user()->hasPermission('Dashboard', $permission, 'EDIT');
                 })
                 ->count();

             $allCardsVisible = $visibleCardCount >= 5;

             // Grid class for the cards: Uploaded, Stored, Assigned
             $USAcardGrid = $allCardsVisible ? 'col-xl-2 col-sm-6' : 'col-xl-4 col-sm-6';

             // Grid class for the cards: New, Final
             $newFinalcardGrid = $allCardsVisible ? 'col-xl-3 col-sm-6' : 'col-xl-4 col-sm-6';

             // true = show "WAITING / REPORTING" wording instead of "NEW / ASSIGNED"
             $useNewAssgLabel = Auth::user()->hasPermission('Dashboard', 'dsb_card_label', 'VIEW');   
        @endphp
         
         {{-- UPLOADED --}} 
         {{-- @if (auth()->user()->hasRoles(['MASTER_ADMIN','XRAY_FACILITY','MANAGER','SECONDARY','REGISTER'])) --}}
               {{--  <div class=" {{ auth()->user()->hasRoles(['MASTER_ADMIN','XRAY_FACILITY','MANAGER','SECONDARY','REFERRING','REGISTER']) ? 'col-xl-2 col-sm-6' : 'col-xl-4 col-sm-6' }} mb-xl-0 mb-4"> --}}
         @php
                $canViewUploaded = Auth::user()->hasPermission('Dashboard', 'dsb_card_uploaded', 'VIEW');
                $canEditUploaded = Auth::user()->hasPermission('Dashboard', 'dsb_card_uploaded', 'EDIT');
         @endphp
         @if ($canViewUploaded || $canEditUploaded)
                <div class="{{ $USAcardGrid }} mb-xl-0 mb-4">
                    <a class="navbar-brand m-0 d-block"
                       @if($canEditUploaded) href="{{--{{ route('worklist','UPLOADED') }}--}}" @else style="cursor: default;" @endif>
                        <div class="card border-0 shadow-sm" style="border-radius: 1rem; overflow: hidden;">
                            <div class="card-body p-3" style="background-color: #ffffff;">
                                <div class="row">
                                    <div class="{{ $canEditUploaded ? 'col-8' : 'col-12' }}">
                                        <div class="numbers">
                                            <p class="text-sm mb-1 text-uppercase font-weight-bold">Uploaded</p>
                                            <h5 class="font-weight-bolder mb-0" style="font-size: 18px !important;">
                                                {{ $uploaded->count() }}
                                            </h5>
                                            <span class="text-body text-sm font-weight-normal d-block mb-0" style="font-size: 12px !important; ">
                                                {{ui_label('dsb_asof')}} {{ date('d/m/Y') }}</span>
                                                <!--as of {{ date('d/m/Y') }}</span>-->
                                        </div>
                                    </div>
                                    {{-- button uploaded --}} 
                                    @if ($canEditUploaded)
                                    <div class="col-4 text-end">
                                        <div class="icon icon-shape bg-dark shadow-primary rounded-circle" style="width: 48px; height: 48px; display: flex; align-items: center; justify-content: center; position: relative;">
                                            <i class="fa fa-upload text-white opacity-10" aria-hidden="true" style="font-size: 1.2rem; position: absolute; top: 50%; left: 50%; transform: translate(-50%, -50%);"></i>
                                        </div>
                                    </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </a>
                </div>
            @endif

             {{-- STORED --}} 
            @php
                $canViewStored = Auth::user()->hasPermission('Dashboard', 'dsb_card_stored', 'VIEW');
                $canEditStored = Auth::user()->hasPermission('Dashboard', 'dsb_card_stored', 'EDIT');
            @endphp
            @if ($canViewStored || $canEditStored)
               {{--  <div class="{{ auth()->user()->hasRoles(['MASTER_ADMIN','XRAY_FACILITY','SECONDARY','REFERRING','MANAGER','REGISTER']) ? 'col-xl-2 col-sm-6' : 'col-xl-4 col-sm-6' }} mb-xl-0 mb-4"> --}}
                <div class="{{ $USAcardGrid }} mb-xl-0 mb-4">
                    <a class="navbar-brand m-0 d-block"
                       @if($canEditStored) href="{{-- {{   route('worklist','STORED')}}--}}" @else style="cursor: default;" @endif>
                        <div class="card border-0 shadow-sm" style="border-radius: 1rem; overflow: hidden;">
                            <div class="card-body p-3" style="background-color: #e8f5e9;">
                                <div class="row">
                                    {{-- >>> EDIT: number column takes full width when no icon is shown <<< --}}
                                    <div class="{{ $canEditStored ? 'col-8' : 'col-12' }}">
                                        <div class="numbers">
                                            <p class="text-sm mb-1 text-uppercase font-weight-bold">Stored</p>
                                            <h5 class="font-weight-bolder mb-0" style="font-size: 18px !important;">
                                                {{ $storage->count() }}
                                            </h5>
                                            <span class="text-body font-weight-normal d-block mb-0" style="font-size: 12px !important;">
                                                {{ui_label('dsb_forlast')}} {{ $month }} {{ui_label('dsb_months')}}</span>
                                                <!--For last {{ $month }} months</span>-->
                                            {{-- <p class="text-xs mb-0 text-success font-weight-bold">Storage only</p> --}}
                                        </div>
                                    </div>
                                    {{-- button stored --}}
                                    @if ($canEditStored)
                                    <div class="col-4 text-end"> 
                                        <div class="icon icon-shape bg-gradient-success shadow-primary rounded-circle" style="width: 48px; height: 48px; display: flex; align-items: center; justify-content: center; position: relative;">
                                            <i class="fa fa-database text-white opacity-10" aria-hidden="true" style="font-size: 1.2rem; position: absolute; top: 50%; left: 50%; transform: translate(-50%, -50%);"></i>
                                        </div>
                                    </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </a>
                </div>
            @endif

            {{-- NEW --}}
            {{-- @if (!Auth::user()->hasRole('REFERRING')) --}}
            @php
                $canViewNew = Auth::user()->hasPermission('Dashboard', 'dsb_card_new', 'VIEW');
                $canEditNew = Auth::user()->hasPermission('Dashboard', 'dsb_card_new', 'EDIT');
            @endphp
            @if ($canViewNew || $canEditNew)
                {{-- <div class="{{ auth()->user()->hasRoles(['MASTER_ADMIN','XRAY_FACILITY','SECONDARY','REFERRING','MANAGER','REGISTER']) ? 'col-xl-3 col-sm-6' : 'col-xl-4 col-sm-6' }} mb-xl-0 mb-4"> --}}
                <div class="{{ $newFinalcardGrid }} mb-xl-0 mb-4">
                    <a class="navbar-brand m-0 d-block"
                       @if($canEditNew) href="{{--{{ route('worklist','NEW') }}--}}" @else style="cursor: default;" @endif>
                        <div class="card border-0 shadow-sm" style="border-radius: 1rem; overflow: hidden;">
                            <div class="card-body p-3" style="background-color: #fff3e0;">
                                <div class="row">
                                    <div class="{{ $canEditNew ? 'col-8' : 'col-12' }}">
                                        <div class="numbers">
                                            {{-- <p class="text-sm mb-1 text-uppercase font-weight-bold"> {{ auth()->user()->hasRoles(['XRAY_FACILITY','SECONDARY','REFERRING']) ? 'WAITING' : 'NEW' }} </p> --}}
                                             <p class="text-sm mb-1 text-uppercase font-weight-bold">
                                                {{ $useNewAssgLabel ? 'WAITING' : 'NEW' }}
                                            </p>
                                            <h5 class="font-weight-bolder mb-0" style="font-size: 18px !important;">
                                                {{ $new->count() }}
                                            </h5>
                                            <span class="text-body font-weight-normal d-block mb-0" style="font-size: 12px !important;">
                                                {{ui_label('dsb_asof')}} {{ date('d/m/Y') }}</span>
                                                <!--as of {{ date('d/m/Y') }}</span>-->
                                        </div>
                                    </div>
                                    {{-- button new --}}
                                    @if ($canEditNew)
                                    <div class="col-4 text-end"> 
                                        <div class="icon icon-shape bg-warning shadow-primary rounded-circle" style="width: 48px; height: 48px; display: flex; align-items: center; justify-content: center; position: relative;">
                                            <i class="fa fa-share-from-square text-white opacity-10" aria-hidden="true" style="font-size: 1.2rem; position: absolute; top: 50%; left: 50%; transform: translate(-50%, -50%);"></i>
                                        </div>
                                    </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </a>
                </div>
            @endif

            {{-- ASSIGNED --}}
            @php
                $canViewAssigned = Auth::user()->hasPermission('Dashboard', 'dsb_card_assigned', 'VIEW');
                $canEditAssigned = Auth::user()->hasPermission('Dashboard', 'dsb_card_assigned', 'EDIT');
            @endphp
            @if ($canViewAssigned || $canEditAssigned)
                {{-- <div class=" {{  auth()->user()->hasRoles(['MASTER_ADMIN','XRAY_FACILITY','SECONDARY','REFERRING','MANAGER','REGISTER']) ? 'col-xl-2 col-sm-6' : 'col-xl-4 col-sm-6' }}  mb-xl-0 mb-4"> --}}
                 <div class="{{ $USAcardGrid }} mb-xl-0 mb-4">
                    <a class="navbar-brand m-0 d-block"
                       @if($canEditAssigned) href="{{--{{  route('worklist','ASSIGNED') }} --}}" @else style="cursor: default;" @endif>
                        <div class="card border-0 shadow-sm" style="border-radius: 1rem; overflow: hidden;">
                            <div class="card-body p-3" style="background-color: #e3f2fd;">
                                <div class="row">
                                    <div class="{{ $canEditAssigned ? 'col-8' : 'col-12' }}">
                                        <div class="numbers">
                                            {{-- <div class="text-sm mb-1 text-uppercase font-weight-bold"> {{ auth()->user()->hasRoles(['XRAY_FACILITY','SECONDARY','REFERRING']) ? 'REPORTING' : 'Assigned' }}@if ($showMyself) <font size="1.5px">Myself</font> @endif </div> --}}
                                            <div class="text-sm mb-1 text-uppercase font-weight-bold">
                                                {{ $useNewAssgLabel ? 'REPORTING' : 'ASSIGNED' }}
                                                @if ($showMyself) <font size="1.5px">Myself</font> @endif
                                            </div>
                                            <h5 class="font-weight-bolder mb-0" style="font-size: 18px !important;">
                                                {{ $assign->count() }}
                                            </h5>
                                            <span class="text-body font-weight-normal d-block mb-0" style="font-size: 12px !important;">
                                                {{ui_label('dsb_asof')}} {{ date('d/m/Y') }}</span>
                                                <!--as of {{ date('d/m/Y') }}</span>-->
                                            
                                        </div>
                                    </div>
                                    {{-- button assigned --}}
                                    @if ($canEditAssigned)
                                    <div class="col-4 text-end">  
                                        <div class="icon icon-shape bg-gradient-info shadow-danger rounded-circle" style="width: 48px; height: 48px; display: flex; align-items: center; justify-content: center; position: relative;">
                                            <i class="fa fa-user-md text-white opacity-10" aria-hidden="true" style="font-size: 1.2rem; position: absolute; top: 50%; left: 50%; transform: translate(-50%, -50%);"></i>
                                        </div>
                                    </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </a>
                </div>
            @endif

            {{-- FINAL --}}
            @php
                $canViewFinal = Auth::user()->hasPermission('Dashboard', 'dsb_card_final', 'VIEW');
                $canEditFinal = Auth::user()->hasPermission('Dashboard', 'dsb_card_final', 'EDIT');
            @endphp
            @if ($canViewFinal || $canEditFinal)
                {{-- <div class="  {{ auth()->user()->hasRoles(['MASTER_ADMIN','XRAY_FACILITY','SECONDARY','REFERRING','MANAGER','REGISTER']) ? 'col-xl-3 col-sm-6' : 'col-xl-4 col-sm-6' }} mb-xl-0 mb-4"> --}}
                <div class="{{ $newFinalcardGrid  }} mb-xl-0 mb-4">
                    <a class="navbar-brand m-0 d-block"
                       @if($canEditFinal) href="{{-- {{  route('worklist', 'FINAL') }} --}} " @else style="cursor: default;" @endif>
                        <div class="card border-0 shadow-sm" style="border-radius: 1rem; overflow: hidden;">
                            <div class="card-body p-3" style="background-color: #e8f5e9;">
                                <div class="row">
                                    <div class="{{ $canEditFinal ? 'col-8' : 'col-12' }}">
                                        <div class="numbers">
                                            <p class="text-sm mb-1 text-uppercase font-weight-bold">Final @if($showMyself)<font size="1.5px">Myself</font> @endif</p>
                                            <h5 class="font-weight-bolder mb-0" style="font-size: 18px !important;">
                                                {{ number_format($review->count(),0,'.',',') }}
                                            </h5>
                                            <span class="text-body font-weight-normal d-block mb-0" style="font-size: 12px !important;">
                                                {{ui_label('dsb_forlast')}} {{ $month }} {{ui_label('dsb_months')}}</span>
                                                <!--For last {{ $month }} months</span>-->
                                            
                                        </div>
                                    </div>
                                    {{-- button final --}}
                                    @if ($canEditFinal)
                                    <div class="col-4 text-end"> 
                                        <div class="icon icon-shape bg-gradient-success shadow-success rounded-circle" style="width: 48px; height: 48px; display: flex; align-items: center; justify-content: center; position: relative;">
                                            <i class="fa fa-notes-medical text-white opacity-10" aria-hidden="true" style="font-size: 1.2rem; position: absolute; top: 50%; left: 50%; transform: translate(-50%, -50%);"></i>
                                        </div>
                                    </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </a>
                </div>
        </div>
	        @endif
        
        <div class="row mt-4">
            {{-- @if ( auth()->user()->hasRoles(['MASTER_ADMIN','ADMIN_RADIOGRAPHER','ADMIN_ACCOUNTANT','ACCOUNTANT','RADIOGRAPHER','MANAGER'])) --}}
            @if (Auth::user()->hasPermission('Dashboard', 'dsb_overview_panel', 'VIEW'))
                <div class="col-lg-2 mb-lg-0 mb-4">                    
                    <div class="row">
                        <!-- X-Ray Facilities -->
                        <div class="col-md-6 mb-3">
                            <div class="card h-100">
                                <div class="card-header mx-4 p-3 text-center">
                                    <div class="d-flex flex-column align-items-center justify-content-center">
                                        <div class="icon icon-shape icon-lg bg-primary shadow text-center border-radius-lg mb-2">
                                            <i class="fas fa-hospital opacity-10"></i>
                                        </div>
                                        <span class="fw-bold h4 mb-0">{{ @$xray_facility }}</span>
                                    </div>
                                </div>
                                <div class="card-body pt-0 p-3 text-center">
                                    <p class="text-xs text-muted mb-0">
                                        <i class="fas fa-check text-success"></i> {{ @$xray_facility_active }}
                                    </p>
                                </div>
                            </div>
                        </div>

                        <!-- Radiologist -->
                        <div class="col-md-6 mb-3">
                            <div class="card h-100">
                                <div class="card-header mx-4 p-3 text-center">
                                    <div class="d-flex flex-column align-items-center justify-content-center">
                                        <div class="icon icon-shape icon-lg bg-primary shadow text-center border-radius-lg mb-2">
                                            <i class="fas fa-user-md opacity-10"></i>
                                        </div>
                                        <span class="fw-bold h4 mb-0">{{ @$radiologist }}</span>
                                    </div>
                                </div>
                                <div class="card-body pt-0 p-3 text-center">
                                    <p class="text-xs text-muted mb-0">&nbsp;</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- PIECHART -->
                    <div class="col mt-2">
                    <div class="card">			    
                        <canvas id="xrayPieChart" height="200"></canvas>
                    </div>
                    </div>
                </div>
            @endif
            <script>
                window.chartLabels = {
                    total_completed: "{{ ui_label('dsb_graph1_complete') }}",
                    completed_late: "{{ ui_label('dsb_graph1_late') }}",
                    completed_ontime: "{{ ui_label('dsb_graph1_ontime') }}",
                    number_of_cases_y: "{{ ui_label('dsb_graph1_y') }}",
                    month_x: "{{ ui_label('dsb_graph1_x') }}",
                    case_upload: "{{ ui_label('dsb_graph2_upload') }}",
                    image_view: "{{ ui_label('dsb_graph2_view') }}",
                    total_y: "{{ ui_label('dsb_graph2_y') }}",
                    daily_x: "{{ ui_label('dsb_graph2_x') }}"
                };
            </script>

             @php
                $chartOvwSection = Auth::user()->hasPermission('Dashboard', 'dsb_overview_panel', 'VIEW')
                    ? 'col-lg-5' : 'col-lg-6';
            @endphp

            <!-- GRAPH 1 : TOTAL SERVICE -->
            {{-- @if (!auth()->user()->hasRoles(['REGISTER','REFERRING'])) --}}
                {{-- <div class=" {{ auth()->user()->hasRoles(['MASTER_ADMIN','ADMIN_RADIOGRAPHER','ADMIN_ACCOUNTANT','ACCOUNTANT','RADIOGRAPHER','MANAGER']) ? 'col-lg-5' : 'col-lg-6' }}  mb-lg-0 mb-4">  --}}
            @if (Auth::user()->hasPermission('Dashboard', 'dsb_graph_service_monthly', 'VIEW')) 
                <div class="{{  $chartOvwSection }} mb-lg-0 mb-4">
                    <div class="card z-index-2 h-100">
                        <div class="card-header pb-0 pt-3 bg-transparent">
                            <!--<h6 class="mb-2">Total Service Completed by Month</h6>-->
                            <h6 class="mb-2">{{ui_label('dsb_graph1_title')}}</h6>
                            
                            <!--<span class="text-info text-sm font-weight-bolder">For last {{ $month }} months </span>-->
                        </div>
                        <div class="card-body p-3">
                            <div class="chart">
                                <canvas id="chart-line" class="chart-canvas" height="300"></canvas>
                            </div>
                        </div>
                    </div>
                </div>
            @endif
                <!-- GRAPH 2 : VS -->
                {{-- <div class=" {{ auth()->user()->hasRoles(['MASTER_ADMIN','ADMIN_RADIOGRAPHER','ADMIN_ACCOUNTANT','ACCOUNTANT','RADIOGRAPHER','MANAGER']) ? 'col-lg-5' : 'col-lg-6' }} mb-lg-0 mb-4">  --}}
            @if (Auth::user()->hasPermission('Dashboard', 'dsb_graph_upload_view_daily', 'VIEW'))  
                <div class="{{ $chartOvwSection }} mb-lg-0 mb-4">
                    <div class="card z-index-2 h-100">
                        <div class="card-header pb-0 pt-3 bg-transparent">
                            <!--<h6 class="mb-2">Upload Case vs Image View</h6>-->
                            <h6 class="mb-2">{{ui_label('dsb_graph2_title')}}</h6>
                            <!--<span class="text-info text-sm font-weight-bolder">For last {{ $month }} months </span>-->
                        </div>
                        <div class="card-body p-3">
                            <div class="chart">
                                <canvas id="chart-line-daily" class="chart-canvas" height="300"></canvas>
                            </div>
                        </div>
                    </div>
                </div>
            @endif
            
        </div>

        {{-- @if(count($ads) > 0)
        <div class="ads-wrapper">
            @if(count($ads) >= 4)
                <button class="arrow left" onclick="scrollAds(-1)">&#10094;</button>
            @endif 
            
            <div class="ads-container" id="adsContainer">
                @foreach($ads as $ad)
                    <div class="ad-item">
                        @if(!empty($ad['url']))
                            {{-- <a href="{{ $ad['url'] }}" target="_blank">
                                <img src="{{ asset($ad['src']) }}" alt="Advertisement">
                            </a>--}}
                            {{-- <a href="{{ $ad['url'] }}" target="_blank">
                                <img src="{{ $ad['src'] }}" alt="Advertisement">
                            </a>
                        @else --}}
                            {{-- <img src="{{ asset($ad['src']) }}" alt="Advertisement">--}}
                            {{-- <img src="{{ $ad['src'] }}" alt="Advertisement">
                        @endif
                    </div>
                @endforeach --}}

                {{-- Desktop only: if fewer than 4 ads, pad with blanks --}}
                {{-- @if(count($ads) < 4)
                    @for($i = count($ads); $i < 4; $i++)
                        <div class="ad-item placeholder"></div>
                    @endfor
                @endif
            </div>
            
            @if(count($ads) >= 4)
                <button class="arrow right" onclick="scrollAds(1)">&#10095;</button>
            @endif 
        </div>
        @endif --}}

        <!-- SUMMARY -->
        {{-- @if (!auth()->user()->hasRoles(['XRAY_FACILITY','SECONDARY','REGISTER','REFERRING'])) --}}
        @if (Auth::user()->hasPermission('Dashboard', 'dsb_summary_table', 'VIEW'))
            <div class="row mt-1">
                <div class="col-lg-12 mb-lg-0 mb-4">
                    <div class="card">
                        <div class="card-header pb-0 p-3">
                            <!--<h6 class="mb-2">Summary By Radiologist / Cardiologist</h6>-->
                            <h6 class="mb-2">{{ui_label('dsb_summary_rad')}}</h6>
                            <!--<span class="text-body text-sm font-weight-normal">For last {{ $month }} months </span>-->
                            <span class="text-body text-sm font-weight-normal">{{ui_label('dsb_forlast')}} {{ $month }} {{ui_label('dsb_months')}} </span>
                        </div>
                        <div class="card-body p-3">
                            <div class="table-responsive p-0">
                                <table class="table table-scroll">
                                    <thead>
                                        <tr>
                                            <th>
                                                <!--<h6 class="text-white text-xxs font-weight-bolder text-start">Name</h6>-->
                                                <h6 class="text-white text-xxs font-weight-bolder text-start">{{ui_label('dsb_name_rad')}}</h6>
                                            </th>
                                            <th>
                                                <h6 class="text-white text-xxs font-weight-bolder">Assigned / Redo</h6>
                                            </th>
                                            <th>
                                                <h6 class="text-white text-xxs font-weight-bolder">Final</h6>
                                            </th>
                                        </tr>
                                    </thead>
                                        @php
                                            $total_assign = $total_final = 0;
                                        @endphp
                                    <tbody>
                                        @foreach ($summary_radiologist as $data)
                                            @php
                                                $total_assign += $data->assign;
                                                $total_final += $data->final_report;
                                            @endphp
                                            <tr>
                                                <td>
                                                    <h6 class="text-xs mb-0 font-weight-normal">{{ $data->radiologist_name }}</h6>
                                                </td>
                                                <td>
                                                    <h6 class="text-sm mb-0 text-center font-weight-normal">{{ $data->assign }}</h6>
                                                </td>
                                                <td>
                                                    <h6 class="text-sm mb-0 text-center font-weight-normal">{{ number_format($data->final_report,0,'.',',') }}</h6>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                    <tfoot>
                                        <tr>
                                            <td>
                                                <!--<h6 class="text-xs mb-0 text-uppercase font-weight-bolder">Total</h6>-->
                                                <h6 class="text-xs mb-0 text-uppercase font-weight-bolder">{{ui_label('dsb_total')}}</h6>
                                            </td>
                                            <td>
                                                <h6 class="text-sm mb-0 text-center font-weight-bolder">{{ $total_assign }}</h6>
                                            </td>
                                            <td>
                                                <h6 class="text-sm mb-0 text-center font-weight-bolder">{{ number_format($total_final,0,'.',',')}}</h6>
                                            </td>
                                        </tr>
                                    </tfoot>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endif

        {{-- @if (auth()->user()->notice_at != null) --}}
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
        <script>
        document.addEventListener('DOMContentLoaded', function() {
            Swal.fire({
            title: 'PAYMENT REMINDER',
            html: 'You have pending payment. Please log into <a href="http://www.nrmedical.net" target="_blank" style="color: #007bff; text-decoration: underline;">www.nrmedical.net</a> to check status. Kindly ignore this notice if payment has been made.',
            confirmButtonText: 'Close',
            customClass: {
                title: 'swal2-title-custom'
            }
            });
        });
        </script>
        {{-- @endif --}}

        <style>
        .swal2-title-custom {
            font-size: 14px !important;
            font-weight: bold !important;
            color: #2c3e50 !important;
        }
        </style>

            {{-- @include('layouts.footers.auth.footer') --}}
    </div>
@endsection
@push('js')
    <script>
        const get_summary_month = {!! json_encode($summary_monthly) !!};
    </script>
    <script src="{{ asset('assets/js/chart-dashboard.js') }}"> </script>

   <script>
        const get_summary_daily = {!! json_encode($summary_month_daily) !!};
    </script>
    <script src="{{ asset('assets/js/chart-dashboard-daily.js') }}"> </script>

    <script>
        const get_xray_types = {
            CR: {{ $xray_cr }},
            DX: {{ $xray_dx }},
            MG: {{ $xray_mg }},
            US: {{ $xray_us }},
            CT: {{ $xray_ct }},
            MR: {{ $xray_mr }}
        };
    </script>
    <script src="{{ asset('assets/js/chart-dashboard-xray.js') }}"></script>

    <script>
    function scrollAds(direction) {
        const container = document.getElementById('adsContainer');  
        const item = container.querySelector('.ad-item');
        if (!item) return;

        const itemWidth = item.clientWidth + 10; // include margin/gap
        container.scrollBy({
            left: direction * itemWidth,
            behavior: 'smooth'
        });
    }
    </script>
@endpush
