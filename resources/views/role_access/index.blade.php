
@extends('layouts.app', ['class' => 'g-sidenav-show bg-gray-100'])
 @section('content') 
 <div class="row mt-4 mx-4">

    <div class="col-12">
        <div class="card mb-4">
            <div class="card-header pb-0">
                    <form method="GET" action="">
                    {{-- <form name="filter_form" role="form" method="GET" action="{{ route('') }}"> --}}
                        @csrf
                        <div class="row">
                            <label class="form-control-label">Records Filter</label>

                        {{-- Filter Card (Search Section)  1. Role Dropdown --}}
                        <div class="col-md-3">
                           <div class="form-group">
                                <label class="form-control-label text-xs mb-1">Role</label>
                                    <select name="role_id" class="form-select form-select-sm">
                                     <option value="">All Roles</option>
                            @foreach($roles as $role)
                            <option value="{{ $role->id }}" {{ $search['role_id'] == $role->id ? 'selected' : '' }}>
                                {{ $role->name }}
                             </option>
                             @endforeach
                         </select>
                     </div>
                </div>

            {{-- 2. Module Name--}}
            <div class="col-md-3">
                <div class="form-group">
                    <label class="form-control-label text-xs mb-1">Module Name</label>
                    <input type="text" name="module_name" class="form-control form-control-sm" 
                           placeholder="e.g. Dashboard" value="{{ $search['module_name'] }}">
                </div>
            </div>

            {{-- 3. Function Name --}}
            <div class="col-md-3">
                <div class="form-group">
                    <label class="form-control-label text-xs mb-1">Function</label>
                    <input type="text" name="function_name" class="form-control form-control-sm" 
                        placeholder="e.g. Create" value="{{ $search['function_name'] }}">
                </div>
            </div>

            {{-- 4. Permission --}}
            <div class="col-md-3">
                <div class="form-group">
                    <label class="form-control-label text-xs mb-1">Permission</label>
                    <select name="permission" class="form-select form-select-sm">
                        <option value="">Select Permission</option>
                        <option value="VIEW" {{ $search['permission'] == 'VIEW' ? 'selected' : '' }}>VIEW</option>
                        <option value="EDIT" {{ $search['permission'] == 'EDIT' ? 'selected' : '' }}>EDIT</option>
                    </select>
                </div>
            </div>


 {{----------------------------------------------- BUTTON ------------------------------------------}}
       <div class="mt-3 d-flex justify-content-end gap-2">
            <button type="submit" name="submit" value="reset" 
                class="btn btn-outline-secondary btn-sm px-4">
                <i class="fa fa-undo me-1"></i>Reset
            </button>
                
               <button type="submit" name="submit" value="search" 
                    class="btn btn-primary btn-sm px-4">
                    <i class="fa fa-search me-1"></i> Search
              </button>
                
            {{-- @if($showAddButton)
            <a href="{{ route('patient-referral-create') }}" class="btn btn-success btn-sm">
                <i class="fa fa-plus px-1"></i>Add
            </a>
            @endif --}}

            <button class="btn btn-success btn-sm px-4">
                <i class="fas fa-plus me-1"></i> Add
            </button>
       </div>
    </div>
    

    <div class="card-body px-0 pt-0 pb-2">
        <div class="table-responsive table-height p-0">
                        <table class="table table-scroll table-striped mb-0">
                    <thead>
                    
                        <tr>
                            <th width="5%" class="text-uppercase text-white text-xxs font-weight-bolder text-center">#</th>
                            <th class="text-uppercase text-white text-xxs font-weight-bolder text-center">Role</th>
                            <th class="text-uppercase text-white text-xxs font-weight-bolder text-center">Module</th>
                            <th class="text-uppercase text-white text-xxs font-weight-bolder text-center">Function Access</th>
                            <th class="text-uppercase text-white text-xxs font-weight-bolder">Permission</th>
                            <th class="text-center text-uppercase text-white text-xxs font-weight-bolder">Action</th>
                        </tr>
                    </thead>

                    <tbody>
                        @foreach($assignments as $index => $assignment)
                        <tr>
                            {{-- Row Numbering --}}
                            <td> 
                                <p class ="mb-0 text-center text-secondary text-xs">{{ $index + 1 }}</p>
                            </td>
                             
                            
                            {{-- Data from Roles Table --}}
                            <td>
                                <p class="mb-0 text-center text-secondary text-xs">{{ $assignment->roles->name }}</p>
                            </td>
                            
                            {{-- Data from FunctionModule Table --}}
                            <td>
                                <p class="mb-0 text-center text-secondary text-xs">{{ $assignment->functionModule->module_name }}</p>
                            </td>
                            <td>
                                <p class="mb-0 text-center text-secondary text-xs">{{ $assignment->functionModule->function_name }}</p>
                            </td>
                            
                            {{-- Permission Status with Badge --}}
                            <td>
                                <span class="badge badge-sm bg-gradient-success">{{ $assignment->permission }}</span> 
                            </td>
                            
{{-- --------------------------------------ACTIONS--------------------------------------------- --}}
                            <td class="text-center align-middle">
                                <div class="d-flex justify-content-center gap-1">
                                    <a href="#" class="btn btn-icon-only btn-rounded btn-info mb-0 me-1 btn-sm d-flex align-items-center justify-content-center">
                                        <i class="fas fa-edit text-xs"></i>
                                    </a>
                                    
                                    <a href="#" class="btn btn-icon-only btn-rounded btn-danger mb-0 btn-sm d-flex align-items-center justify-content-center">
                                        <i class="fas fa-trash text-xs"></i>
                                    </a>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection

    {{-- <td> --}}
                                        {{-- <div class="d-flex justify-content-center">
                                            <a href="{{ route('patient-referral-edit', $referral->id) }}" 
                                               class="btn btn-icon-only btn-rounded btn-info mb-0 me-1 btn-sm d-flex align-items-center justify-content-center"
                                               data-toggle="tooltip" 
                                               data-placement="top" 
                                               title="View/Edit Details">
                                                <i class="fa fa-edit"></i>
                                            </a>

                                            <a href="{{ route('patient-referral-pdf', $referral->id) }}" 
                                               class="btn btn-icon-only btn-rounded btn-primary mb-0 me-1 btn-sm d-flex align-items-center justify-content-center"
                                               target="_blank"
                                               data-toggle="tooltip" 
                                               data-placement="top" 
                                               title="Print PDF">
                                                <i class="fa fa-print"></i>
                                            </a>
                                            
                                            @if($referral->patient_email)
                                                <a href="{{ route('patient-referral-email', $referral->id) }}" 
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

                                            @if($showDeleteButton)
                                            <form action="{{ route('patient-referral-destroy', $referral->id) }}" 
                                         
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

{{-----------------------------------------------------------------------------END EDIT BUTTONS--------------------------------------------------------------------------------}}
{{-- 
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
    @include('layouts.footers.auth.footer')
@endsection --}} 