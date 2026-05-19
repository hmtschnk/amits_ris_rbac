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

    public function storeModule(Request $request) {
        $request->validate(['name' => 'required|unique:modules,name']);
        Modules::create(['name' => $request->name]);
        return back()->with('success', 'Module created!');
    }

    public function storeFunction(Request $request) {
        $request->validate([
            'module_id' => 'required|exists:modules,id',
            'function_name' => 'required'
        ]);
        FunctionModule::create($request->all());
        return back()->with('success', 'Function added!');
    }
}