<?php

namespace App\Http\Controllers\org;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use App\Podcast;
use Illuminate\Support\Facades\Validator;

class PodcastsController extends Controller
{
    
    public function __construct()
    {
        $this->middleware('verified');
    }
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user = Auth::user();
        $podcasts = Podcast::where('user_id',$user->id)->get();
        return view('org/podcasts', compact('podcasts'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $user = Auth::user();
        $events = $user->events->sortBy('created_at');
        $RecentPodcasts=Podcast::where('user_id', $user->id)->take(7)->orderBy('id', 'DESC')->get();
        return view('org/createPodcast', compact('events', 'RecentPodcasts'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // mov,mp4,wmv,flv,avi
        $validator=null ;
        if (isset($request->IsUploadPodcast)){
            $validator = Validator::make($request->all(), [
                'input_title' => 'required',
                'input_podfile'=>'required|mimes:mpga,m4a,wma'
            ]);
        }else{
            $validator = Validator::make($request->all(), [
                'input_title' => 'required',
                'input_url' => 'required',
            ]);
        }
        // regex:/^(https?:\/\/)?([\da-z\.-]+)\.([a-z\.]{2,6})([\/\w \.-]*)*\/?$/
        if ($validator->fails()) {
            return redirect('org/podcasts/new')
                ->withErrors($validator)
                ->withInput();
        }
        $podcast = new Podcast;
        $podcast->title = $request->input_title;
        $userId = Auth::id();
        $podcast->user_id = $userId;
        $UrlToSave = "";
        if (isset($request->IsUploadPodcast)) {
            if ($request->hasFile('input_podfile')) {
                $file = $request->file('input_podfile');
                $name = time() . $file->getClientOriginalName();
                $userId = Auth::id();
                $filePath = 'org_' . $userId . '/Podcast/' . $name;
                Storage::disk('s3')->put($filePath, file_get_contents($file));
                $UrlToSave = $filePath;
                $size=$request->file('input_podfile')->getSize();
                $podcast->file_size= $size;
            }
        } else {
            $UrlToSave = $request->input_url;
        }
        // if (isset($request->IsLinkedEvent)) {
        //     $podcast->event_id = $request->EventToLink;
        // }

        if ($request->linkedEvent == '1') {
            $podcast->event_id = $request->EventToLink;
            $podcast->description = "";
        }
        if ($request->linkedEvent == '0') {
            $podcast->description = $request->Description;
            $podcast->event_id = NULL;
        }

        $podcast->url = $UrlToSave;
        $podcast->save();

        return redirect('org/podcasts');

        // return back()->withSuccess('Image uploaded successfully');
    }


    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $user = Auth::user();
        $podcast = Podcast::findOrFail($id);
        $events = $user->events->sortBy('created_at');
        $RecentPodcasts=Podcast::where('user_id', $user->id)->take(7)->orderBy('id', 'DESC')->get();
        return view('org/createPodcast', compact('events','podcast', 'RecentPodcasts'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $validator=null ;
        if (isset($request->IsUploadVideo)){
            $validator = Validator::make($request->all(), [
                'input_title' => 'required',
                'input_podfile'=>'required|mimes:mp3,m4a,wma'
            ]);
        }else{
            $validator = Validator::make($request->all(), [
                'input_title' => 'required',
                'input_url' => 'required',
            ]);
        }
        // regex:/^(https?:\/\/)?([\da-z\.-]+)\.([a-z\.]{2,6})([\/\w \.-]*)*\/?$/
        if ($validator->fails()) {
            return redirect('org/podcasts/'. $id)
                ->withErrors($validator)
                ->withInput();
        }

        $user = Auth::user();
        $podcast = Podcast::findOrFail($id);

        $podcast->title = $request->input_title;
        $userId = Auth::id();
        $podcast->user_id = $userId;
        $UrlToSave = "";
        if (isset($request->IsUploadVideo)) {
            if ($request->hasFile('input_podfile')) {
                $file = $request->file('input_podfile');
                $name = time() . $file->getClientOriginalName();
                $userId = Auth::id();
                $filePath = 'org_' . $userId . '/Video/' . $name;
                Storage::disk('s3')->put($filePath, file_get_contents($file));
                $UrlToSave = $filePath;
            }
        } else {
            $UrlToSave = $request->input_url;
        }
        // if (isset($request->IsLinkedEvent)) {
        //     $podcast->event_id = $request->EventToLink;
        // }
        if ($request->linkedEvent == '1') {
            $podcast->event_id = $request->EventToLink;
            $podcast->description = "";
        }
        if ($request->linkedEvent == '0') {
            $podcast->description = $request->Description;
            $podcast->event_id = NULL;
        }

        $podcast->url = $UrlToSave;
        $podcast->save();

        return redirect('org/podcasts');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $podcastVideo = Podcast::find($request->podcastVideoDeleteId)->delete();
    }
}
