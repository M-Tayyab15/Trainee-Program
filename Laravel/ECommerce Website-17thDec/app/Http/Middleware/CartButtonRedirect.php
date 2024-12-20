<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CartButtonRedirect
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
        
        if (Auth::check()) {
            $user = Auth::user();
            
            
            if ($user->is_admin == 1) {
                Auth::logout();
                return redirect()->route('login')->with('message', 'Admin has been logged out, please log in as a user.');
            }
            if ($user->is_admin == 0) {
                return $next($request); 
            }
        }

        // If no one is logged in, redirect to login page
        return redirect()->route('login');
    }
}
