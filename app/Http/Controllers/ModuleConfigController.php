<?php

namespace App\Http\Controllers;

use App\Models\Modules;
use App\Models\FunctionModule;
use Illuminate\Http\Request;

class ModuleConfigController extends Controller {

     public function index() {
        $modules = Modules::with('functions')->get();
      return view('module_config.index', compact('modules'));
    }

    // public function storeModule(Request $request) {
    //     $request->validate(['name' => 'required|unique:modules,name']);
    //     Modules::create(['name' => $request->name]);
    //     return back()->with('success', 'Module created!');
    // }

    // public function storeFunction(Request $request) {
    //     $request->validate([
    //         'module_id' => 'required|exists:modules,id',
    //         'function_name' => 'required'
    //     ]);
    //     FunctionModule::create($request->all());
    //     return back()->with('success', 'Function added!');
    // }

    public function storeModule(Request $request)
    {
        $request->validate([
            'name' => 'required|unique:modules,name',
        ]);
 
        $module = Modules::create(['name' => $request->name]);
 
        return response()->json([
            'success' => true,
            'module'  => [
                'id'   => $module->id,
                'name' => $module->name,
            ],
            'message' => 'Module "' . $module->name . '" created successfully.',
        ]);
    }
 
    /**
     * Save a new Function Access via AJAX.
     * Returns the new function as JSON so the dropdown can update instantly.
     */
    public function storeFunction(Request $request)
    {
        $request->validate([
            'module_id'     => 'required|exists:modules,id',
            'function_name' => 'required|max:100',
        ]);
 
        $function = FunctionModule::create([
            'module_id'     => $request->module_id,
            'function_name' => $request->function_name,
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