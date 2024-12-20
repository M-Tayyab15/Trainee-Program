<?php

namespace App\Http\Controllers\Auth;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AdminLoginController extends Controller
{
    public function __construct()
    {
        // This middleware ensures that only logged-out users can access the login page
        $this->middleware('guest')->except([
            'logout', 'admindashboard'
        ]);
    }

    public function adminlogin()
    {
        return view('admin.adminlogin');
    }

    public function authenticateAdmin(Request $request)
{
    $credentials = $request->validate([
        'email' => 'required|email',
        'password' => 'required|min:8|regex:/[a-z]/|regex:/[A-Z]/|regex:/[@$!%*?&]/|regex:/\d/',
    ], [
        'password.required' => 'The password field is required.',
        'password.min' => 'Your password must be at least 8 characters long.',
        'password.regex' => 'The password must include at least one uppercase letter, one lowercase letter, one number, and one special character.',
    ]);

    $attemp = [
        'email' => $request->email,
        'password' => $request->password,
        'status' => 1,
        'is_admin' => 1
    ];

    // Attempt to authenticate the user
    if (Auth::attempt($attemp)) {
        $request->session()->regenerate();

        // Store the intended URL or the default URL
        $intendedUrl = session('url.intended', route('admindashboard'));

        // Redirect to the intended URL or admin dashboard
        return redirect()->intended($intendedUrl)->withSuccess('You have successfully logged in!');
    } else {
        Auth::logout();
        return back()->withErrors([
            'email' => 'INVALID CREDENTIALS!',
        ])->onlyInput('email');
    }
}


    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('adminlogin')
            ->withSuccess('You have logged out successfully!');
    }

    public function admindashboard()
    {
        // Ensure user is logged in and is an admin
        if (Auth::check() && Auth::user()->is_admin == 1) {
            return view('admin.admindashboard');
        }
        else{
             // If user is not logged in or not an admin, redirect to login page
            return redirect()->route('adminlogin')
            ->withErrors([
                'email' => 'Please login to access the dashboard.',
            ])->onlyInput('email');
        }
    }
    // Add this to your AdminLoginController
// AdminLoginController.php

public function manageUsers()
{
    // Check if the user is an admin
    if (Auth::check() && Auth::user()->is_admin == 1) {
        // For now, just return a dummy view for manage users
        return view('admin.manage-users');
    } else {
        // If the user is not an admin, redirect them to the login page
        return redirect()->route('adminlogin')->withErrors([
            'email' => 'Please login to access the manage users page.',
        ]);
    }
}
}

