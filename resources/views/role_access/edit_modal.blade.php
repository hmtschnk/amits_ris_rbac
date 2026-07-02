<div class="modal fade" id="editModal{{ $assignment->id }}" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Edit Role Access</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('role-access.update', $assignment->id) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="modal-body">
                     @if ($errors->any())
                        <div class="alert d-flex align-items-center py-2 px-3 mb-3" role="alert"
                            style="background-color:#fdecea; border:1px solid #f5c2c0; color:#5a2a2a; border-radius:6px;">
                            <i class="fas fa-exclamation-circle me-2" style="color:#e57373;"></i>
                            <span class="text-xs">{{ $errors->first() }}</span>
                        </div>
                    @endif
                    <div class="row">
                        {{-- Role Selection--}}
                        <div class="col-md-12 mb-3">   
                            <label class="form-control-label">Select Role <span class="text-danger">*</span></label>
                            <select name="role_id" class="form-select" required>
                                @foreach($roles as $role)
                                    <option value="{{ $role->id }}" {{ $assignment->role_id == $role->id ? 'selected' : '' }}>
                                        {{ $role->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        {{-- 2. Module Selection --}}
                        <div class="col-md-12 mb-3">
                            <label class="form-control-label">Module <span class="text-danger">*</span></label>
                            <select name="module_id" class="form-select edit-module-select" data-assignment-id="{{ $assignment->id }}" required>
                                @foreach($modules as $module)
                                    <option value="{{ $module->id }}" {{ $assignment->functionModule->module_id == $module->id ? 'selected' : '' }}>
                                        {{ $module->module_name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        {{-- 3. Function Access Selection --}}
                        <div class="col-md-12 mb-3">
                            <label class="form-control-label">Function Access <span class="text-danger">*</span></label>
                            <select name="function_module_id" class="form-select edit-function-select" id="edit_function_{{ $assignment->id }}" data-current-function="{{ $assignment->function_module_id }}" required>
                                @foreach($functions->where('module_id', $assignment->functionModule->module_id) as $func)
                                    <option value="{{ $func->id }}" {{ $assignment->function_module_id == $func->id ? 'selected' : '' }}>
                                        {{ $func->function_name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        {{-- 4. Permission Level --}}
                        <div class="col-md-12">    
                            <label class="form-control-label">Permission Level <span class="text-danger">*</span></label>
                            <select name="permission" class="form-select" required>
                                <option value="VIEW" {{ $assignment->permission == 'VIEW' ? 'selected' : '' }}>VIEW</option>
                                <option value="EDIT" {{ $assignment->permission == 'EDIT' ? 'selected' : '' }}>EDIT</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">Update Access</button>
                </div>
            </form>
        </div>
    </div>
</div>