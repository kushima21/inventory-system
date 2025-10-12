<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Equipment;
use App\Models\EquipmentBundle;

class EquipmentController extends Controller
{
    // ✅ Show equipment and bundles
    public function index()
    {
        $equipmentList = Equipment::all();
        $bundles = EquipmentBundle::with('equipment')
            ->orderBy('created_at', 'desc')
            ->get();

        return view('settings.equipment', compact('equipmentList', 'bundles'));
    }

    // ✅ Store equipment
    public function store(Request $request)
    {
        $request->validate([
            'equipment' => 'required|string|max:255',
            'quantity' => 'required|integer|min:1',
        ]);

        Equipment::create([
            'equipment' => $request->equipment,
            'quantity' => $request->quantity,
        ]);

        return redirect()->back()->with('success', 'Equipment created successfully!');
    }

    // ✅ Delete equipment
    public function delete($id)
    {
        $equipment = Equipment::findOrFail($id);
        $equipment->delete();

        return redirect()->back()->with('success', 'Equipment deleted!');
    }

    // ✅ Store bundle
    public function storeBundle(Request $request)
    {
        $request->validate([
            'equipment' => 'required|exists:equipment,id',
            'quantity' => 'required|integer|min:1',
            'price' => 'required|numeric|min:0',
        ]);

        EquipmentBundle::create([
            'equipment_id' => $request->equipment,
            'quantity' => $request->quantity,
            'price' => $request->price,
        ]);

        return redirect()->back()->with('success', 'Equipment bundle saved successfully!');
    }

    // ✅ Delete bundle
    public function deleteBundle($id)
    {
        $bundle = EquipmentBundle::findOrFail($id);
        $bundle->delete();

        return redirect()->back()->with('success', 'Equipment bundle deleted successfully!');
    }
}
