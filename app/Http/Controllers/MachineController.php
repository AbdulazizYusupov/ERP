<?php

namespace App\Http\Controllers;

use App\Models\Machine;
use Illuminate\Http\Request;

class MachineController extends Controller
{
    public function index()
    {
        $machines = Machine::all();
        return view('manufacturer.machines.index', compact('machines'));
    }

    public function create()
    {
        return view('manufacturer.machines.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
        ]);

        Machine::create($request->all());

        return redirect()->route('machines.index')->with('create', 'Machine created successfully.');
    }

    public function edit(Machine $machine)
    {
        return view('manufacturer.machines.edit', compact('machine'));
    }

    public function update(Request $request, Machine $machine)
    {
        $request->validate([
            'name' => 'required',
        ]);

        $machine->update($request->all());

        return redirect()->route('machines.index')->with('update', 'Machine updated successfully.');
    }

    public function destroy(Machine $machine)
    {
        $machine->delete();

        return redirect()->route('machines.index')->with('delete', 'Machine deleted successfully.');
    }

    public function status(Machine $machine)
    {
        $machine->status = $machine->status == 1 ? 0 : 1;
        $machine->save();
        return redirect()->back()->with('update', 'Status updated');
    }
}
