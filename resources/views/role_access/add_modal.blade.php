<div class="modal fade" id="addRoleAccessModal" tabindex="-1" aria-hidden="true"
    data-store-module-url="{{ route('module-config.store-module') }}"
    data-store-function-url="{{ route('module-config.store-function') }}">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Add New Role Access</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                </button>
            </div>
            <form action="{{ route('role-access.store') }}" method="POST">
                @csrf
                <div class="modal-body">
                     @if ($errors->any())
                        <<div class="alert d-flex align-items-center py-2 px-3 mb-3" role="alert"
                            style="background-color:#fdecea; border:1px solid #f5c2c0; color:#5a2a2a; border-radius:6px;">
                            <i class="fas fa-exclamation-circle me-2" style="color:#e57373;"></i>
                            <span class="text-xs">{{ $errors->first() }}</span>
                        </div>
                    @endif
                    <div class="row">
                        {{-- 1. Role Selection --}}
                        <div class="col-md-12">
                            <div class="form-group">
                                <label class="form-control-label">Roles<span class="text-danger">*</span></label>
                                <select name="role_id" class="form-select" required>
                                    <option value="">Choose Role</option>
                                    @foreach($roles as $role)
                                        <option value="{{ $role->id }}">{{ $role->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        {{-- 2. Module Selection --}}
                        <div class="mb-3">
                            <label for="module_id" class="form-label">Module<span class="text-danger">*</span></label>
                            <select class="form-select" id="module_id" name="module_id" required>
                                <option value="" selected disabled>Choose Module</option>
                                @foreach($modules as $module)
                                    <option value="{{ $module->id }}">{{ $module->module_name }}</option>
                                @endforeach
                            </select>
                        </div>


                        <!-- Add New Module inline toggle -->
                        <div class="col-md-12 mb-3">
                            <a href="#" class="text-primary text-xs" id="toggleAddModule">
                                <i class="fa fa-plus-circle me-1"></i>Add new module
                            </a>
                            <div id="addModuleInline" class="mt-2" style="display:none;">
                                <div class="input-group input-group-sm">
                                    <input type="text" id="newModuleName" class="form-control text-xs"
                                           placeholder="e.g. Patient, Imaging, Reporting">
                                    <button type="button" class="btn btn-success btn-sm" id="btnSaveModule">
                                        <i class="fa fa-save me-1"></i>Save
                                    </button>
                                    <button type="button" class="btn btn-outline-secondary btn-sm" id="btnCancelModule">
                                        Cancel
                                    </button>
                                </div>
                                <div id="moduleMsg" class="text-xs mt-1"></div>
                            </div>
                        </div>


                        {{-- 3. Function Access Selection --}}
                        <div class="mb-3">
                            <label for="function_module_id" class="form-label">Function Access<span class="text-danger">*</span></label>
                            <select class="form-select" id="function_module_id" name="function_module_id" required disabled>
                                <option value="" selected disabled>Select a Module first</option>
                            </select>
                        </div>

                        <!-- Add New Function inline toggle -->
                        <div class="col-md-12 mb-3">
                            <a href="#" class="text-primary text-xs" id="toggleAddFunction">
                                <i class="fa fa-plus-circle me-1"></i>Add new function access
                            </a>
                            <div id="addFunctionInline" class="mt-2" style="display:none;">
                                <!-- Module selector for the new function -->
                                <div class="mb-2">
                                    <select class="form-select form-select-sm text-xs" id="newFunctionModuleId">
                                        <option value="" disabled selected>Select module for this function</option>
                                        @foreach($modules as $module)
                                            <option value="{{ $module->id }}">{{ $module->module_name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="input-group input-group-sm">
                                    <input type="text" id="newFunctionName" class="form-control text-xs"
                                           placeholder="e.g. pat_view_list, img_btn_upload">
                                    <button type="button" class="btn btn-success btn-sm" id="btnSaveFunction">
                                        <i class="fa fa-save me-1"></i>Save
                                    </button>
                                    <button type="button" class="btn btn-outline-secondary btn-sm" id="btnCancelFunction">
                                        Cancel
                                    </button>
                                </div>
                                <div id="functionMsg" class="text-xs mt-1"></div>
                            </div>
                        </div>

                        {{-- 4. Permission Level --}}
                        <div class="col-md-12 mt-3">
                            <div class="form-group">
                                <label class="form-control-label">Permission Level<span class="text-danger">*</span></label>
                                <select name="permission" class="form-select" required>
                                     <option value="" disabled selected>Select Permission</option>
                                    <option value="VIEW">VIEW</option>
                                    <option value="EDIT">EDIT</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-primary">Save Access</button>
                    </div>  
                </div>
            </form>
        </div>
    </div>
</div>

