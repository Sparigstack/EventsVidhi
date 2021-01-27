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
use App\Event;
use DB;
use App\ContentFollower;

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

    // Admin Panel Functions
    public function orgList()
    {
        $organizers = User::where('user_type', 1)->get();
        
        return view('organizerList', compact('organizers'));
    }

    public function eventsList()
    {
        $users = User::where('user_type', '1')->get();
        $orgUserIds = [];
        foreach($users as $user){
                $orgUserIds[] = $user->id;
        }

        $orgEvents = Event::where('is_live', '1')->whereIn('user_id', $orgUserIds)->where('date_time', '>=', date('Y-m-d', strtotime(now())))->where('deleted_at', '=', NULL)->orderBy('id', 'DESC')->get();
        
        return view('eventsList', compact('orgEvents'));
    }

    public function orgEventsList($id)
    {
        $orgEvents = Event::where('user_id', $id)->where('is_live', '1')->where('date_time', '>=', date('Y-m-d', strtotime(now())))->where('deleted_at', '=', NULL)->orderBy('id', 'DESC')->get();
        
        return view('orgEventsList', compact('orgEvents'));
    }

    public function myContent(){
        $user = Auth::user();
        $events = DB::table('events')->select('events.*', 'content_followers.content_id as eventFollowEventId' , 'users.profile_pic', 'users.name', 'users.id as userId')->join('users', 'events.user_id', '=', 'users.id')->join('content_followers', 'events.id', '=', 'content_followers.content_id')->where('content_followers.user_id', $user->id)->where('content_followers.discriminator', 'e')->get();
        $videos = DB::table('videos')->select('videos.*', 'content_followers.content_id as eventFollowVideoId' , 'users.profile_pic', 'users.name', 'users.id as userId', 'events.description as eventDesc')->join('users', 'videos.user_id', '=', 'users.id')->leftJoin('events', 'videos.event_id', '=', 'events.id')->join('content_followers', 'videos.id', '=', 'content_followers.content_id')->where('content_followers.user_id', $user->id)->where('content_followers.discriminator', 'v')->get();
        $podcasts = DB::table('podcasts')->select('podcasts.*', 'content_followers.content_id as eventFollowPodcastId' , 'users.profile_pic', 'users.name', 'users.id as userId')->join('users', 'podcasts.user_id', '=', 'users.id')->join('content_followers', 'podcasts.id', '=', 'content_followers.content_id')->where('content_followers.user_id', $user->id)->where('content_followers.discriminator', 'p')->get();
        $organizers = DB::table('users')->select('users.*', 'content_followers.content_id as eventFollowOrgId' , 'users.profile_pic', 'users.name', 'users.id as userId')->join('content_followers', 'users.id', '=', 'content_followers.content_id')->where('content_followers.user_id', $user->id)->where('content_followers.discriminator', 'o')->get();
        $eventFollowersList = ContentFollower::all();
        $orgFollowerCount = "SELECT c.content_id FROM content_followers c INNER JOIN users u ON c.content_id = u.id WHERE c.discriminator = 'o'";
        $orgFollowerCount = DB::select(DB::raw($orgFollowerCount));
        $orgFollowerCountResult = count($orgFollowerCount);
        return view('myContent', compact('events', 'videos', 'podcasts' ,'eventFollowersList', 'organizers', 'orgFollowerCountResult'));
    }

}
