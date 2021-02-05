<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use App\User;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    //protected $redirectTo = RouteServiceProvider::HOME;
    protected $redirectTo = RouteServiceProvider::OrgLanding;

    /**
     * Create a new controller instance.
     *
     * @return void
     */

    // protected function redirectTo(){
    //     return '/userRegister';
    // }

    public function __construct()
    {
        // $this->middleware('guest');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'email' => 'unique:users',
            // 'name' => ['required', 'string', 'max:255'],
            // 'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            // 'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\User
     */
    protected function create(array $data)
    {
        $validator = Validator::make($data, [
        'email' => 'unique:users',
        ]);

        if ($validator->fails()) {
            $errors = "Email ID already Exists";
            return $errors;
        } else {
                if($data['checkUrl'] == "1"){
            return User::create([
                'name' => $data['name'],
                'email' => $data['email'],
                'password' => Hash::make($data['password']),
                'user_type' => 2,
            ]);
        } else{
            if (array_key_exists("website", $data) && array_key_exists("businessName", $data) && array_key_exists("location", $data)) {
            // if($data['website']->exists() && $data['businessName']->exists()){
                $lastID = User::orderBy('id', 'desc')->first();
                return User::where('id', $lastID->id)->update([
                    'name' => $data['businessName'],
                    'website_url' => $data['website'],
                    'location' => $data['location'],
                    'plan_id' => 5,
                ]);
                // $users = User::findOrFail($lastID->id);
                // $users->name = $data['businessName'];
                // $users->website_url = $data['website'];
                // $users->save();
            } else {
                return User::create([
                // 'name' => $data['name'],
                'email' => $data['email'],
                'password' => Hash::make($data['password']),
                'user_type' => 1,
                ]);
                // $lastID = User::orderBy('id', 'desc')->first();
                // return $lastID->id;
            }

        }
        }
    }
}
