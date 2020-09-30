<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use App\User;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;

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
            return '/org/events';
        } else if(auth()->user()->user_type == "2"){
            return '/myAccount';
        } else if(auth()->user()->user_type == "3"){
            return '/organizers';
        }
        return '/';
    }

    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    // public function determineLoginType(Request $request)
    // {

    //     $user = User::where('email', $request->email)->first();

    //     if ($user && $user->user_type == 2) { // Check if the user exists & check their type.
    //         $this->redirectTo = '/home';
    //     }else{
    //         $this->redirectTo = '/org/events';
    //     }
    // }

}
