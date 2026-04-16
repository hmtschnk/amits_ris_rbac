<div class="modal fade" id="addRoleAccessModal" tabindex="-1" aria-hidden="true">
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
                    <div class="row">
                        {{-- 1. Role Selection --}}
                        <div class="col-md-12">
                            <div class="form-group">
                                <label class="form-control-label">Roles <span class="text-danger">*</span></label>
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
                            <label for="module_id" class="form-label">Module</label>
                            <select class="form-select" id="module_id" name="module_id" required>
                                <option value="" selected disabled>Choose Module</option>
                                @foreach($modules as $module)
                                    <option value="{{ $module->id }}">{{ $module->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        {{-- 3. Function Access Selection --}}
                        <div class="mb-3">
                            <label for="function_module_id" class="form-label">Function Access</label>
                            <select class="form-select" id="function_module_id" name="function_module_id" required disabled>
                                <option value="" selected disabled>Select a Module first</option>
                            </select>
                        </div>
                        {{-- 4. Permission Level --}}
                        <div class="col-md-12 mt-3">
                            <div class="form-group">
                                <label class="form-control-label">Permission Level <span class="text-danger"></span></label>
                                <select name="permission" class="form-select" required>
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