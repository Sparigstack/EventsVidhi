<?php

namespace App\Http\Controllers\org;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\User;
use Illuminate\Http\UploadedFile;
use File;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;

class ProfileController extends Controller
{
    public function __construct() {
        $this->middleware('verified');
    }
    
    public function index()
    {
        $user = Auth::user();
        return view('org/profile', compact('user'));
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
            return redirect('org/profile')
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

        $profileBannerUrl = "";
        if (empty($request->userBanner) && !empty($users->banner)) {
                Storage::disk('s3')->delete($users->banner);
                $users->banner = "";
        }
        if ($request->hasFile('profileBannerImage')) {
            $profileBannerFile = $request->file('profileBannerImage');
            $profileBannerName = time() . $profileBannerFile->getClientOriginalName();
            $userId = Auth::id();
            $profileBannerPath = 'org_' . $userId . '/Profile/Banner/' . $profileBannerName;

            Storage::disk('s3')->put($profileBannerPath, file_get_contents($profileBannerFile), 'public');
            $profileBannerUrl = $profileBannerPath;
            if (!empty($users->banner)) {
                Storage::disk('s3')->delete($users->banner);
            }
        }

    	$users->name = $request->organizerName;
    	// $users->username = $request->organizerUsername;
        $users->email = $request->organizerEmail;
        $users->description = $request->organizerDesc;
        $users->website_url = $request->websiteName;
        $users->linkedin_url = $request->linkedinAcc;
        $users->facebook_url = $request->facebookAcc;
        $users->twitter_url = $request->twitterAcc;
        // $users->phone = $request->organizerMobile;
        if($profilePicUrl != ""){
        	$users->profile_pic = $profilePicUrl;
        }
        if($profileBannerUrl != ""){
        	$users->banner = $profileBannerUrl;
        }
        $users->save();
        return redirect('org/profile');
    }
}