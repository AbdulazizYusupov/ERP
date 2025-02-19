<?php

namespace App\Http\Controllers;

use App\Models\History;
use App\Models\User;
use App\Models\Warehouse;
use App\Models\WarehouseMaterial;
use Illuminate\Http\Request;

class WarehouseController extends Controller
{
    public function index()
    {
        $warehouses = Warehouse::all();
        return view('admin.warehouses.index', compact('warehouses'));
    }

    public function create()
    {
        $users = User::all();
        return view('admin.warehouses.create', compact('users'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'user_id' => 'required|exists:users,id',
        ]);

        $warehouse = Warehouse::create($request->all());
        return redirect()->route('warehouses.index')->with('create', 'Warehouse created successfully.');
    }

    public function edit(Warehouse $warehouse)
    {
        $users = User::all();
        return view('admin.warehouses.edit', compact('warehouse', 'users'));
    }

    public function update(Request $request, Warehouse $warehouse)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'user_id' => 'required|exists:users,id',
        ]);

        $warehouse->update($request->all());
        return redirect()->route('warehouses.index')->with('update', 'Warehouse updated successfully.');
    }

    public function destroy(Warehouse $warehouse)
    {
        $warehouse->delete();
        return redirect()->route('warehouses.index')->with('delete', 'Warehouse deleted successfully.');
    }

    public function status(Warehouse $warehouse)
    {
        $warehouse->status = !$warehouse->status;
        $warehouse->save();
        return redirect()->route('warehouses.index')->with('update', 'Warehouse status updated');
    }

    public function show($id)
    {
        $warehouse = Warehouse::find($id);
        $sklads = WarehouseMaterial::where('warehouse_id', $id)->get();
        $warehouses = Warehouse::where('id', '!=', $id)->get();
        return view('admin.warehouses.show', compact('warehouses', 'sklads'));
    }

    public function transfer(Request $request)
    {
        $request->validate([
            'material_id' => 'required|exists:warehouse_materials,id',
            'warehouse_id' => 'required|exists:warehouses,id',
            'quantity' => 'required|numeric|min:1',
            'real' => 'required|exists:warehouses,id',
        ]);

        if ($request->type) {
            $material = WarehouseMaterial::where('warehouse_id', $request->real)->where('product_id', $request->material_id)->where('type', $request->type)->first();
        } else {
            $material = WarehouseMaterial::where('warehouse_id', $request->real)->where('product_id', $request->material_id)->first();
        }

        if ($material->value < $request->quantity) {
            return redirect()->back()->with('error', 'Not enough materials in stock.');
        }
        $value = $material->value;

        $material->value -= $request->quantity;
        $material->save();

        if ($request->type) {
            $targetMaterial = WarehouseMaterial::where('warehouse_id', $request->warehouse_id)
                ->where('product_id', $request->material_id)
                ->where('type', $request->type)
                ->first();
        } else {
            $targetMaterial = WarehouseMaterial::where('warehouse_id', $request->warehouse_id)
                ->where('product_id', $request->material_id)
                ->first();
        }

        if ($targetMaterial) {
            $targetMaterial->value += $request->quantity;
            $targetMaterial->save();
        } else {
            if ($request->type) {
                WarehouseMaterial::create([
                    'warehouse_id' => $request->warehouse_id,
                    'product_id' => $request->material_id,
                    'value' => $request->quantity,
                    'type' => $request->type
                ]);
            } else {
                WarehouseMaterial::create([
                    'warehouse_id' => $request->warehouse_id,
                    'product_id' => $request->material_id,
                    'value' => $request->quantity,
                    'type' => 1
                ]);
            }
        }

        History::create([
            'type' => 2,
            'material_id' => $request->material_id,
            'quantity' => $request->quantity,
            'was' => $value,
            'been' => $material->value,
            'from_id' => $request->real,
            'to_id' => $request->warehouse_id
        ]);

        return redirect()->back()->with('update', 'Transfer made successfully.');
    }
}
