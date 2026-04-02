<?php

namespace App\Http\Controllers;

use App\Models\Roles;
use App\Models\FunctionModule;
use App\Models\Assignment;
use Illuminate\Http\Request;

class RolePermissionController extends Controller
{
    public function index(Request $request)

{
    $search = [
        'role_id'       => $request->input('role_id'),
        'module_name'   => $request->input('module_name'),
        'function_name' => $request->input('function_name'),
        'permission'    => $request->input('permission'),
    ];

    $roles = Roles::all(); //
    
    
    $query = Assignment::with(['roles', 'functionModule']);

    
    if ($request->filled('role_id')) {
        $query->where('role_id', $request->input('role_id'));
    }

    
    if ($request->filled('module_name')) {
        $query->whereHas('functionModule', function($q) use ($request) {
            $q->where('module_name', 'like', '%' . $request->input('module_name') . '%');
        });
    }

    
    if ($request->filled('function_name')) {
        $query->whereHas('functionModule', function($q) use ($request) {
            $q->where('function_name', 'like', '%' . $request->input('function_name') . '%');
        });
    }

    
    if ($request->filled('permission')) {
        $query->where('permission', 'like', '%' . $request->input('permission') . '%');
    }

    $assignments = $query->get();

    return view('role_access.index', compact('roles', 'assignments', 'search')); //
}
    }
