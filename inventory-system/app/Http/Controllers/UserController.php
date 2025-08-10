<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function index()
    {
        $users = User::orderBy('created_at', 'desc')->get();
        return view('personnel.personnel_dashboard', compact('users'));
    }

  public function search(Request $request)
{
    $query = $request->input('name');

    $users = User::where('name', 'LIKE', "%{$query}%")
                ->orderBy('created_at', 'desc')
                ->get();

    if ($request->ajax()) {
        return view('personnel.partials.personnel_table_rows', compact('users'));
    }

    // For non-AJAX requests (fallback)
    return view('personnel.personnel_dashboard', compact('users'));
}

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users',
            'password' => 'required|string|min:6',
            'roles' => 'required|string',
        ]);

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'roles' => $request->roles,
        ]);

        return redirect('/personnel_dashboard')->with('success', 'Personnel created successfully.');
    }
}
