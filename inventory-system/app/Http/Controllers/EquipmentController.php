<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Equipment;
use App\Models\EquipmentBundle;
use DB;

class EquipmentController extends Controller
{
    // ✅ Show all equipment and bundles
    public function index()
    {
        // ✅ Group by equipment name (no duplicates)
        // Sum all quantities with the same name and get latest creation date
        $equipmentList = Equipment::select(
                DB::raw('MAX(id) as id'),
                'equipment',
                DB::raw('SUM(quantity) as total_quantity'),
                DB::raw('MAX(created_at) as latest_created')
            )
            ->groupBy('equipment')
            ->orderBy('latest_created', 'desc')
            ->get();

        // ✅ Full list (for recent display if needed)
        $equipmentAll = Equipment::orderBy('created_at', 'desc')->get();

        // ✅ Load bundles with related equipment
        $bundles = EquipmentBundle::with('equipment')
            ->orderBy('created_at', 'desc')
            ->get();

        return view('settings.equipment', compact('equipmentList', 'equipmentAll', 'bundles'));
    }

    // ✅ Delete all records of a specific equipment name
    public function deleteByName($equipmentName)
    {
        Equipment::where('equipment', $equipmentName)->delete();
        return redirect()->back()->with('success', 'Equipment deleted successfully.');
    }

    // ✅ Show bundles for users
    public function showUserBook()
    {
        $bundles = EquipmentBundle::with('equipment')
            ->orderBy('created_at', 'desc')
            ->get();

        return view('customers.userBook', compact('bundles'));
    }

    // ✅ Store new equipment
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

    // ✅ Delete equipment by ID
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
