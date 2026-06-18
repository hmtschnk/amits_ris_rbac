@extends('layouts.app', ['class' => 'g-sidenav-show bg-gray-100'])

@section('content')
    @include('layouts.navbars.auth.topnav', ['title' => 'Patient Referrals'])
    <div class="row mt-4 mx-4">
        {{-- @include('components.alert') --}}
        <div class="col-12">
            <div class="card mb-4">
                <div class="card-header pb-0">
                    <form name="filter_form" role="form" method="GET" action="{{ route('patient_referral.listing') }}">
                        @csrf
                        <div class="row">
                            <label class="form-control-label">Records Filter</label>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <input class="form-control form-control-sm" type="text" name="patient_id" 
                                           placeholder="Enter Patient ID" value="{{ @$search['patient_id'] }}">
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <input class="form-control form-control-sm" type="text" name="patient_name" 
                                           placeholder="Enter Patient Name" value="{{ @$search['patient_name'] }}">
                                </div>
                            </div>
                            @if($showReferringClinic)
                            <div class="col-md-3">
                                <div class="form-group">
                                    <select name="referring_clinic_id" class="form-select form-select-sm">
                                          <option value="">Select Referring Clinic</option>
                                        @foreach($referringClinicSel as $key => $value)
                                            <option value="{{ $key }}" 
                                                @if(@$search['referring_clinic_id'] == $key) selected @endif>
                                                {{ $value }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            @endif
                            @if($showXrayPanel)
                            <div class="col-md-3">
                                <div class="form-group">
                                    <select name="xray_panel_id" class="form-select form-select-sm">
                                          <option value="">Select Xray Panel</option>
                                        @foreach($xrayPanelSel as $key => $value)
                                            <option value="{{ $key }}" 
                                                @if(@$search['xray_panel_id'] == $key) selected @endif>
                                                {{ $value }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            @endif
                        </div>
                        <div class="d-flex align-items-center">
                            <button type="submit" name="submit" value="reset" class="btn btn-outline-primary btn-sm ms-auto">
                                <i class="fa fa-undo px-1"></i>Reset
                            </button>
                            <button type="submit" name="submit" value="search" class="btn btn-primary btn-sm mx-1">
                                <i class="fa fa-search px-1"></i>Search
                            </button>
                            @if($showAddButton)
                            <a href="{{ route('patient_referral.create') }}" class="btn btn-success btn-sm">
                                <i class="fa fa-plus px-1"></i>Add
                            </a>
                            @endif
                        </div>
                    </form>
                </div>
                <div class="card-body px-0 pt-0 pb-2">
                    <div class="table-responsive table-height p-0">
                        <table class="table table-scroll table-striped mb-0">
                            <thead>
                                <tr>
                                    <th width="5%" class="text-uppercase text-white text-xxs font-weight-bolder text-center">#</th>
                                    <th class="text-uppercase text-white text-xxs font-weight-bolder">Patient ID</th>
                                    <th class="text-uppercase text-white text-xxs font-weight-bolder">Patient Name</th>
                                    <th class="text-uppercase text-white text-xxs font-weight-bolder text-center">Gender</th>
                                    <th class="text-uppercase text-white text-xxs font-weight-bolder text-center">Age</th>
                                    <th class="text-uppercase text-white text-xxs font-weight-bolder">Referring Clinic</th>
                                    <th class="text-uppercase text-white text-xxs font-weight-bolder">X-ray Panel</th>
                                    <th class="text-uppercase text-white text-xxs font-weight-bolder text-center">Date Created</th>
                                    <th class="text-center text-uppercase text-white text-xxs font-weight-bolder">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($referrals as $key => $referral)
                                <tr>
                                    <td>
                                        <p class="mb-0 text-center text-bold text-xs">{{ ($referrals->currentpage()-1) * $referrals->perpage() + $key + 1 }}</p>
                                    </td>
                                    <td>
                                        <p class="mb-0 text-xs">{{ $referral->patient_id }}</p>
                                    </td>
                                    <td>
                                        <p class="mb-0 text-xs">{{ $referral->patient_name }}</p>
                                    </td>
                                    <td>
                                        <p class="mb-0 text-center text-xs">{{ ucfirst($referral->gender) }}</p>
                                    </td>
                                    <td>
                                        <p class="mb-0 text-center text-xs">{{ $referral->age }}</p>
                                    </td>
                                    <td>
                                        <p class="text-xs mb-0">{{ $referral->referring_clinic ?? 'N/A' }}</p>
                                    </td>
                                    <td>
                                        <p class="text-xs mb-0">{{ $referral->xray_panel ?? 'N/A' }}</p>
                                    </td>
                                    <td>
                                        <p class="mb-0 text-center text-xs">{{ $referral->created_at->format('d/m/Y H:i') }}</p>
                                    </td>
                                    <td>
                                        <div class="d-flex justify-content-center">
                                            <a href="{{ route('patient_referral.edit', $referral->id) }}" 
                                               class="btn btn-icon-only btn-rounded btn-info mb-0 me-1 btn-sm d-flex align-items-center justify-content-center"
                                               data-toggle="tooltip" 
                                               data-placement="top" 
                                               title="{{ $isViewOnly ? 'View Details' : 'View/Edit Details' }}">
                                               <i class="fa {{ $isViewOnly ? 'fa-eye' : 'fa-edit' }}"></i>
                                            </a>

                                            @if (!$isViewOnly)
                                            <a href="{{ route('patient_referral.pdf', $referral->id) }}" 
                                               class="btn btn-icon-only btn-rounded btn-primary mb-0 me-1 btn-sm d-flex align-items-center justify-content-center"
                                               target="_blank"
                                               data-toggle="tooltip" 
                                               data-placement="top" 
                                               title="Print PDF">
                                                <i class="fa fa-print"></i>
                                            </a>
                                            @endif
                                            
                                            @if (!$isViewOnly)
                                            @if($referral->patient_email)
                                                <a href="{{ route('patient_referral.email', $referral->id) }}" 
                                                class="btn btn-icon-only btn-rounded btn-success mb-0 me-1 btn-sm d-flex align-items-center justify-content-center"
                                                data-toggle="tooltip" 
                                                data-placement="top" 
                                                title="Email Patient (attach PDF)">
                                                    <i class="fa fa-envelope"></i>
                                                </a>
                                            @else
                                                <button class="btn btn-icon-only btn-rounded mb-0 me-1 btn-sm d-flex align-items-center justify-content-center"
                                                        style="border: 1px solid #ccc; cursor: not-allowed;"
                                                        disabled
                                                        data-toggle="tooltip" 
                                                        data-placement="top" 
                                                        title="No email available">
                                                    <i class="fa fa-envelope text-secondary"></i>
                                                </button>
                                            @endif
                                            @endif

                                            {{-- @if($showDeleteButton) --}}
                                            @if (Auth::user()->hasPermission('Patient Referral', 'patref_btn_delete', 'EDIT'))
                                            <form action="{{ route('patient_referral.destroy', $referral->id) }}" 
                                                  method="POST" 
                                                  style="display: inline;"
                                                  onsubmit="return confirm('Are you sure you want to delete this referral?');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" 
                                                        class="btn btn-icon-only btn-rounded btn-danger mb-0 btn-sm d-flex align-items-center justify-content-center"
                                                        data-toggle="tooltip" 
                                                        data-placement="top" 
                                                        title="Delete Referral">
                                                    <i class="fa fa-trash"></i>
                                                </button>
                                            </form>
                                            @endif

                                        </div>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="9">
                                        <p class="text-xs mb-0 text-center">No records found</p>
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    <div class="p-2 text-sm">
                        {{ $referrals->withQueryString()->links('pagination::bootstrap-5') }}
                    </div>
                </div>
            </div>
        </div>
    </div>
 
@endsection