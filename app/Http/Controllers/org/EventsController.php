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
use App\Speaker;
use DateTime;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\UploadedFile;
use File;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;

class EventsController extends Controller {

    public function __construct() {
        $this->middleware('verified');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index() {
        $user = Auth::user();
        $events = Event::where('user_id', $user->id)->where('date_time', '>=', date('Y-m-d', strtotime(now())))
                ->get();
        return view('org/events', compact('events'));
    }

    public function pastEvents() {
        $user = Auth::user();
        $events = Event::where('user_id', $user->id)->where('date_time', '<=', date('Y-m-d', strtotime(now())))
                ->get();
        return view('org/pastEvents', compact('events'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create() {
        $IsNew = true;
        $categories = Category::all();
        $cities = City::all();
        $countries = Country::all();
        // $states = State::all();
        $cityTimeZones = Timezone::all();
        $eventTypes = EventType::all();
        $tabe = 0;
        return view('org/createEvent', compact('categories', 'cities', 'cityTimeZones', 'eventTypes', 'IsNew', 'countries', 'tabe'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request) {
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

        $bannerUrl = "";
        if ($request->hasFile('EventBannerImage')) {
            $file = $request->file('EventBannerImage');
            $name = time() . $file->getClientOriginalName();
            $userId = Auth::id();
            $filePath = 'org_' . $userId . '/' . $name;

            Storage::disk('s3')->put($filePath, file_get_contents($file), 'public');
            $bannerUrl = $filePath;
        }

        $thumbNailUrl = "";
        if ($request->hasFile('EventThumbnailImage')) {
            $thumbnailfile = $request->file('EventThumbnailImage');
            $thumbnailName = time() . $thumbnailfile->getClientOriginalName();
            $userId = Auth::id();
            $thumbnailfilePath = 'org_' . $userId . '/Thumbnail/' . $thumbnailName;

            Storage::disk('s3')->put($thumbnailfilePath, file_get_contents($thumbnailfile), 'public');
            $thumbNailUrl = $thumbnailfilePath;
        }

        $user = Auth::user();
        $events = new Event;
        $events->title = $request->title;
        $events->description = $request->Description;
        $events->category_id = $request->category;
        $events->event_type_id = $request->eventType;
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
        $StartDateTime = $request->EventDateTime;
        $events->date_time = new DateTime($StartDateTime);
        $EndDateTime = $request->EventEndDateTime;
        $events->end_date_time = new DateTime($EndDateTime);
        $events->timezone_id = $request->cityTimezone;
        if(!empty($request->CustomUrl)){
            $events->custom_url=env('APP_URL_Custom')."/".Auth()->user()->username."/".$request->CustomUrl;
        }
       
        $events->thumbnail = $thumbNailUrl;
        $events->banner = $bannerUrl;
        if (isset($request->IsPublish)) {
            $events->is_live = '1';
        } else {
            $events->is_live = '0';
        }

        if ($request->IsPublic == "true") {
            $events->is_public = '1';
        } else {
            $events->is_public = '0';
        }

        if ($request->IsFree == "true") {
            $events->is_paid = '0';
        } else {
            $events->is_paid = '1';
        }

        $events->save();

        $category_ids = $request->HiddenCategoyID;
        $EventCategorieIds = explode(",", $category_ids);

        foreach ($EventCategorieIds as $categoryID) {
            if (!empty($categoryID)) {
                $eventCategory = new EventCategory;
                $eventCategory->event_id = $events->id;
                $eventCategory->category_id = number_format($categoryID);
                $eventCategory->save();
            }
        }
        return redirect("org/events/" . $events->id . "/1");
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id) {
        
    }

    public function storeVideo(Request $request) {
        $validator = null;
        if (isset($request->IsUploadVideo)) {
            $validator = Validator::make($request->all(), [
                        'input_title' => 'required',
                        'video_file' => 'required|mimes:mov,mp4,wmv,flv,avi'
            ]);
        } else {
            $validator = Validator::make($request->all(), [
                        'input_title' => 'required',
                        'input_url' => 'required',
            ]);
        }
        if ($validator->fails()) {
            return response()->json([
                        'error' => $validator->errors(),
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
                // $filePath1 = 'org_' . $userId . '/Video/' . $name;
                $filePath = 'org_' . $userId . '/Video';
                $fileLocation = Storage::disk('s3')->put($filePath, $request->file('video_file'));
                $UrlToSave = $fileLocation;
                // $FinalUrl = env('AWS_URL'); 
                $FinalUrl .= $UrlToSave;
                $video->url_type = 1;
                $size = $request->file('video_file')->getSize();
                $video->file_size = $size;
            }
        } else {
            $UrlToSave = $request->input_url;
            $FinalUrl = $UrlToSave;
            $video->url_type = 0;
        }

        $video->event_id = $request->EventToLink;

        $video->url = $UrlToSave;
        $video->save();
        $videoUrlLink = "";
        if ($video->url_type == 1) {
            $videoUrlLink = env('AWS_URL') . $UrlToSave;
        } else {
            $videoUrlLink = $UrlToSave;
        }
        return response()->json([
                    'videoUrl' => $videoUrlLink,
                    'videoTitle' => $video->title,
                    'videoID' => $video->id,
                    'urlType' => $video->url_type,
                    'error' => ''
        ]);
    }

    public function storePodcast(Request $request) {
        $validator = null;
        if (isset($request->IsUploadPodCast)) {
            $validator = Validator::make($request->all(), [
                        'input_title' => 'required',
                        'podcast_video_file' => 'required|mimes:mpga,m4a,wma'
            ]);
        } else {
            $validator = Validator::make($request->all(), [
                        'input_title' => 'required',
                        'input_url' => 'required',
            ]);
        }

        if ($validator->fails()) {
            return response()->json([
                        'error' => $validator->errors(),
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
                //$FinalUrl = env('AWS_URL'); 
                $FinalUrl .= $UrlToSave;
                $podcast->url_type = 1;
                $size = $request->file('podcast_video_file')->getSize();
                $podcast->file_size = $size;
            }
        } else {
            $UrlToSave = $request->input_url;
            $FinalUrl = $UrlToSave;
            $podcast->url_type = 0;
        }

        $podcast->event_id = $request->EventToLink;

        $podcast->url = $UrlToSave;
        $podcast->save();

        $podcastVideoUrlLink = "";
        if ($podcast->url_type == 1) {
            $podcastVideoUrlLink = env('AWS_URL') . $UrlToSave;
        } else {
            $podcastVideoUrlLink = $UrlToSave;
        }
        return response()->json([
                    'videoUrl' => $podcastVideoUrlLink,
                    'videoTitle' => $podcast->title,
                    'videoID' => $podcast->id,
                    'urlType' => $podcast->url_type,
                    'error' => ''
        ]);
    }

    public function storeSpeaker(Request $request) {
        //         return response()->json([
        //             'eventid' =>  $request->EventToLinkId,
        //         ]);

        $validator = null;
        $validator = Validator::make($request->all(), [
                    'speakerTitle' => 'required',
                    'speakerFirstName' => 'required',
                    'speakerLastName' => 'required',
                    'speakerOrganization' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json([
                        'error' => $validator->errors(),
            ]);
        }

        $speaker = new Speaker;
        $speaker->title = $request->speakerTitle;
        $speaker->first_name = $request->speakerFirstName;
        $speaker->last_name = $request->speakerLastName;
        $speaker->description = $request->speakerDesc;
        $speaker->organization = $request->speakerOrganization;
        $speaker->linkedin_url = $request->speakerLinkedinUrl;
        $userId = Auth::id();
        $UrlToSave = "";
        $FinalUrl = "";
        if ($request->hasFile('profilePicImageUpload')) {
            $file = $request->file('profilePicImageUpload');
            $name = time() . $file->getClientOriginalName();
            $userId = Auth::id();
            $filePath = 'org_' . $userId . '/Speaker/' . $name;
            Storage::disk('s3')->put($filePath, file_get_contents($file));
            $UrlToSave = $filePath;
            //$FinalUrl = env('AWS_URL'); 
            $FinalUrl .= $UrlToSave;
        }
        // if($request->dataPic ==""){
        //     $speaker->profile_pic = $FinalUrl;
        // } else{
        //     $speaker->profile_pic = $request->dataPic;
        // }
        $speaker->profile_pic = $FinalUrl;
        $speaker->event_id = $request->EventToLinkId;
        $speaker->save();

        $profileUrl = "";
        if ($FinalUrl != "") {
            $profileUrl = env('AWS_URL') . $FinalUrl;
        } else {
            $profileUrl = "https://via.placeholder.com/110x110";
        }

        return response()->json([
                    'profilePicImage' => $profileUrl,
                    'speakerFirstName' => $speaker->first_name,
                    'speakerLastName' => $speaker->last_name,
                    'speakerOrganization' => $speaker->organization,
                    'speakerDesc' => $speaker->description,
                    'id' => $speaker->id,
                    'error' => ''
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id, $tabe = 0) {
        $IsNew = false;
        $ids = explode(',', $id);
        $count = 0;
        foreach ($ids as $selectedId) {
            if ($count == 0) {
                $selectedId = $id;
            } else {
                $isVideoSelected = true;
            }
            $count++;
        }

        $event = Event::findOrFail($id);
        return $event->categories;
        $speakers = Speaker::where('event_id', $event->id)->get();
        $categories = Category::all();
        $cities = City::all();
        $cityTimeZones = Timezone::all();
        $eventTypes = EventType::all();
        $countries = Country::all();
        $states = State::all();
        $videos = Video::where('event_id', $event->id)->get();
        $podcasts = Podcast::where('event_id', $event->id)->get();
        return view('org/createEvent', compact('categories', 'cities', 'event', 'cityTimeZones', 'eventTypes', 'IsNew', 'countries', 'states', 'tabe', 'videos', 'podcasts', 'speakers'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id) {
        $user = Auth::user();
        $events = Event::findOrFail($id);

        $bannerUrl = "";
        if ($request->hasFile('EventBannerImage')) {
            $file = $request->file('EventBannerImage');
            $name = time() . $file->getClientOriginalName();
            $userId = Auth::id();
            $filePath = 'org_' . $userId . '/' . $name;

            Storage::disk('s3')->put($filePath, file_get_contents($file), 'public');
            $bannerUrl = $filePath;
            $events->banner = $bannerUrl;
            if (!empty($events->banner)) {
                Storage::disk('s3')->delete($events->banner);
            }
        }
        $thumbNailUrl = "";
        if ($request->hasFile('EventThumbnailImage')) {
            $thumbnailfile = $request->file('EventThumbnailImage');
            $thumbnailName = time() . $thumbnailfile->getClientOriginalName();
            $userId = Auth::id();
            $thumbnailfilePath = 'org_' . $userId . '/Thumbnail/' . $thumbnailName;

            Storage::disk('s3')->put($thumbnailfilePath, file_get_contents($thumbnailfile), 'public');
            $thumbNailUrl = $thumbnailfilePath;
            $events->thumbnail = $thumbNailUrl;
            if (!empty($events->thumbnail)) {
                Storage::disk('s3')->delete($events->thumbnail);
            }
        }


        $events->title = $request->title;
        $events->description = $request->Description;
        $events->category_id = $request->category;
        $events->event_type_id = $request->eventType;
        $events->user_id = $user->id;

        $StartDateTime = $request->EventDateTime;
        $events->date_time = new DateTime($StartDateTime);
        ;

        $EndDateTime = $request->EventEndDateTime;
        $events->end_date_time = new DateTime($EndDateTime);
        $events->timezone_id = $request->cityTimezone;
        if(!empty($request->CustomUrl)){
            $events->custom_url=env('APP_URL_Custom')."/".Auth()->user()->username."/".$request->CustomUrl;
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

        if (isset($request->IsPublish)) {
            $events->is_live = '1';
        } else {
            $events->is_live = '0';
        }

        if ($request->IsPublic == "true") {
            $events->is_public = '1';
        } else {
            $events->is_public = '0';
        }

        if ($request->IsFree == "true") {
            $events->is_paid = '0';
        } else {
            $events->is_paid = '1';
        }

        $string = $request->HiddenCategoyID;
        $EventCategorieIds = preg_split("/\,/", $string);
        EventCategory::where('event_id', $events->id)->delete();
        foreach ($EventCategorieIds as $categoryID) {
            $eventCategory = new EventCategory;
            $eventCategory->event_id = $events->id;
            $eventCategory->category_id = number_format($categoryID);
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
    public function destroy(Request $request) {
        //
        $event = Event::find($request->eventDeleteId)->delete();
    }

    public function destroyVideo($id, $Type, $UrlType) {
        if ($Type == "speaker") {
            $speaker = Speaker::find($id);
            if (!empty($speaker->profile_pic)) {
                Storage::disk('s3')->delete($speaker->profile_pic);
            }
            Speaker::find($id)->delete();
        } else if ($Type == "podcast") {
            // $event = Podcast::find($id)->delete();
            $media = Podcast::find($id);
            if (!empty($media->url)) {
                Storage::disk('s3')->delete($media->url);
            }
            Podcast::find($id)->delete();
        } else {
            $media = Video::find($id);
            if (!empty($media->url)) {
                Storage::disk('s3')->delete($media->url);
            }
            Video::find($id)->delete();
        }

        return "success";
    }

    public function UpdateEventStatus(Request $request) {
        $id = $request->id;
        $events = Event::findOrFail($id);
        if ($request->status == '1') {
            $events->is_live = 2;
        }
        if ($request->status == '2') {
            $events->is_live = 1;
        }
        if ($request->status == '3') {
            $events->is_live = 3;
        }

        $events->save();
    }

    public function getState(Request $request) {

        $states = State::where('country_id', $request->countryId)->get();
        $stateOptions = "<option PresenceCheck='-1' value>Select State</option>";
        foreach ($states as $state) {
            $stateOptions .= "<option value='" . $state->id . "' >" . $state->name . "</option>";
        }
        return $stateOptions;
    }

    public function getCity(Request $request) {

        $citys = City::where('state_id', $request->cityId)->get();

        $cityOptions = "<option PresenceCheck='-1' value>Select City</option>";
        foreach ($citys as $city) {
            $cityOptions .= "<option value='" . $city->id . "' >" . $city->name . "</option>";
        }
        return $cityOptions;
    }

    public function deleteProfilePic(Request $request) {
        if ($request->dataPic) {
            Storage::disk('s3')->delete($request->dataPic);
            $speaker = Speaker::findOrFail($request->id);
            $speaker->profile_pic = "";
            $speaker->save();
        }
    }

    public function editSpeaker(Request $request, $id) {
        $speakers = Speaker::findOrFail($request->id);
        $FinalUrl = env('AWS_URL');
        $FinalUrl .= $speakers->profile_pic;
        if ($speakers->profile_pic != '') {
            $speakers->profile_pic = $FinalUrl;
        } else {
            $speakers->profile_pic = '';
        }
        // $speakers->profile_pic = $FinalUrl;
        return $speakers;
    }

    public function updateSpeaker(Request $request, $id) {
        $validator = null;
        $validator = Validator::make($request->all(), [
                    'speakerTitle' => 'required',
                    'speakerFirstName' => 'required',
                    'speakerLastName' => 'required',
                    'speakerOrganization' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json([
                        'error' => $validator->errors(),
            ]);
        }

        $speaker = Speaker::findOrFail($id);
        $speaker->title = $request->speakerTitle;
        $speaker->first_name = $request->speakerFirstName;
        $speaker->last_name = $request->speakerLastName;
        $speaker->description = $request->speakerDesc;
        $speaker->organization = $request->speakerOrganization;
        $speaker->linkedin_url = $request->speakerLinkedinUrl;
        $userId = Auth::id();
        $UrlToSave = "";
        $FinalUrl = $speaker->profile_pic;
        if ($request->hasFile('profilePicImageUpload')) {
            $FinalUrl = '';
            Storage::disk('s3')->delete($speaker->profile_pic);

            $file = $request->file('profilePicImageUpload');
            $name = time() . $file->getClientOriginalName();
            $userId = Auth::id();
            $filePath = 'org_' . $userId . '/Speaker/' . $name;
            Storage::disk('s3')->put($filePath, file_get_contents($file));
            $UrlToSave = $filePath;
            //$FinalUrl = env('AWS_URL'); 
            $FinalUrl .= $UrlToSave;
        }
        $speaker->profile_pic = $FinalUrl;
        $speaker->event_id = $request->EventToLinkId;
        $speaker->save();

        $profileUrl = "";
        if ($FinalUrl != "") {
            $profileUrl = env('AWS_URL') . $FinalUrl;
        } else {
            $profileUrl = "https://via.placeholder.com/110x110";
        }

        return response()->json([
                    'profilePicImage' => $profileUrl,
                    'speakerFirstName' => $speaker->first_name,
                    'speakerLastName' => $speaker->last_name,
                    'speakerOrganization' => $speaker->organization,
                    'speakerDesc' => $speaker->description,
                    'id' => $speaker->id,
                    'error' => ''
        ]);
    }

}
