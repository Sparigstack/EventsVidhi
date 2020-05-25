<?php

namespace App\Http\Controllers\org;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;
use App\Video;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\UploadedFile;

class VideosController extends Controller {

    public function __construct() {
        $this->middleware('verified');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index() {
        //
        // $url = 'https://s3.' . env('AWS_DEFAULT_REGION') . '.amazonaws.com/' . env('AWS_BUCKET') . '/';
        // $images = [];
        // $files = Storage::disk('s3')->files('images');
        // foreach ($files as $file) {
        //     $images[] = [
        //         'name' => str_replace('images/', '', $file),
        //         'src' => $url . $file
        //     ];
        // }
        $user = Auth::user();
        $videos = Video::where('user_id', $user->id)->get();
        // var_dump($videos->events->title); 
        // var_dump($images);
        // return;
        // return view('org/videos', compact('images','videos'));
        return view('org/videos', compact('videos'));

        //return view('org/videos');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create() {
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
    public function store(Request $request) {
        $validator = null;
        if (isset($request->IsUploadVideo)) {
            $validator = Validator::make($request->all(), [
                        'input_title' => 'required',
                        'input_vidfile' => 'required|mimes:mov,mp4,wmv,flv,avi'
            ]);
        } else {
            $validator = Validator::make($request->all(), [
                        'input_title' => 'required',
                        'input_url' => 'required',
            ]);
        }

        if ($validator->fails()) {
            return redirect('org/videos/new')
                            ->withErrors($validator)
                            ->withInput();
        }

        $video = new Video;
        $video->title = $request->input_title;
        $userId = Auth::id();
        $video->user_id = $userId;
        $UrlToSave = "";
        if (isset($request->IsUploadVideo)) {
            if ($request->hasFile('input_vidfile')) {
                $file = $request->file('input_vidfile');
                $name = time() . $file->getClientOriginalName();
                $userId = Auth::id();
                // $filePath = 'org_' . $userId . '/Video/' . $name;
                $filePath = 'org_' . $userId . '/Video';
                $fileLocation = Storage::disk('s3')->put($filePath, $request->file('input_vidfile'));
                // $size = Storage::disk('s3')->size($filePath);
                $size = $request->file('input_vidfile')->getSize();
                $video->file_size = $size;
                $UrlToSave = $fileLocation;
            }
        } else {
            $UrlToSave = $request->input_url;
        }
        // if (isset($request->IsLinkedEvent)) {
        //     $video->event_id = $request->EventToLink;
        // }
        if ($request->linkedEvent == '1') {
            $video->event_id = $request->EventToLink;
            $video->description = "";
        }
        if ($request->linkedEvent == '0') {
            $video->description = $request->Description;
            $video->event_id = NULL;
        }

        $video->url = $UrlToSave;
        $video->save();
        return response()->json(['success' => 'File Uploaded Successfully']);
        //return redirect('org/videos');
        // if ($request->hasFile('VideoFile')) {
        //     $file = $request->file('VideoFile');
        //     $name = time() . $file->getClientOriginalName();
        //     $filePath = 'images/' . $name;
        //     Storage::disk('s3')->put($filePath, file_get_contents($file));
        // } else {
        //     return 'from else';
        // }
        // return back()->withSuccess('Image uploaded successfully');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id) {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id) {
        $user = Auth::user();
        $video = Video::findOrFail($id);
        $events = $user->events->sortBy('created_at');
        return view('org/createVideo', compact('events', 'video'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id) {
        $validator = null;
        if (isset($request->IsUploadVideo)) {
            $validator = Validator::make($request->all(), [
                        'input_title' => 'required',
                        'input_vidfile' => 'required|mimes:mov,mp4,wmv,flv,avi'
            ]);
        } else {
            $validator = Validator::make($request->all(), [
                        'input_title' => 'required',
                        'input_url' => 'required',
            ]);
        }

        if ($validator->fails()) {
            return redirect('org/videos/' . $id)
                            ->withErrors($validator)
                            ->withInput();
        }

        $user = Auth::user();
        $video = Video::findOrFail($id);

        $video->title = $request->input_title;
        $userId = Auth::id();
        $video->user_id = $userId;
        $UrlToSave = "";
        if (isset($request->IsUploadVideo)) {
            if ($request->hasFile('input_vidfile')) {
                $file = $request->file('input_vidfile');
                $name = time() . $file->getClientOriginalName();
                $userId = Auth::id();
                $filePath = 'org_' . $userId . '/Video/' . $name;
                Storage::disk('s3')->put($filePath, file_get_contents($file));
                $UrlToSave = $filePath;
                $size = $request->file('input_vidfile')->getSize();
                $video->file_size = $size;
            }
        } else {
            $UrlToSave = $request->input_url;
        }
        // if (isset($request->IsLinkedEvent)) {
        //     $video->event_id = $request->EventToLink;
        // }
        if ($request->linkedEvent == '1') {
            $video->event_id = $request->EventToLink;
            $video->description = "";
        }
        if ($request->linkedEvent == '0') {
            $video->description = $request->Description;
            $video->event_id = NULL;
        }
        // if ($request->linkedEvent == '1') {
        //     $video->event_id = $request->EventToLink;
        // }
        // if ($request->linkedEvent == '0') {
        //     $video->event_id = NULL;
        // }

        $video->url = $UrlToSave;
        $video->save();

        return redirect('org/videos');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request) {
        $video = Video::find($request->videoDeleteId);
        if (!empty($video->url)) {
            Storage::disk('s3')->delete($video->url);
        }
        $video->delete();
    }

}
