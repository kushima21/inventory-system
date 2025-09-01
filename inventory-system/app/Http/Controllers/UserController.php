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
            'phone_number' => 'required|string|max:15', // or digits_between
            'email' => 'required|email|unique:users',
            'password' => 'required|string|min:6',
            'roles' => 'required|string',
        ]);


       User::create([
            'name' => $request->name,
            'phone_number' => $request->phone_number,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'roles' => $request->roles,
        ]);

        return redirect('/personnel_dashboard')->with('success', 'Personnel created successfully.');
    }


public function signup(Request $request)
{
    $request->validate([
        'name' => 'required|string|max:255',
        'phone_number' => 'required|string|max:11',
        'email' => 'required|email|unique:users',
        'password' => 'required|string|min:6|confirmed', // checks against password_confirmation
        'roles' => 'required|string',
    ]);

    User::create([
        'name' => $request->name,
        'phone_number' => $request->phone_number,
        'email' => $request->email,
        'password' => Hash::make($request->password),
        'roles' => $request->roles ?? 'Customers',
    ]);

    return redirect('/signup')->with('success', 'Account created successfully! Please log in.');
}

}

