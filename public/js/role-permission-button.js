document.addEventListener('DOMContentLoaded', function () {

    const fetchFunctions = (moduleId, targetSelect) => {
        targetSelect.innerHTML = '<option value="">Loading...</option>';
        targetSelect.disabled = true;

        fetch(`/get-functions-by-module/${moduleId}`)
            .then(response => response.json())
            .then(data => {
                targetSelect.innerHTML = '<option value="" selected disabled>Choose Function</option>';
                data.forEach(func => {
                    const option = document.createElement('option');
                    option.value = func.id;
                    option.textContent = `${func.function_name}`;
                    targetSelect.appendChild(option);
                });
                targetSelect.disabled = false;
            })
            .catch(error => {
                console.error('Error:', error);
                targetSelect.innerHTML = '<option value="">Error loading functions</option>';
            });
    };

    // PART ADD MODAL 
    const addModuleSelect = document.getElementById('module_id');
    const addFunctionSelect = document.getElementById('function_module_id');
    if (addModuleSelect) {
        addModuleSelect.addEventListener('change', function() {
            fetchFunctions(this.value, addFunctionSelect);
        });
    }

    // PART EDIT MODALS 
    document.querySelectorAll('.edit-module-select').forEach(select => {
        select.addEventListener('change', function() {
            
            const assignmentId = this.getAttribute('data-assignment-id');
            const targetFunctionSelect = document.getElementById(`edit_function_${assignmentId}`);
            fetchFunctions(this.value, targetFunctionSelect);
        });
    });
});


