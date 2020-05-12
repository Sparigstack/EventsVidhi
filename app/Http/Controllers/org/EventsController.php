<?php

namespace App\Http\Controllers\org;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Event;
use App\Category;
use App\City;
use DateTime;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\UploadedFile;
use File;
use Illuminate\Support\Facades\Validator;

class EventsController extends Controller
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
        return view('org/events', compact('user'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $categories = Category::all();
        $cities = City::all();
        return view('org/createEvent', compact('categories', 'cities'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'EventBannerImage' => 'image|mimes:jpeg,bmp,png,jpg,gif,spg|dimensions:max_width=468,max_height=200',
            'EventThumbnailImage' => 'image|mimes:jpeg,bmp,png,jpg|dimensions:max_width=1280,max_height=720',
        ]);

        //banner image
        $fileBanner = $request->file('EventBannerImage');
        $imageNameBanner = "";
        if ($request->hasFile('EventBannerImage')) {
            $imageNameBanner = $request->file('EventBannerImage')->getClientOriginalName();
            $destinationPathForBanner = storage_path('app/public/uploads/bannerImages');
            $fileBanner->move($destinationPathForBanner, $fileBanner->getClientOriginalName());
        }

        // thumbnail image
        $file = $request->file('EventThumbnailImage');
        // $file = $request->EventImage;
        $imageName = "";
        if ($request->hasFile('EventThumbnailImage')) {
            $imageName = $request->file('EventThumbnailImage')->getClientOriginalName();
            $destinationPath = storage_path('app/public/uploads');
            $file->move($destinationPath, $file->getClientOriginalName());
        }

        $user = Auth::user();
        $events = new Event;
        $events->title = $request->title;
        $events->description = $request->Description;
        $events->category_id = $request->category;
        $events->user_id = $user->id;
        $events->city_id = $request->city;
        $events->address = $request->Address;
        $currentDateTime = $request->EventDateTime;
        $newDateTime = new DateTime($currentDateTime);
        $events->date_time = $newDateTime;
        $events->thumbnail = $imageName;
        $events->banner = $imageNameBanner;
        if (isset($request->IsPublic)) {
            $events->is_public = '1';
        } else {
            $events->is_public = '0';
        }
        if (isset($request->IsPaid)) {
            $events->is_paid = '1';
        } else {
            $events->is_paid = '0';
        }
        $events->save();
        // var_dump($events); return;
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $event = Event::findOrFail($id);
        $categories = Category::all();
        $cities = City::all();
        return view('org/createEvent', compact('categories', 'cities', 'event'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, $id)
    {
        $this->validate($request, [
            'EventBannerImage' => 'image|mimes:jpeg,bmp,png,jpg,gif,spg|dimensions:max_width=468,max_height=200',
            'EventThumbnailImage' => 'image|mimes:jpeg,bmp,png,jpg|dimensions:max_width=1280,max_height=720',
        ]);

        //banner image
        $fileBanner = $request->file('EventBannerImage');
        $imageNameBanner = "";
        if ($request->hasFile('EventBannerImage')) {
            $imageNameBanner = $request->file('EventBannerImage')->getClientOriginalName();
            $destinationPathForBanner = storage_path('app/public/uploads/bannerImages');
            $fileBanner->move($destinationPathForBanner, $fileBanner->getClientOriginalName());
        }

        // thumbnail image
        $file = $request->file('EventThumbnailImage');
        // $file = $request->EventImage;
        $imageName = "";
        if ($request->hasFile('EventThumbnailImage')) {
            $imageName = $request->file('EventThumbnailImage')->getClientOriginalName();
            $destinationPath = storage_path('app/public/uploads');
            $file->move($destinationPath, $file->getClientOriginalName());
        }

        $user = Auth::user();
        $events = Event::findOrFail($id);
        $events->title = $request->title;
        $events->description = $request->Description;
        $events->category_id = $request->category;
        $events->user_id = $user->id;
        $events->city_id = $request->city;
        $events->address = $request->Address;

        $currentDateTime = $request->EventDateTime;
        $newDateTime = new DateTime($currentDateTime);
        $events->date_time = $newDateTime;

        $events->thumbnail = $imageName;
        $events->banner = $imageNameBanner;
        if (isset($request->IsPublic)) {
            $events->is_public = '1';
        } else {
            $events->is_public = '0';
        }
        if (isset($request->IsPaid)) {
            $events->is_paid = '1';
        } else {
            $events->is_paid = '0';
        }
        if (isset($request->IsOnline)) {
            $events->is_online = '1';
        } else {
            $events->is_online = '0';
        }
        $events->save();

        return redirect('org/events');
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
    public function destroy(Request $request)
    {
        //
        $event = Event::find($request->eventDeleteId)->delete();
    }
}
