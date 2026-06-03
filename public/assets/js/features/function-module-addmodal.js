(function () {

    // ── Read URLs from data attributes (set in blade, no {{ }} in JS) ──
    // 
    
    var modal = document.getElementById('addRoleAccessModal');
    if (!modal) return; // safety guard

    var storeModuleUrl   = modal.getAttribute('data-store-module-url');
    var storeFunctionUrl = modal.getAttribute('data-store-function-url');
    var CSRF             = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

    // ── Helper: show success / error message ──────────────────────────
    function showMsg(el, text, isError) {
        el.textContent = text;
        el.style.color = isError ? '#dc3545' : '#28a745';
    }

    // ── Helper: append a new <option> to a <select> ───────────────────
    function addOption(selectEl, id, text, selectIt) {
        var opt = new Option(text, id, selectIt, selectIt);
        selectEl.append(opt);
    }

    // ─────────────────────────────────────────────────────────────────
    // TOGGLE: Add New Module inline box
    // ─────────────────────────────────────────────────────────────────
    document.getElementById('toggleAddModule').addEventListener('click', function (e) {
        e.preventDefault();
        var box = document.getElementById('addModuleInline');
        box.style.display = box.style.display === 'none' ? 'block' : 'none';
        document.getElementById('newModuleName').value   = '';
        document.getElementById('moduleMsg').textContent = '';
    });

    document.getElementById('btnCancelModule').addEventListener('click', function () {
        document.getElementById('addModuleInline').style.display = 'none';
    });

    // ─────────────────────────────────────────────────────────────────
    // SAVE: New Module via AJAX
    // ─────────────────────────────────────────────────────────────────
    document.getElementById('btnSaveModule').addEventListener('click', function () {
        var nameInput = document.getElementById('newModuleName');
        var msgEl     = document.getElementById('moduleMsg');
        var name      = nameInput.value.trim();

        if (!name) {
            showMsg(msgEl, 'Module name cannot be empty.', true);
            return;
        }

        fetch(storeModuleUrl, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': CSRF,
                'Accept':       'application/json',
            },
            body: JSON.stringify({ name: name }),
        })
        .then(function (r) { return r.json(); })
        .then(function (data) {
            if (data.success) {
                // Add new module to BOTH dropdowns
                var addModuleSel     = document.getElementById('module_id');
                var newFuncModuleSel = document.getElementById('newFunctionModuleId');

                addOption(addModuleSel,     data.module.id, data.module.name, true);
                addOption(newFuncModuleSel, data.module.id, data.module.name, false);

                // Trigger function list reload for the newly selected module
                addModuleSel.dispatchEvent(new Event('change'));

                showMsg(msgEl, data.message, false);
                nameInput.value = '';

                setTimeout(function () {
                    document.getElementById('addModuleInline').style.display = 'none';
                    msgEl.textContent = '';
                }, 1500);

            } else {
                var errors = data.errors
                    ? Object.values(data.errors).flat().join(' ')
                    : 'Failed to save module.';
                showMsg(msgEl, errors, true);
            }
        })
        .catch(function () {
            showMsg(msgEl, 'Server error. Please try again.', true);
        });
    });

    // ─────────────────────────────────────────────────────────────────
    // TOGGLE: Add New Function Access inline box
    // ─────────────────────────────────────────────────────────────────
    document.getElementById('toggleAddFunction').addEventListener('click', function (e) {
        e.preventDefault();
        var box = document.getElementById('addFunctionInline');
        box.style.display = box.style.display === 'none' ? 'block' : 'none';
        document.getElementById('newFunctionName').value   = '';
        document.getElementById('functionMsg').textContent = '';

        // Pre-select whatever module is already chosen in main dropdown
        var chosenModuleId = document.getElementById('module_id').value;
        if (chosenModuleId) {
            document.getElementById('newFunctionModuleId').value = chosenModuleId;
        }
    });

    document.getElementById('btnCancelFunction').addEventListener('click', function () {
        document.getElementById('addFunctionInline').style.display = 'none';
    });

    // ─────────────────────────────────────────────────────────────────
    // SAVE: New Function Access via AJAX
    // ─────────────────────────────────────────────────────────────────
    document.getElementById('btnSaveFunction').addEventListener('click', function () {
        var moduleIdEl = document.getElementById('newFunctionModuleId');
        var nameInput  = document.getElementById('newFunctionName');
        var msgEl      = document.getElementById('functionMsg');
        var moduleId   = moduleIdEl.value;
        var funcName   = nameInput.value.trim();

        if (!moduleId) {
            showMsg(msgEl, 'Please select a module.', true);
            return;
        }
        if (!funcName) {
            showMsg(msgEl, 'Function name cannot be empty.', true);
            return;
        }

        fetch(storeFunctionUrl, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': CSRF,
                'Accept':       'application/json',
            },
            body: JSON.stringify({ module_id: moduleId, function_name: funcName }),
        })
        .then(function (r) { return r.json(); })
        .then(function (data) {
            if (data.success) {
                var funcSel         = document.getElementById('function_module_id');
                var currentModuleId = document.getElementById('module_id').value;

                // Only add to visible function dropdown if same module is selected
                if (String(data.function.module_id) === String(currentModuleId)) {
                    funcSel.disabled = false;
                    addOption(funcSel, data.function.id, data.function.function_name, true);
                }

                showMsg(msgEl, data.message, false);
                nameInput.value = '';

                setTimeout(function () {
                    document.getElementById('addFunctionInline').style.display = 'none';
                    msgEl.textContent = '';
                }, 1500);

            } else {
                var errors = data.errors
                    ? Object.values(data.errors).flat().join(' ')
                    : 'Failed to save function.';
                showMsg(msgEl, errors, true);
            }
        })
        .catch(function () {
            showMsg(msgEl, 'Server error. Please try again.', true);
        });
    });

    // ─────────────────────────────────────────────────────────────────
    // EXISTING: Module → load Function Access dropdown via AJAX
    // ─────────────────────────────────────────────────────────────────
    document.getElementById('module_id').addEventListener('change', function () {
        var moduleId = this.value;
        var funcSel  = document.getElementById('function_module_id');

        funcSel.innerHTML = '<option value="" disabled selected>Loading...</option>';
        funcSel.disabled  = true;

        fetch('/get-functions-by-module/' + moduleId)
            .then(function (r) { return r.json(); })
            .then(function (functions) {
                funcSel.innerHTML = '<option value="" disabled selected>Select Function Access</option>';
                if (functions.length === 0) {
                    funcSel.innerHTML = '<option value="" disabled selected>No functions — add one below</option>';
                } else {
                    functions.forEach(function (f) {
                        addOption(funcSel, f.id, f.function_name, false);
                    });
                    funcSel.disabled = false;
                }
            })
            .catch(function () {
                funcSel.innerHTML = '<option value="" disabled selected>Error loading functions</option>';
            });
    });


})();


