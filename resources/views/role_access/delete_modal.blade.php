<div class="modal fade" id="deleteModal{{ $assignment->id }}" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" style="max-width: 400px;">
        <div class="modal-content border-radius-md shadow-lg border-0">

            <div class="modal-header border-bottom">
                <div class="d-flex align-items-center">
                    <i class="fas fa-exclamation-triangle text-danger me-2" style="font-size: 1.5rem;"></i>
                    <h5 class="mb-0 fw-bold text-primary">Confirm Deletion</h5>
                </div>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <div class="modal-body text-center"> 
                    <p class="text-secondary mb-1">
                        Are you sure you want to remove access for</p>
                    <p class="mb-1">
                    <span class="fw-bold text-secondary">
                        {{ $assignment->roles->name }}
                    </span>
                    <span class="text-secondary">
                        from the
                    </span>
                    <span class="fw-bold text-secondary">
                        {{ $assignment->functionModule->function_name }}
                    </span>
                </p>
            </div>
        
            <div class="modal-footer border-0 justify-content-end pt-0">
                <button type="button" class="btn btn-sm btn-secondary" data-bs-dismiss="modal">
                    Cancel
                </button>

                <form action="{{ route('role-access.destroy', $assignment->id) }}" method="POST">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-sm btn-danger">
                        Delete
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
