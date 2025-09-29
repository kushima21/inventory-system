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

public function login(Request $request)
{
    $request->validate([
        'email' => 'required|email',
        'password' => 'required|string|min:6',
    ]);

    $user = User::where('email', $request->email)->first();

    if (!$user || !Hash::check($request->password, $user->password)) {
        return back()->withErrors([
            'email' => 'Invalid credentials.',
        ]);
    }

    // Store session (simple auth)
    $request->session()->put('user_id', $user->id);
    $request->session()->put('user_role', $user->roles);

    // Redirect based on roles
    switch ($user->roles) {
        case 'Customers':
            return redirect()->route('customers.home');
        case 'Admin':
            return redirect()->route('admin.dashboard');
        case 'Personnel':
            return redirect()->route('personnel.dashboard');
        default:
            return redirect()->route('home');
    }
}

public function logout(Request $request)
{
    // Clear all session data
    $request->session()->flush();

    // Redirect to login page
    return redirect()->route('login'); // now it works ✅
}

}


