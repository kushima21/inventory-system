<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    // Display personnel users
    public function index()
    {
        $users = User::orderBy('created_at', 'desc')->get();
        return view('personnel.personnel_dashboard', compact('users'));
    }

    // Search users
    public function search(Request $request)
    {
        $query = $request->input('name');

        $users = User::where('name', 'LIKE', "%{$query}%")
                    ->orderBy('created_at', 'desc')
                    ->get();

        if ($request->ajax()) {
            return view('personnel.partials.personnel_table_rows', compact('users'));
        }

        return view('personnel.personnel_dashboard', compact('users'));
    }

    // Store new personnel user
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'phone_number' => 'required|string|max:15',
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

    // Signup (for customers)
    public function signup(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'phone_number' => 'required|string|max:11',
            'email' => 'required|email|unique:users',
            'password' => 'required|string|min:6|confirmed',
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

    // Custom session-based login
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|string|min:6',
        ]);

        $user = User::where('email', $request->email)->first();

        if (!$user || !Hash::check($request->password, $user->password)) {
            return back()->withErrors(['email' => 'Invalid credentials.']);
        }

        // Store session data
        $request->session()->put('user_id', $user->id);
        $request->session()->put('user_role', $user->roles);

        // Redirect based on role
        switch ($user->roles) {
            case 'Customers':
                return redirect()->route('customers.home');
            case 'Custodian':
                return redirect()->route('settings.dashboard');
            case 'Personnel':
                return redirect()->route('personnel.dashboard');
            default:
                return redirect()->route('home');
        }
    }

    // Logout (clears session)
    public function logout(Request $request)
    {
        $request->session()->flush();
        return redirect()->route('login'); // redirect to login page
    }
}
