<?php

namespace App\Http\Controllers;

use App\Models\Modules;
use App\Models\FunctionModule;
use Illuminate\Http\Request;

class ModuleConfigController extends Controller
{
    public function index()
    {
        $modules = Modules::with('functions')->get();
        return view('module_config.index', compact('modules'));
    }

    public function storeModule(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:100|unique:modules,name',
        ]);

        $module = Modules::create(['name' => $request->name]);

        return response()->json([
            'success' => true,
            'module'  => ['id' => $module->id, 'name' => $module->name],
            'message' => 'Module "' . $module->name . '" created successfully.',
        ]);
    }

    public function storeFunction(Request $request)
    {
        $request->validate([
            'module_id'     => 'required|exists:modules,id',
            'function_name' => 'required|string|max:100',
        ]);

        $nextFunctionId = (FunctionModule::max('function_id') ?? 0) + 1;

        $function = FunctionModule::create([
            'module_id'     => $request->module_id,
            'function_name' => $request->function_name,
            'function_id'   => $nextFunctionId,
        ]);

        return response()->json([
            'success'  => true,
            'function' => [
                'id'            => $function->id,
                'module_id'     => $function->module_id,
                'function_name' => $function->function_name,
            ],
            'message' => 'Function "' . $function->function_name . '" created successfully.',
        ]);
    }
}