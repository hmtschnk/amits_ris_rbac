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
                console.error('Error fetching functions:', error);
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

// document.addEventListener('DOMContentLoaded', function () {

//     const fetchFunctions = (moduleId, targetSelect, selectedFunctionId = null) => {
//         targetSelect.innerHTML = '<option value="">Loading...</option>';
//         targetSelect.disabled = true;

//         fetch(`/get-functions-by-module/${moduleId}`)
//             .then(response => {
//                 if (!response.ok) throw new Error(`HTTP error: ${response.status}`);
//                 return response.json();
//             })
//             .then(data => {
//                 // Clear and reset
//                 targetSelect.innerHTML = '<option value="" disabled>Choose Function</option>';

//                 if (data.length === 0) {
//                     targetSelect.innerHTML = '<option value="" disabled>No functions found</option>';
//                     return;
//                 }

//                 data.forEach(func => {
//                     const option = document.createElement('option');
//                     option.value = func.id;
//                     option.textContent = func.function_name;

//                     // Pre-select if editing
//                     if (selectedFunctionId && func.id == selectedFunctionId) {
//                         option.selected = true;
//                     }
//                     targetSelect.appendChild(option);
//                 });

//                 // If nothing was pre-selected, set placeholder as selected
//                 if (!selectedFunctionId) {
//                     targetSelect.querySelector('option').selected = true;
//                 }

//                 targetSelect.disabled = false;
//             })
//             .catch(error => {
//                 console.error('Error fetching functions:', error);
//                 targetSelect.innerHTML = '<option value="">Error loading functions</option>';
//                 targetSelect.disabled = false;
//             });
//     };

//     // ── ADD MODAL ──────────────────────────────────────────────
//     const addModuleSelect = document.getElementById('module_id');
//     const addFunctionSelect = document.getElementById('function_module_id');

//     if (addModuleSelect && addFunctionSelect) {
//         addModuleSelect.addEventListener('change', function () {
//             if (this.value) {
//                 fetchFunctions(this.value, addFunctionSelect);
//             } else {
//                 addFunctionSelect.innerHTML = '<option value="" disabled selected>Select a Module first</option>';
//                 addFunctionSelect.disabled = true;
//             }
//         });
//     }

//     // ── EDIT MODALS ────────────────────────────────────────────
//     // On modal open: load correct functions for the current module
//     document.querySelectorAll('[id^="editModal"]').forEach(modal => {
//         modal.addEventListener('show.bs.modal', function () {
//             const moduleSelect = this.querySelector('.edit-module-select');
//             const assignmentId = moduleSelect?.getAttribute('data-assignment-id');
//             const functionSelect = document.getElementById(`edit_function_${assignmentId}`);
//             const currentFunctionId = functionSelect?.getAttribute('data-current-function');

//             if (moduleSelect && moduleSelect.value && functionSelect) {
//                 fetchFunctions(moduleSelect.value, functionSelect, currentFunctionId);
//             }
//         });
//     });

//     // On module change inside edit modal: reload functions, no pre-selection
//     document.querySelectorAll('.edit-module-select').forEach(select => {
//         select.addEventListener('change', function () {
//             const assignmentId = this.getAttribute('data-assignment-id');
//             const functionSelect = document.getElementById(`edit_function_${assignmentId}`);
//             if (functionSelect && this.value) {
//                 fetchFunctions(this.value, functionSelect); // no pre-selection
//             }
//         });
//     });
// });
