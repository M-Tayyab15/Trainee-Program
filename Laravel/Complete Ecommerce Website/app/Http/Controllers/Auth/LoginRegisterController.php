<?php


namespace App\Http\Controllers\Auth;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Cookie;

class LoginRegisterController extends Controller
{
    /**
     * Instantiate a new LoginRegisterController instance.
     */
    public function __construct()
    {
        $this->middleware('guest')->except([
            'logout',
            'dashboard'
        ]);
    }

    /**
     * Display a registration form.
     *
     * @return \Illuminate\Http\Response
     */
    public function register()
    {
        return view('register');
    }

    /**
     * Store a new user.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:250',
            'email' => 'required|email|max:250|unique:users',
            'password' => 'required|min:8|confirmed|regex:/[a-z]/|regex:/[A-Z]/|regex:/[@$!%*?&]/|regex:/\d/'
        ]);

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password)
        ]);

        $credentials = $request->only('email', 'password');
        Auth::attempt($credentials);
        $request->session()->regenerate();
        return redirect('/')
            ->withSuccess('You have successfully registered & logged in!');
    }

    /**
     * Display a login form.
     *
     * @return \Illuminate\Http\Response
     */
    public function login()
    {
        return view('login');
    }

    /**
     * Authenticate the user.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function authenticate(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required|min:8|regex:/[a-z]/|regex:/[A-Z]/|regex:/[@$!%*?&]/|regex:/\d/',
        ], [
            'password.required' => 'The password field is required.',
            'password.min' => 'Your password must be at least 8 characters long.',
            'password.regex' => 'The password must include at least one uppercase letter, one lowercase letter, one number, and one special character.',
        ]);

        $remember = $request->has('remember'); // Check if the 'remember' checkbox is checked

        $attemp = [
            'email' => $request->email,
            'password' => $request->password,
            'status' => 1,
            'is_admin' => 0
        ];

        // Attempt to authenticate the user with "Remember Me" functionality
        if (Auth::attempt($attemp, $remember)) {
            $request->session()->regenerate();

            // If 'remember' is checked, store the email in the cookie for future sessions
            if ($remember) {
                cookie()->queue('email', $request->email, 60 * 24 * 14); 
            }

            return redirect('/')->withSuccess('You have successfully logged in!');
        } else {
            Auth::logout();
            return back()->withErrors([
                'email' => 'INVALID CREDENTIALS',
            ])->onlyInput('email');
        }
    }


    /**
     * Display a dashboard to authenticated users.
     *
     * @return \Illuminate\Http\Response
     */
    public function dashboard()
    {
        if (Auth::check()) {
            $user = Auth::user();

            // Check if the authenticated user is not an admin
            if ($user->is_admin == 0) {
                return redirect('/');
            }

            // If the user is an admin, deny access to the dashboard
            return redirect('/')->withErrors([
                'email' => 'You are not authorized to access this area.',
            ]);
        }

        // If the user is not authenticated, redirect to login
        return redirect()->route('login')
            ->withErrors([
                'email' => 'Please login to access the dashboard.',
            ])->onlyInput('email');
    }

    /**
     * Log out the user from application.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function logout(Request $request)
{
    Auth::logout();
    $request->session()->invalidate();
    $request->session()->regenerateToken();

    return redirect('/')->withSuccess('You have logged out successfully!');
}

}
