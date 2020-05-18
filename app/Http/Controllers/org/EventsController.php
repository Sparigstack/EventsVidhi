<?php

namespace App\Http\Controllers\org;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DB;
use App\Event;
use App\Category;
use App\City;
use App\Timezone;
use App\EventCategory;
use App\EventType;
use DateTime;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\UploadedFile;
use File;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;

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
        // $event->date_time >= date('Y-m-d',strtotime(now()))
        $user = Auth::user();
        $events = Event::where('user_id',$user->id)->where('date_time','>=',date('Y-m-d',strtotime(now())))
            ->get();
        return view('org/events', compact('events'));
    }

    public function pastEvents()
    {
        $user = Auth::user();
        $events = Event::where('user_id',$user->id)->where('date_time','<=',date('Y-m-d',strtotime(now())))
            ->get();
        return view('org/pastEvents', compact('events'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $isVideoSelected = false;
        $categories = Category::all();
        $cities = City::all();
        $cityTimeZones = Timezone::all();
        $eventTypes=EventType::all();
        return view('org/createEvent', compact('categories', 'cities', 'cityTimeZones','eventTypes','isVideoSelected'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // $validate = $this->validate($request, [
        //     'EventBannerImage' => 'image|mimes:jpeg,bmp,png,jpg,gif,spg|dimensions:max_width=468,max_height=200',
        //     'EventThumbnailImage' => 'image|mimes:jpeg,bmp,png,jpg|dimensions:max_width=1280,max_height=720',
        //     'title' => 'required',
        //     'category' => 'required',
        //     'Description' => 'required',
        //     'EventDateTime' => 'required',
        // ]);
         
        
        $validator = Validator::make($request->all(), [
            'EventBannerImage' => 'image|mimes:jpeg,bmp,png,jpg,gif,spg|dimensions:max_width=468,max_height=200',
            'EventThumbnailImage' => 'image|mimes:jpeg,bmp,png,jpg|dimensions:max_width=1280,max_height=720',
            'title' => 'required',
            'category' => 'required',
            'Description' => 'required',
            'EventDateTime' => 'required',
        ]);

        if ($validator->fails()) {
            return redirect('org/events/new')
                ->withErrors($validator)
                ->withInput();
        }

        //banner image
        // $fileBanner = $request->file('EventBannerImage');
        $bannerUrl = "";
        if ($request->hasFile('EventBannerImage')) {
            // $imageNameBanner = $request->file('EventBannerImage')->getClientOriginalName();
            // $destinationPathForBanner = storage_path('app/public/uploads/bannerImages');
            // $fileBanner->move($destinationPathForBanner, $fileBanner->getClientOriginalName());

            $file = $request->file('EventBannerImage');
            $name = time() . $file->getClientOriginalName();
            $userId = Auth::id();
            $filePath = 'org_'.$userId.'/' . $name;
           
            Storage::disk('s3')->put($filePath, file_get_contents($file),'public');
            $bannerUrl = $filePath;
        }

        // thumbnail image
        //$file = $request->file('EventThumbnailImage');
        // $file = $request->EventImage;
        $thumbNailUrl = "";
        if ($request->hasFile('EventThumbnailImage')) {
            // $imageName = $request->file('EventThumbnailImage')->getClientOriginalName();
            // $destinationPath = storage_path('app/public/uploads');
            // $file->move($destinationPath, $file->getClientOriginalName());

            $thumbnailfile = $request->file('EventThumbnailImage');
            $thumbnailName = time() . $thumbnailfile->getClientOriginalName();
            $userId = Auth::id();
            $thumbnailfilePath = 'org_'.$userId.'/Thumbnail/' . $thumbnailName;
           
            Storage::disk('s3')->put($thumbnailfilePath, file_get_contents($thumbnailfile),'public');
            // $thumbNailUrl = Storage::url($thumbnailfilePath); --to get full url of file in amazon s3
            $thumbNailUrl =$thumbnailfilePath;
        }

        $user = Auth::user();
        $events = new Event;
        $events->title = $request->title;
        $events->description = $request->Description;
        $events->category_id = $request->category;
        $events->event_type_id=$request->eventType;
        $events->user_id = $user->id;
        if (isset($request->IsOnline)) {
            $events->is_online = '1';
            $events->online_event_url = $request->EventUrl;
        } else {
            $events->city_id = $request->city;
            $events->address = $request->Address;
            $events->is_online = '0';
        }
        // $events->city_id = $request->city;
        // $events->address = $request->Address;
        $StartDateTime = $request->EventDateTime;
        //$StarteDateTi = new DateTime($StartDateTime);
        $events->date_time = new DateTime($StartDateTime);

        $EndDateTime = $request->EventEndDateTime;
        //$newDateTime = new DateTime($EndDateTime);
        $events->end_date_time = new DateTime($EndDateTime);
        $events->timezone_id = $request->cityTimezone;

        $events->thumbnail = $thumbNailUrl;
        $events->banner = $bannerUrl;
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

        $string = $request->HiddenCategoyID;
        $EventCategorieIds = preg_split("/\,/", $string);
        
        foreach($EventCategorieIds as $categoryID){
            $eventCategory = new EventCategory;
            $eventCategory->event_id=$events->id;
            $eventCategory->category_id=number_format($categoryID);
            $eventCategory->save();
        }
        return redirect('org/events');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $isVideoSelected = false;
        $ids = explode(',', $id);
        $count=0;
        foreach ($ids as $selectedId) {
            if($count == 0){
                    $selectedId = $id;
            }else{
                $isVideoSelected = true;
            }
            $count++;        
        }

        $event = Event::findOrFail($id);
        $categories = Category::all();
        $cities = City::all();
        $cityTimeZones = Timezone::all();
        $eventTypes=EventType::all();
        return view('org/createEvent', compact('categories', 'cities', 'event','cityTimeZones','eventTypes','isVideoSelected'));
    }

    public function storeVideo(Request $request)
    {
        return 'mansi';
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, $id)
    {
        // $this->validate($request, [
        //     'EventBannerImage' => 'image|mimes:jpeg,bmp,png,jpg,gif,spg|dimensions:max_width=468,max_height=200',
        //     'EventThumbnailImage' => 'image|mimes:jpeg,bmp,png,jpg|dimensions:max_width=1280,max_height=720',
        //     'title' => 'required',
        //     'category' => 'required',
        //     'Description' => 'required',
        //     'EventDateTime' => 'required',
        // ]);

        $user = Auth::user();
        $events = Event::findOrFail($id);
        //banner image
        $bannerUrl = "";
        if ($request->hasFile('EventBannerImage')) {
            $file = $request->file('EventBannerImage');
            $name = time() . $file->getClientOriginalName();
            $userId = Auth::id();
            $filePath = 'org_'.$userId.'/' . $name;
           
            Storage::disk('s3')->put($filePath, file_get_contents($file),'public');
            $bannerUrl = $filePath;
            if(!empty($events->banner)){
                Storage::disk('s3')->delete($events->banner);
            }
            
        }
        $thumbNailUrl = "";
        if ($request->hasFile('EventThumbnailImage')) {
            $thumbnailfile = $request->file('EventThumbnailImage');
            $thumbnailName = time() . $thumbnailfile->getClientOriginalName();
            $userId = Auth::id();
            $thumbnailfilePath = 'org_'.$userId.'/Thumbnail/' . $thumbnailName;
           
            Storage::disk('s3')->put($thumbnailfilePath, file_get_contents($thumbnailfile),'public');
            $thumbNailUrl = $thumbnailfilePath;
            if(!empty($events->thumbnail)){
                Storage::disk('s3')->delete($events->thumbnail);
            }
        }

        
        $events->title = $request->title;
        $events->description = $request->Description;
        $events->category_id = $request->category;
        $events->event_type_id=$request->eventType;
        $events->user_id = $user->id;
        // $events->city_id = $request->city;
        // $events->address = $request->Address;

        $StartDateTime = $request->EventDateTime;
        //$StarteDateTi = new DateTime($StartDateTime);
        $events->date_time = new DateTime($StartDateTime);;

        $EndDateTime = $request->EventEndDateTime;
        //$newDateTime = new DateTime($EndDateTime);
        $events->end_date_time = new DateTime($EndDateTime);
        $events->timezone_id = $request->cityTimezone;

        $events->thumbnail = $thumbNailUrl;
        $events->banner = $bannerUrl;
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
            $events->city_id = null;
            $events->address = "";
            $events->online_event_url = $request->EventUrl;
        } else {
            $events->is_online = '0';
            $events->city_id = $request->city;
            $events->address = $request->Address;
        }
        $string = $request->HiddenCategoyID;
        $EventCategorieIds = preg_split("/\,/", $string);
        EventCategory::where('event_id',$events->id)->delete();
        foreach($EventCategorieIds as $categoryID){
            $eventCategory = new EventCategory;
            $eventCategory->event_id=$events->id;
            $eventCategory->category_id=number_format($categoryID);
            $eventCategory->save();
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
