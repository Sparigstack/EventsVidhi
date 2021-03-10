<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use App\User;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    // protected $redirectTo = RouteServiceProvider::HOME;
    // protected $redirectTo = RouteServiceProvider::OrgLanding;
    // protected $redirectTo;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    protected function redirectTo(){
        if(auth()->user()->user_type == "1"){
            // return '/org/events';
            return '/';
        } else if(auth()->user()->user_type == "2"){
            // return '/myAccount';
            return '/';
        } else if(auth()->user()->user_type == "3"){
            //return '/organizers';
            session()->put('url.intended', '/organizers');
        }
        //return '/';
    }

    public function __construct()
    {
        // Get URLs
        $urlPrevious = url()->previous();
        $urlBase = url()->to('/');

        // Set the previous url that we came from to redirect to after successful login but only if is internal

        if(($urlPrevious != $urlBase . '/login') && (substr($urlPrevious, 0, strlen($urlBase)) === $urlBase)) {
            session()->put('url.intended', $urlPrevious);
        }

        $this->middleware('guest')->except('logout');
    }

}
