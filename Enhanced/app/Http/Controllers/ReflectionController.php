<?php

namespace App\Http\Controllers;

use App\Models\Reflection;
use Illuminate\Http\Request;

class ReflectionController extends Controller
{
    public function index()
{
    $reflections = Reflection::all();
    return view('reflection', compact('reflections'));
}



    public function create()
    {
        return view('reflection.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'reflection' => 'required',
        ]);

        Reflection::create($request->all());

        return redirect()->route('reflections.index')
                         ->with('success', 'Reflection added successfully.');
    }

    public function show(Reflection $reflection)
    {
        return view('reflection.show', compact('reflection'));
    }

    public function edit(Reflection $reflection)
    {
        return view('reflection.edit', compact('reflection'));
    }

    public function update(Request $request, Reflection $reflection)
    {
        $request->validate([
            'reflection' => 'required',
        ]);

        $reflection->update($request->all());

        return redirect()->route('reflections.index')
                         ->with('success', 'Reflection updated successfully.');
    }

    public function destroy(Reflection $reflection)
{
    $reflection->delete();

    return redirect()->route('reflection.index')
                     ->with('success', 'Reflection deleted successfully.');
}
}

