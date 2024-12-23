<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;

class RedirectIfAuthenticatedCustom
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        // Check if the user is logged in and is an admin
        if (Auth::check() && Auth::user()->is_admin == 1) {
            // If trying to access the admin login page directly
            if ($request->is('adminlogin')) {
                // Attempt to get the intended URL or the previous URL
                $intendedUrl = session('url.intended', url()->previous()); 

                // Check if the previous URL is valid and not the login page
                if ($intendedUrl && strpos($intendedUrl, 'adminlogin') === false) {
                    return redirect()->to($intendedUrl); // Redirect to the previous page
                }

                // If no valid previous URL, redirect to the admin dashboard
                return redirect()->route('admindashboard');
            }
        }

        // If not authenticated as an admin, continue with the request
        return $next($request);
    }
}

