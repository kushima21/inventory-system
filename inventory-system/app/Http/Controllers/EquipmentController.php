<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Equipment;
use App\Models\EquipmentBundle;
use App\Models\EquipmentInventory;
use DB;

class EquipmentController extends Controller
{
    // ✅ Show all equipment and bundles
  public function index()
    {
        // Include `id` so it can be used in the <select>
        $equipmentList = Equipment::select('id', 'equipment', 'quantity', 'created_at')
            ->orderBy('created_at', 'desc')
            ->get();

        // Fetch bundles with equipment relation
        $bundles = EquipmentBundle::with('equipment')
            ->orderBy('created_at', 'desc')
            ->get();

        return view('settings.equipment', compact('equipmentList', 'bundles'));
    }


    // ✅ Delete all records of a specific equipment name
 public function deleteByName($equipmentName)
{
    // Delete from equipment_inventory
    EquipmentInventory::where('equipment_name', $equipmentName)->delete();

    // Delete from equipment table (optional)
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

    // Save to equipment table
    $equipment = Equipment::create([
        'equipment' => $request->equipment,
        'quantity' => $request->quantity,
    ]);

    // Check if equipment already exists in equipment_inventory
    $existingInventory = EquipmentInventory::where('equipment_name', $request->equipment)->first();

    if ($existingInventory) {
        // If exists, add the quantity
        $existingInventory->quantity += $request->quantity;
        $existingInventory->updated_at = now();
        $existingInventory->save();
    } else {
        // If not exists, create new record
        EquipmentInventory::create([
            'equipment_name' => $request->equipment,
            'quantity' => $request->quantity,
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }

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
// Controller
   public function storeBundle(Request $request)
    {
        try {
            $request->validate([
                'equipment' => 'required|exists:equipment,id',
                'quantity' => 'required|integer|min:1',
                'price' => 'required|numeric|min:0',
            ]);

            // Create bundle
            EquipmentBundle::create([
                'equipment_id' => $request->equipment,
                'quantity' => $request->quantity,
                'price' => $request->price,
            ]);

            return back()->with('success', '✅ Equipment bundle saved successfully!');
        } catch (\Illuminate\Validation\ValidationException $e) {
            return back()->with('error', '❌ Validation failed: ' . implode(', ', $e->validator->errors()->all()));
        } catch (\Exception $e) {
            return back()->with('error', '❌ Error saving bundle: ' . $e->getMessage());
        }
    }

    // ✅ Delete bundle
    public function deleteBundle($id)
    {
        $bundle = EquipmentBundle::findOrFail($id);
        $bundle->delete();

        return redirect()->back()->with('success', 'Equipment bundle deleted successfully!');
    }


public function update(Request $request, $equipmentName)
{
    $request->validate([
        'equipment' => 'required|string|max:255',
        'quantity' => 'required|integer|min:1',
    ]);

    // Update equipment
    $equipment = Equipment::where('equipment', $equipmentName)->first();
    if ($equipment) {
        $equipment->update([
            'equipment' => $request->equipment,
            'quantity' => $request->quantity,
        ]);
    }

    // Update inventory
    $inventory = EquipmentInventory::where('equipment_name', $equipmentName)->first();
    if ($inventory) {
        $inventory->update([
            'equipment_name' => $request->equipment,
            'quantity' => $request->quantity,
        ]);
    }

    // ✅ Redirect to settings.inventory view
    return redirect('/settings/inventory')->with('success', 'Equipment updated successfully!');
}



}
