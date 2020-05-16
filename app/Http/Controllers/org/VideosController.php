<?php

namespace App\Http\Controllers\org;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;
use App\Video;

class VideosController extends Controller
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
        //
        $url = 'https://s3.' . env('AWS_DEFAULT_REGION') . '.amazonaws.com/' . env('AWS_BUCKET') . '/';
        $images = [];
        $files = Storage::disk('s3')->files('images');
        foreach ($files as $file) {
            $images[] = [
                'name' => str_replace('images/', '', $file),
                'src' => $url . $file
            ];
        }
        var_dump($images);
        return;
        return view('org/videos', compact('images'));

        //return view('org/videos');
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
        return view('org/createVideo', compact('events'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        //        request()->file('VideoFile')->store('demofolder','local');
        //        return back();
        //        $this->validate($request, [
        //            'image' => 'required|image|max:2048'
        //        ]);
        //return 'validation passed';
        $video = new Video;
        $video = $request->input_title;
        $UrlToSave="";
        if (isset($request->IsUploadVideo)) {
            if ($request->hasFile('input_vidfile')) {
                $file = $request->file('input_vidfile');
                $name = time() . $file->getClientOriginalName();
                $userId = Auth::id();
                $filePath = 'org_'.$userId.'/Video/'. $name;
                Storage::disk('s3')->put($filePath, file_get_contents($file));
                $UrlToSave=$filePath;
            }
        } else {
            $UrlToSave= $request->$request->input_url;
        }
        if (isset($request->IsLinkedEvent)) {
            $video->event_id = $request->$request->EventToLinks;
        }
        
        $video->url = $UrlToSave;
        $video->save();

        // if ($request->hasFile('VideoFile')) {
        //     $file = $request->file('VideoFile');
        //     $name = time() . $file->getClientOriginalName();
        //     $filePath = 'images/' . $name;
        //     Storage::disk('s3')->put($filePath, file_get_contents($file));
        // } else {
        //     return 'from else';
        // }
        return back()->withSuccess('Image uploaded successfully');
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
        //
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
