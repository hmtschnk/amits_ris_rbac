
@extends('layouts.app', ['class' => 'g-sidenav-show bg-gray-100'])
 @section('content') 
<div class="row mt-2 mx-4">

    <div class="col-12">
        <div class="card mb-4">
            <div class="card-header pb-0">
                    <form name="filter_form" role="form" method="GET" action="{{ route('role-access.index') }}"> 
                        @csrf
                        <div class="row">
                            <label class="form-control-label">Records Filter</label>

                            {{-- Filter Search Section 1. Role Dropdown --}}

                            @if($showRoles)
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label class="form-control-label text-xs mb-1">Role</label>
                                    <select name="role_id" class="form-select form-select-sm">
                                        <option value="" disabled @if(empty($search['role_id'])) selected @endif>Select Role</option>
                                        <option value="">All Roles</option>
                                        @foreach($roles as $role)
                                            <option value="{{ $role->id }}" @if(@$search['role_id'] == $role->id) selected @endif>
                                                {{ $role->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            @endif
                            {{-- 2. Module Dropdown --}}
                            @if($showModules)
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label class="form-control-label text-xs mb-1">Module</label>
                                    <select name="module_id" class="form-select form-select-sm">
                                        <option value="" disabled @if(empty($search['module_id'])) selected @endif>Select Module</option>
                                        <option value="">All Modules</option>
                                        @foreach($modules as $module)
                                            <option value="{{ $module->id }}" @if(@$search['module_id'] == $module->id) selected @endif>
                                                {{ $module->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            @endif
                            {{-- 3. Function Dropdown --}}
                            @if($showFunctions)
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label class="form-control-label text-xs mb-1">Function Access</label>
                                    <select name="function_id" class="form-select form-select-sm">
                                        <option value="" disabled @if(empty($search['function_id'])) selected @endif>Select Function</option>
                                        <option value="">All Functions</option>
                                        @foreach($functions as $func)
                                            <option value="{{ $func->id }}" @if(@$search['function_id'] == $func->id) selected @endif>
                                                {{ $func->function_name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            @endif

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
                        </div>
                        <div class="d-flex justify-content-end gap-1">
                        
                            <button type="submit" name="submit" value="reset" 
                                class="btn btn-outline-primary btn-sm px-3 d-flex align-items-center">
                                <i class="fas fa-undo me-2"></i>Reset
                            </button>
                                
                            
                            <button type="submit" name="submit" value="search" 
                                class="btn btn-primary btn-sm px-3 d-flex align-items-center">
                                <i class="fas fa-search me-2"></i>Search
                            </button>
                                
                            
                            <button type="button" 
                                class="btn btn-success btn-sm px-3 d-flex align-items-center" 
                                data-bs-toggle="modal" 
                                data-bs-target="#addRoleAccessModal">
                                <i class="fas fa-plus me-2"></i>Add
                            </button>
                        </div>
                    </form>

{{--TABLE COLUMNS--}}
        </div>
            <div class="card-body px-0 pt-0 pb-2">
                <div class="table-responsive p-0"  style="min-height: 400px;">
                    <table class="table table-scroll table-striped mb-0">
                        <thead>
                            <tr>
                                <th width="5%" class="text-uppercase text-white text-xxs font-weight-bolder text-center">#</th>
                                <th class="text-uppercase text-white text-xxs font-weight-bolder text-center">Role</th>
                                <th class="text-uppercase text-white text-xxs font-weight-bolder text-center">Module</th>
                                <th class="text-uppercase text-white text-xxs font-weight-bolder text-center">Function Access</th>
                                <th class="text-uppercase text-white text-xxs font-weight-bolder">Permission</th>
                                <th class="text-uppercase text-white text-xxs font-weight-bolder text-center">Action</th>
                            </tr>
                        </thead>

{{--TABLE BODY DATA VALUE--}}
                        <tbody>
                            @forelse($assignments as $index => $assignment)
                            <tr>
                                {{-- Row Numbering --}}
                                <td
                                    class ="mb-0 text-center text-secondary text-xs">{{ $index + 1 }}
                                </td>
                                
                                
                                {{-- Data from Roles Table --}}
                                <td 
                                    class="mb-0 text-center text-secondary text-xs">{{ $assignment->roles->name }}
                                </td>
                                
                                {{-- Data from Module Table --}}
                                <td 
                                    class="mb-0 text-center text-secondary text-xs">{{ $assignment->functionModule->modules->name }}
                                </td>

                                {{-- Data from FunctionModule Table --}}
                                <td 
                                    class="mb-0 text-center text-secondary text-xs">{{ $assignment->functionModule->function_name }}
                                </td>
                                
                                {{-- Permission Status with Badge --}}
                                <td class="text-center">
                                    <span class="badge badge-sm bg-gradient-success">{{ $assignment->permission }}</span> 
                                </td>
                                
 {{-- ACTION BUTTON --}}
                                <td class="text-center">
                                    <div class="d-flex justify-content-center gap-1">
                                            <button type="button" 
                                                class="btn btn-icon-only btn-rounded btn-info btn-sm d-flex align-items-center justify-content-center"
                                                data-bs-toggle="modal" 
                                                data-bs-target="#editModal{{ $assignment->id }}"
                                                data-toggle="tooltip" title="Edit/View">
                                                <i class="fas fa-edit text-xs"></i>
                                            </button>

                                            <button type="button" 
                                                class="btn btn-icon-only btn-rounded btn-danger btn-sm d-flex align-items-center justify-content-center"
                                                data-bs-toggle="modal" 
                                                data-bs-target="#deleteModal{{ $assignment->id }}"
                                                data-toggle="tooltip" title="Delete">
                                                <i class="fas fa-trash text-xs"></i>
                                            </button>
                                    </div>
                                </td>
                            </tr>
                            
                                @include('role_access.edit_modal', ['assignment' => $assignment])
                                @include('role_access.delete_modal', ['assignment' => $assignment])

                             @empty
                                <tr>
                                    <td colspan="6">
                                        <p class="text-xs mb-0 text-center">No records found</p>
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

@include('role_access.add_modal')
<script src="{{ asset('js/role-permission-button.js') }}"></script>
@endsection
                                    
                                    
