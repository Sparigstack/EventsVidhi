<?php

namespace App\Http\Controllers;

// use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\User;
use App\UserOrganizer;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\UploadedFile;
use File;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;

class UserController extends Controller
{
    public function __construct() {
        $this->middleware('verified');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function show()
    {
        $user = Auth::user();
        // $organizers = User::where("user_type", 1)->get();
        $userOrgs = UserOrganizer::where("user_id", $user->id)->get();
        $orgIds = [];
        foreach($userOrgs as $userOrg){
                $orgIds[] = $userOrg->org_id;
        }
        $organizers = User::whereIn("id", $orgIds)->get();
        return view('myAccount', compact('organizers'));
    }

    public function index()
    {
        $user = Auth::user();
        return view('userProfile', compact('user'));
    }

    public function update(Request $request)
    {
        $user = Auth::user();
        $users = User::findOrFail($user->id);

        $validator = Validator::make($request->all(), [
            'profileImg' => 'image|mimes:jpeg,bmp,png,jpg|dimensions:max_width=420,max_height=360',
            'profileBannerImage' => 'image|mimes:jpeg,bmp,png,jpg,gif,spg|dimensions:max_width=845,max_height=445',
            'organizerName' => 'required',
        ]);

        if ($validator->fails()) {
            return redirect('userProfile')
                ->withErrors($validator)
                ->withInput();
        }

        $profilePicUrl = "";
        if (empty($request->userProfile) && !empty($users->profile_pic)) {
                Storage::disk('s3')->delete($users->profile_pic);
                $users->profile_pic = "";
        }
        if ($request->hasFile('profileImg')) {
            $profilePicFile = $request->file('profileImg');
            $profilePicName = time() . $profilePicFile->getClientOriginalName();
            $userId = Auth::id();
            $profilePath = 'org_' . $userId . '/Profile/' . $profilePicName;

            Storage::disk('s3')->put($profilePath, file_get_contents($profilePicFile), 'public');
            $profilePicUrl = $profilePath;
            if (!empty($users->profile_pic)) {
                Storage::disk('s3')->delete($users->profile_pic);
            }
        }

        $users->name = $request->organizerName;
        // $users->username = $request->organizerUsername;
        $users->email = $request->organizerEmail;
        $users->facebook_url = $request->facebookAcc;
        $users->phone = $request->organizerMobile;
        if($profilePicUrl != ""){
            $users->profile_pic = $profilePicUrl;
        }
        $users->save();
        return redirect('userProfile');
    }

    public function orgList()
    {
        $organizers = User::where("user_type", 1)->get();
        
        return view('org/organizerList', compact('organizers'));
    }
}
