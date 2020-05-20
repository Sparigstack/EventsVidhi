<?php

namespace App\Http\Controllers\org;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DB;
use App\Event;
use App\Category;
use App\City;
use App\Country;
use App\State;
use App\Timezone;
use App\EventCategory;
use App\EventType;
use App\Video;
use App\Podcast;
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
        $IsNew = true;
        $categories = Category::all();
        $cities = City::all();
        $countries = Country::all();
        // $states = State::all();
        $cityTimeZones = Timezone::all();
        $eventTypes=EventType::all();
        $tabe=0;
        return view('org/createEvent', compact('categories', 'cities', 'cityTimeZones','eventTypes','IsNew', 'countries','tabe'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // return $request->Address2;
        $validator = Validator::make($request->all(), [
            'EventBannerImage' => 'image|mimes:jpeg,bmp,png,jpg,gif,spg|dimensions:max_width=845,max_height=445',
            'EventThumbnailImage' => 'image|mimes:jpeg,bmp,png,jpg|dimensions:max_width=420,max_height=360',
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
            $events->address = $request->Address1;
            $events->address_line2 = $request->Address2;
            $events->postal_code = $request->PostalCode;
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
        // if (isset($request->IsPublic)) {
        //     $events->is_public = '1';
        // } else {
        //     $events->is_public = '0';
        // }
        // if (isset($request->IsPaid)) {
        //     $events->is_paid = '1';
        // } else {
        //     $events->is_paid = '0';
        // }

        if (isset($request->IsPublish)) {
            $events->is_live = '1';
        } else {
            $events->is_live = '0';
        }
        
        if ($request->IsPublic=="true") {
            $events->is_public = '1';
        } else {
            $events->is_public = '0';
        }

        if ($request->IsFree=="true") {
            $events->is_paid = '0';
        } else {
            $events->is_paid = '1';
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
        return redirect("org/events/".$events->id."/1");
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
       
    }

    public function storeVideo(Request $request)
    {
        // return $request;
        // return response()->json([
        //     'message'=>'coming here',
        //     'mf'=>'hussain'
        // ]);
        $validator=null ;
        if (isset($request->IsUploadVideo)){
            $validator = Validator::make($request->all(), [
                'input_title' => 'required',
                'input_vidfile'=>'required|mimes:mov,mp4,wmv,flv,avi'
            ]);
        }else{
            $validator = Validator::make($request->all(), [
                'input_title' => 'required',
                'input_url' => 'required',
            ]);
        }

        $video = new Video;
        $video->title = $request->input_title;
        $userId = Auth::id();
        $video->user_id = $userId;
        $UrlToSave = "";
        $FinalUrl = ""; 
        if (isset($request->IsUploadVideo)) {
            if ($request->hasFile('video_file')) {
                $file = $request->file('video_file');
                $name = time() . $file->getClientOriginalName();
                $userId = Auth::id();
                $filePath = 'org_' . $userId . '/Video/' . $name;
                Storage::disk('s3')->put($filePath, file_get_contents($file));
                $UrlToSave = $filePath;
                $FinalUrl = env('AWS_URL'); 
                $FinalUrl .=$UrlToSave;
            }
        } else {
            $UrlToSave = $request->input_url;
            $FinalUrl=$UrlToSave;
        }

        $video->event_id = $request->EventToLink;

        $video->url = $UrlToSave;
        $video->save();
        return response()->json([
            'videoUrl'=>$FinalUrl,
            'videoTitle'=>$video->title,
            'videoID'=>$video->id
        ]);
    }

    public function storePodcast(Request $request)
    {
        // return $request;
        // return response()->json([
        //     'message'=>'coming here',
        //     'mf'=>'hussain'
        // ]);
        $validator=null ;
        if (isset($request->PodCastUpload)){
            $validator = Validator::make($request->all(), [
                'input_title' => 'required',
                'podcast_video_file'=>'required|mimes:mp3,m4a,wma'
            ]);
        }else{
            $validator = Validator::make($request->all(), [
                'input_title' => 'required',
                'input_url' => 'required',
            ]);
        }

        $podcast = new Podcast;
        $podcast->title = $request->input_title;
        $userId = Auth::id();
        $podcast->user_id = $userId;
        $UrlToSave = "";
        $FinalUrl = ""; 
        if (isset($request->IsUploadPodCast)) {
            if ($request->hasFile('podcast_video_file')) {
                $file = $request->file('podcast_video_file');
                $name = time() . $file->getClientOriginalName();
                $userId = Auth::id();
                $filePath = 'org_' . $userId . '/Podcast/' . $name;
                Storage::disk('s3')->put($filePath, file_get_contents($file));
                $UrlToSave = $filePath;
                $FinalUrl = env('AWS_URL'); 
                $FinalUrl .=$UrlToSave;
            }
        } else {
            $UrlToSave = $request->input_url;
            $FinalUrl=$UrlToSave;
        }

        $podcast->event_id = $request->EventToLink;

        $podcast->url = $UrlToSave;
        $podcast->save();
        return response()->json([
            'videoUrl'=>$FinalUrl,
            'videoTitle'=>$podcast->title,
            'videoID'=>$podcast->id
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id,$tabe=0)
    {
        $IsNew = false;
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
        $countries = Country::all();
        $states = State::all();
        $videos= Video::where('event_id',$event->id)->get();
        $podcasts= Podcast::where('event_id',$event->id)->get();
        return view('org/createEvent', compact('categories', 'cities', 'event','cityTimeZones','eventTypes','IsNew', 'countries', 'states','tabe','videos','podcasts'));
        
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
        // if (isset($request->IsPublic)) {
        //     $events->is_public = '1';
        // } else {
        //     $events->is_public = '0';
        // }
        // if (isset($request->IsPaid)) {
        //     $events->is_paid = '1';
        // } else {
        //     $events->is_paid = '0';
        // }
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

        if (isset($request->IsPublish)) {
            $events->is_live = '1';
        } else {
            $events->is_live = '0';
        }
        
        if ($request->IsPublic=="true") {
            $events->is_public = '1';
        } else {
            $events->is_public = '0';
        }

        if ($request->IsFree=="true") {
            $events->is_paid = '0';
        } else {
            $events->is_paid = '1';
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
    public function destroyVideo($id,$Type)
    {
        if($Type=="podcast"){
            $event = Podcast::find($id)->delete();
        }else{
            $event = Video::find($id)->delete();
        }
       
        return "success";
    }

    public function UpdateEventStatus(Request $request)
    {
        $id = $request->id;
        $events = Event::findOrFail($id);
        if($request->status=='1'){
            $events->is_live = 2;
        }
        if($request->status=='2'){
            $events->is_live = 1;
        }
        if($request->status=='3'){
            $events->is_live = 3;
        }
        
        $events->save();
    }

    public function getState(Request $request){
        
        $states = State::where('country_id',$request->countryId)->get();
        $stateOptions="<option value='-1'>Select State</option>";
        foreach($states as $state){
            $stateOptions .="<option value='".$state->id."' >".$state->name."</option>";
        }
        return $stateOptions;
    }

    public function getCity(Request $request){
        
        $citys = City::where('state_id',$request->cityId)->get();

        $cityOptions="<option value='-1'>Select City</option>";
        foreach($citys as $city){
            $cityOptions .="<option value='".$city->id."' >".$city->name."</option>";
        }
        return $cityOptions;
    }
}
