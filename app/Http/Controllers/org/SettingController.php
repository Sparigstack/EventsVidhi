<?php

namespace App\Http\Controllers\org;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use DB;
use App\User;
use Illuminate\Http\Request;

class SettingController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        return view('org/setting', compact('user'));
    }
    public function update(Request $request)
    {
        
        $userID = Auth::id();
        $user=User::FindOrFail($userID);
        if($request->key=="username"){
            $existingUser=User::where('username',$request->value)->get();
            if(!$existingUser->isEmpty()){
                return "uernameExist";
            }
            $user->username=$request->value;
        }else if($request->key=="AutoAproveFollower"){
            if($request->value=="true"){
                $user->auto_approve_follower=1;
            }else {
                $user->auto_approve_follower=0;
            }
        }
        $user->save();
        return "success";
    }
}
