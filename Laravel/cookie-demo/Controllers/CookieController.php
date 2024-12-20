<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie;

class CookieController extends Controller
{
    
    public function setCookie(Request $request)
    {    
        Cookie::queue('user', 'Tayyab', 1); 

        return response('Cookie has been set!')
            ->header('Content-Type', 'text/plain');
    }

    public function getCookie(Request $request)
    {
        $user = Cookie::get('user');

        if ($user) {
            return response('User Cookie: ' . $user);
        } else {
            return response('No user cookie set');
        }
    }

   
    public function deleteCookie(Request $request)
    {
        Cookie::forget('user');

        return response('Cookie has been deleted!')
            ->header('Content-Type', 'text/plain');
    }
}
