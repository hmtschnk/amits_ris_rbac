<?php

namespace App\Http\Controllers;

use App\Models\Roles;
use App\Models\Modules;
use App\Models\FunctionModule;
use App\Models\Assignment;
use Illuminate\Http\Request;

class RolePermissionController extends Controller
{
        public function index(Request $request)
    {

        if ($request->input('submit') == 'reset') {
            return redirect()->route('role-access.index'); 
        }

        $search = [
            'role_id'       => $request->input('role_id'),
            'module_id'   => $request->input('module_id'),
            'function_id' => $request->input('function_id'),
            'permission'    => $request->input('permission'),
        ];
        
        $showRoles = true;
        $showModules = true;
        $showFunctions = true;

        $roles = Roles::all(); 
        $modules = Modules::all();
        $functions = FunctionModule::all();
        $query = Assignment::with(['roles', 'functionModule.modules'])->orderBy('id', 'asc');

        //Record Filter each column
        if ($search['role_id']) {
            $query->where('role_id', $search['role_id']);
        }

        if ($search['module_id']) {
            $query->whereHas('functionModule', function($q) use ($search) {
                $q->where('module_id', $search['module_id']);
            });
        }

        if ($search['function_id']) {
            $query->where('function_module_id', $search['function_id']);
        }

        
        if ($search['permission']) {
            $query->where('permission', 'like', '%' . $search['permission']);
        }

        $assignments = $query->get();
        
        return view('role_access.index', compact('roles', 'modules', 'functions', 'assignments', 'search',
                                                'showRoles', 'showModules', 'showFunctions')); 
    }

    public function getFunctionsByModule($moduleId)
    
    {
        $functions = FunctionModule::where('module_id', $moduleId)->get();
        return response()->json($functions);
    }

    public function store(Request $request)
    {

        $request->validate([
            'role_id'            => 'required|exists:roles,id',
            'function_module_id' => 'required|exists:function_module,id',
            'permission'         => 'required|in:VIEW,EDIT',
        
        ]);

        Assignment::create([
                'role_id'            => $request->role_id,
                'function_module_id' => $request->function_module_id,
                'permission'         => $request->permission,
            ]);

        return redirect()->route('role-access.index')->with('success', 'Access added successfully!');

    }

        public function update(Request $request, $id)
    {
        $request->validate([
            'role_id'            => 'required|exists:roles,id',
            'function_module_id' => 'required|exists:function_module,id',
            'permission'         => 'required',
        ]);

        $assignment = Assignment::findOrFail($id);

        $assignment->update([
                'role_id'            => $request->role_id,
                'function_module_id' => $request->function_module_id,
                'permission'         => $request->permission,
            ]);
        return redirect()->route('role-access.index')->with('success', 'Access updated successfully!');
        
    }

    public function destroy($id)
    {
        $assignment = Assignment::findOrFail($id);
        $assignment->delete();
        return redirect()->route('role-access.index')->with('success', 'Access deleted successfully!');
    }
    
}