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
use App\Ticket;
use App\ContentFollower;
use App\EventRegistrant;
use DateTime;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\UploadedFile;
use File;
use App\Mail\Email;
use Mail;
use App\CustomClass\MailContent;
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
        $user = Auth::user();
        $events = Event::where('user_id', $user->id)->where('date_time', '>=', date('Y-m-d', strtotime(now())))->orderBy('id', 'DESC')
            ->get();
        return view('org/events', compact('events'));
    }

    public function pastEvents()
    {
        $user = Auth::user();
        $events = Event::where('user_id', $user->id)->where('date_time', '<=', date('Y-m-d', strtotime(now())))->orderBy('id', 'DESC')
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
        $user = Auth::id();
        $IsNew = true;
        $categories = Category::all();
        $cities = City::all();
        $countries = Country::all();
        // $states = State::all();
        $cityTimeZones = Timezone::all();
        $eventTypes = EventType::all();
        $tabe = 0;
        $eventRegistrantsResult = EventRegistrant::where('contact_id', $user)->get();
        return view('org/createEvent', compact('categories', 'cities', 'cityTimeZones', 'eventTypes', 'IsNew', 'countries', 'tabe', 'eventRegistrantsResult'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'EventBannerImage' => 'image|mimes:jpeg,bmp,png,jpg,gif,spg|dimensions:min_width=970,min_height=330',
            'EventThumbnailImage' => 'image|mimes:jpeg,bmp,png,jpg|dimensions:max_width=420,max_height=360',
            'title' => 'required',
            'category' => 'required',
            'Description' => 'required',
            'EventDateTime' => 'required',
            'EventEndDateTime' => 'after_or_equal:EventDateTime',
        ]);

        // date_format:m/d/Y g:i A|after_or_equal:EventDateTime

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
            $events->city = $request->city;
            $events->state = $request->state;
            $events->address = $request->Address1;
            $events->country_id = $request->country;
            $events->address_line2 = $request->Address2;
            $events->postal_code = $request->PostalCode;
            $events->is_online = '0';
        }

        $StartDateTime = $request->EventDateTime;
        // $customFormat=explode(' ', $StartDateTime);
        // $arr = explode('/', $customFormat[0]);
        // $newStartDate = $arr[2].'-'.$arr[1].'-'.$arr[0]. $customFormat[1];
        // $events->date_time = new DateTime($newStartDate);
        
        $EndDateTime = $request->EventEndDateTime;
        // $customFormat1=explode(' ', $EndDateTime);
        // $arr1 = explode('/', $customFormat1[0]);
        // $newEndDate = $arr1[2].'-'.$arr1[1].'-'.$arr1[0]. $customFormat1[1];
        // $events->end_date_time = new DateTime($newEndDate);

        $events->date_time = new DateTime($StartDateTime);
        $events->end_date_time = new DateTime($EndDateTime);
        
        $events->timezone_id = $request->cityTimezone;
        if (!empty($request->CustomUrl)) {
            $events->custom_url = $request->CustomUrl;
        }

        $events->thumbnail = $thumbNailUrl;
        $events->banner = $bannerUrl;
        // if (isset($request->IsPublish)) {
        //     $events->is_live = '1';
        // } else {
        //     $events->is_live = '0';
        // }
        if ($request->IsPublish == "true") {
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
    public function show($id)
    {
    }

    public function storeVideo(Request $request)
    {
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
        // required|regex:/http:\/\/(?:www.)?(?:(vimeo).com\/(.*)|(youtube).com\/watch\?v=(.*?)&)/
        // regex:/^(https?:\/\/)?([\da-z\.-]+)\.([a-z\.]{2,6})([\/\w \.-]*)*\/?$/
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
            $videoUrl = $UrlToSave;
            if(strpos($videoUrl, 'youtube') !== false){
                $explodeUrl = explode('=', $videoUrl);
                $getLastWord = array_pop($explodeUrl);
                $videoUrlLink = "https://www.youtube.com/embed/" . $getLastWord;
            }else{
                $explodeUrl = explode('/', $videoUrl);
                $getLastWord = array_pop($explodeUrl);
                $videoUrlLink = "https://player.vimeo.com/video/" . $getLastWord;
            }
        }
        return response()->json([
            'videoUrl' => $videoUrlLink,
            'videoTitle' => $video->title,
            'videoID' => $video->id,
            'urlType' => $video->url_type,
            'error' => ''
        ]);
    }

    public function storePodcast(Request $request)
    {
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
        // regex:/^(https?:\/\/)?([\da-z\.-]+)\.([a-z\.]{2,6})([\/\w \.-]*)*\/?$/

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

    public function storeSpeaker(Request $request)
    {
        //         return response()->json([
        //             'eventid' =>  $request->EventToLinkId,
        //         ]);

        $validator = null;
        $validator = Validator::make($request->all(), [
            'speakerTitle' => 'required',
            'speakerFirstName' => 'required',
            // 'speakerLastName' => 'required',
            'speakerOrganization' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'error' => $validator->errors(),
            ]);
        }

        $speaker = new Speaker;
        $speaker->title = $request->speakerTitle;
        $speaker->name = $request->speakerFirstName;
        // $speaker->last_name = $request->speakerLastName;
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
            'speakerFirstName' => $speaker->name,
            // 'speakerLastName' => $speaker->last_name,
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
    public function edit($id, $tabe = 0)
    {
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
        $speakers = Speaker::where('event_id', $event->id)->orderBy('id', 'DESC')->get();
        $categories = Category::all();
        
        $cities = City::all();
        $cityTimeZones = Timezone::all();
        $eventTypes = EventType::all();
        $countries = Country::all();
        $states = State::all();
        $videos = Video::where('event_id', $event->id)->orderBy('id', 'DESC')->get();
        $tickets = Ticket::where('event_id', $event->id)->orderBy('id', 'DESC')->get();
        $podcasts = Podcast::where('event_id', $event->id)->orderBy('id', 'DESC')->get();
        
//        $eventRegistrants = EventRegistrant::where('event_id', $event->id)->get();
        $eventRegistrants = "SELECT u.name,u.email,u.phone,er.created_at AS registeredOn FROM users u JOIN event_registrant er ON u.id = er.contact_id WHERE
                er.event_id=". $event->id;
        $eventRegistrantsResult = DB::select(DB::raw($eventRegistrants));
        return view('org/createEvent', compact('categories', 'cities', 'event', 'cityTimeZones', 'eventTypes', 'IsNew', 'countries', 'states', 'tabe', 'videos', 'podcasts', 'speakers', 'tickets', 'eventRegistrantsResult'));
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

        $validator = Validator::make($request->all(), [
            'EventBannerImage' => 'image|mimes:jpeg,bmp,png,jpg,gif,spg|dimensions:min_width=970,min_height=330',
            'EventThumbnailImage' => 'image|mimes:jpeg,bmp,png,jpg|dimensions:max_width=420,max_height=360',
            'title' => 'required',
            'category' => 'required',
            'Description' => 'required',
            'EventDateTime' => 'required',
            'EventEndDateTime' => 'after_or_equal:EventDateTime',
        ]);

        // date_format:m/d/Y g:i A|after_or_equal:EventDateTime

        if ($validator->fails()) {
            return redirect('org/events/'. $events->id)
                ->withErrors($validator)
                ->withInput();
        }

        $bannerUrl = "";
        if (empty($request->eventBannerPic) && !empty($events->banner)) {
                Storage::disk('s3')->delete($events->banner);
                $events->banner = "";
        }
        if ($request->hasFile('EventBannerImage')) {
            $file = $request->file('EventBannerImage');
            $name = time() . $file->getClientOriginalName();
            $userId = Auth::id();
            $filePath = 'org_' . $userId . '/' . $name;

            Storage::disk('s3')->put($filePath, file_get_contents($file), 'public');
            $bannerUrl = $filePath;
            if (!empty($events->banner)) {
                Storage::disk('s3')->delete($events->banner);
            }
            $events->banner = $bannerUrl;
        }

        $thumbNailUrl = "";
        if (empty($request->eventThumbPic) && !empty($events->thumbnail)) {
                Storage::disk('s3')->delete($events->thumbnail);
                $events->thumbnail = "";
        }
        if ($request->hasFile('EventThumbnailImage')) {
            $thumbnailfile = $request->file('EventThumbnailImage');
            $thumbnailName = time() . $thumbnailfile->getClientOriginalName();
            $userId = Auth::id();
            $thumbnailfilePath = 'org_' . $userId . '/Thumbnail/' . $thumbnailName;

            Storage::disk('s3')->put($thumbnailfilePath, file_get_contents($thumbnailfile), 'public');
            $thumbNailUrl = $thumbnailfilePath;
            if (!empty($events->thumbnail)) {
                Storage::disk('s3')->delete($events->thumbnail);
            }
            $events->thumbnail = $thumbNailUrl;
        }


        $events->title = $request->title;
        $events->description = $request->Description;
        $events->category_id = $request->category;
        $events->event_type_id = $request->eventType;
        $events->user_id = $user->id;

        $StartDateTime = $request->EventDateTime;
        $events->date_time = new DateTime($StartDateTime);;

        $EndDateTime = $request->EventEndDateTime;
        $events->end_date_time = new DateTime($EndDateTime);
        $events->timezone_id = $request->cityTimezone;
        if (!empty($request->CustomUrl)) {
            $events->custom_url = $request->CustomUrl;
        }


        if (isset($request->IsOnline)) {
            $events->is_online = '1';
            $events->city = "";
            $events->address = "";
            $events->state = "";
            $events->country_id = null;
            $events->address_line2 = "";
            $events->postal_code = "";
            $events->online_event_url = $request->EventUrl;
        } else {
            $events->is_online = '0';
            $events->city = $request->city;
            $events->address = $request->Address;
            $events->state = $request->state;
            $events->address = $request->Address1;
            $events->country_id = $request->country;
            $events->address_line2 = $request->Address2;
            $events->postal_code = $request->PostalCode;
        }

        // if (isset($request->IsPublish)) {
        //     $events->is_live = '1';
        // } else {
        //     $events->is_live = '0';
        // }

        if ($request->IsPublish == "true") {
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
            // $eventCategory->category_id = number_format($categoryID);
            $eventCategory->category_id = (int) $categoryID;
            $eventCategory->save();
        }

        $events->save();

        // $followEventUsers = ContentFollower::where('content_id', $events->id)->where('discriminator', 'e')->get();

        $eventDetails = Event::where('id', $events->id)->first();

        $sdStamp = strtotime($eventDetails->date_time);
        $sd = date("d M, Y", $sdStamp);
        $st = date('H:i A', $sdStamp);
        $dateStr = date("d M, Y", $sdStamp) . ' ' . $st;

        $followEventUsers = DB::table('content_followers')->select('content_followers.*', 'users.name as userName', 'users.email as userEmail' )->join('users', 'content_followers.user_id', '=', 'users.id')->where('content_followers.content_id', $events->id)->where('content_followers.discriminator', 'e')->get();

        if($request->checkYes == "1") {
            foreach($followEventUsers as $followEventUser){
                $mail_content = new MailContent();
                $mail_content->user_name = $followEventUser->userName;
                $mail_content->event_title = $eventDetails->title;
                $mail_content->org_name = $eventDetails->user->name;
                $mail_content->event_datetime = $dateStr;
                $mail_content->event_id = $eventDetails->id;
                $data = ['view' => 'mails.eventSchedule', 'mail_content' => $mail_content, 'subject' => 'Event Schedule Update'];
                $emailOb = new Email($data);
                Mail::to($followEventUser->userEmail)->send($emailOb);
            }
        }

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

    public function destroyVideo($id, $Type, $UrlType)
    {
        if ($Type == "speaker") {
            $speaker = Speaker::find($id);
            if (!empty($speaker->profile_pic)) {
                Storage::disk('s3')->delete($speaker->profile_pic);
            }
            Speaker::find($id)->delete();
        } else if ($Type == "ticket") {
            Ticket::find($id)->delete();
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

    public function UpdateEventStatus(Request $request)
    {
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

    public function getState(Request $request)
    {

        $states = State::where('country_id', $request->countryId)->get();
        $stateOptions = "<option PresenceCheck='-1' value>Select State</option>";
        foreach ($states as $state) {
            $stateOptions .= "<option value='" . $state->id . "' >" . $state->name . "</option>";
        }
        return $stateOptions;
    }

    public function getCity(Request $request)
    {

        $citys = City::where('state_id', $request->cityId)->get();

        $cityOptions = "<option PresenceCheck='-1' value>Select City</option>";
        foreach ($citys as $city) {
            $cityOptions .= "<option value='" . $city->id . "' >" . $city->name . "</option>";
        }
        return $cityOptions;
    }

    public function deleteProfilePic(Request $request)
    {
        if ($request->dataPic) {
            Storage::disk('s3')->delete($request->dataPic);
            $speaker = Speaker::findOrFail($request->id);
            $speaker->profile_pic = "";
            $speaker->save();
        }
    }

    public function editSpeaker(Request $request, $id)
    {
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

    public function updateSpeaker(Request $request, $id)
    {
        $validator = null;
        $validator = Validator::make($request->all(), [
            'speakerTitle' => 'required',
            'speakerFirstName' => 'required',
            // 'speakerLastName' => 'required',
            'speakerOrganization' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'error' => $validator->errors(),
            ]);
        }

        $speaker = Speaker::findOrFail($id);
        $speaker->title = $request->speakerTitle;
        $speaker->name = $request->speakerFirstName;
        // $speaker->last_name = $request->speakerLastName;
        $speaker->description = $request->speakerDesc;
        $speaker->organization = $request->speakerOrganization;
        $speaker->linkedin_url = $request->speakerLinkedinUrl;
        $userId = Auth::id();
        $UrlToSave = "";
        $FinalUrl = $speaker->profile_pic;
        if (empty($request->eventSpeakerPic) && !empty($speaker->profile_pic)) {
                Storage::disk('s3')->delete($speaker->profile_pic);
                $speaker->profile_pic = "";
        }
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
            $speaker->profile_pic = $FinalUrl;
        }
        
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
            'speakerFirstName' => $speaker->name,
            // 'speakerLastName' => $speaker->last_name,
            'speakerOrganization' => $speaker->organization,
            'speakerDesc' => $speaker->description,
            'id' => $speaker->id,
            'error' => ''
        ]);
    }

    public function storeTicket(Request $request)
    {
        $ticket = new Ticket;
        $ticket->name = $request->TicketName;
        $ticket->quantity = $request->TicketQuantity;
        $ticket->price = $request->TicketPrice;

        $StartDateTime = $request->SalesStart;
        $ticket->sales_start = new DateTime($StartDateTime);

        $EndDateTime = $request->SalesEnd;
        $ticket->sales_end = new DateTime($EndDateTime);

        $ticket->event_id = $request->TicketEventID;

        $ticket->save();

        // $old_date =$ticket->$request->SalesEnd;
        $old_date =$request->SalesEnd;
        $old_date_timestamp = strtotime($old_date);
        $new_date = date('l, F d y h:i:s', $old_date_timestamp);

        return response()->json([
            'name' => $ticket->name,
            'quantity' => $ticket->quantity,
            'price' => $ticket->price,
            'id' => $ticket->id,
            'endDate' => $new_date,
            'error' => ''
        ]);
    }

    public function editTicket(Request $request, $id)
    {
        $tickets = Ticket::findOrFail($request->id);
        $startDate = strtotime($tickets->sales_start);
        $tickets->sales_start = date('m/d/Y h:i A', $startDate);

        $endDate = strtotime($tickets->sales_end);
        $tickets->sales_end = date('m/d/Y h:i A', $endDate);
        
        return $tickets;
    }

    public function updateTicket(Request $request, $id)
    {
        $ticket = Ticket::findOrFail($id);
        $ticket->name = $request->TicketName;
        $ticket->quantity = $request->TicketQuantity;
        $ticket->price = $request->TicketPrice;

        $StartDateTime = $request->SalesStart;
        $ticket->sales_start = new DateTime($StartDateTime);

        $EndDateTime = $request->SalesEnd;
        $ticket->sales_end = new DateTime($EndDateTime);

        $ticket->event_id = $request->TicketEventID;

        $ticket->save();

        // $old_date =$ticket->$request->SalesEnd;
        $old_date =$request->SalesEnd;
        $old_date_timestamp = strtotime($old_date);
        $new_date = date('l, F d y h:i:s', $old_date_timestamp);

        return response()->json([
            'name' => $ticket->name,
            'id' => $ticket->id,
            'quantity' => $ticket->quantity,
            'price' => $ticket->price,
            'endDate' => $new_date,
            'error' => ''
        ]);
    }

    public function copyEvent(Request $request){
        $eventDetails = Event::where('id', $request->eventId)->get();

        $user = Auth::user();
        foreach($eventDetails as $eventData){
            $events = new Event;
            $events->title = $eventData->title;
            $events->description = $eventData->description;
            $events->category_id = $eventData->category_id;
            $events->event_type_id = $eventData->event_type_id;
            $events->user_id = $user->id;
            if (isset($eventData->is_online)) {
                $events->is_online = '1';
                $events->online_event_url = $eventData->online_event_url;
            } else {
                $events->city_id = $eventData->city_id;
                $events->address = $eventData->address;
                $events->address_line2 = $eventData->address_line2;
                $events->postal_code = $eventData->postal_code;
                $events->is_online = '0';
            }
            $events->date_time = $eventData->date_time;
            $events->end_date_time = $eventData->end_date_time;
            $events->timezone_id = $eventData->timezone_id;
            if(!empty($eventData->custom_url)){
                $events->custom_url=$eventData->custom_url;
            }
       
            $events->is_live = $eventData->is_live;
            $events->is_public = $eventData->is_public;
            $events->is_paid = $eventData->is_paid;

            $bannerUrl = "";
            if (!empty($eventData->banner)) {
                $bannerFile = $eventData->banner;
                $bannerFileArr = explode('/', $bannerFile);
                $fileName = "";
                foreach ($bannerFileArr as $bannerFileName) {
                     $fileName = $bannerFileName;
                 } 
                 $bannerfilePath = 'org_' . $user->id  . '/' . time(). $fileName;
               
                $getBannerFile = Storage::disk('s3')->get($bannerFile);
                Storage::disk('s3')->put($bannerfilePath, $getBannerFile, 'public');
                
                $bannerUrl = $bannerfilePath;
            }

            $thumbnailUrl = "";
            if (!empty($eventData->thumbnail)) {
                $thumbnailfile = $eventData->thumbnail;
                $thumbnailFileArr = explode('/', $thumbnailfile);
                $fileName = "";
                foreach ($thumbnailFileArr as $thumbnailFileName) {
                     $fileName = $thumbnailFileName;
                 } 
                 $thumbnailfilePath = 'org_' . $user->id . '/Thumbnail/' . time(). $fileName;
               
                $getFile = Storage::disk('s3')->get($thumbnailfile);
                Storage::disk('s3')->put($thumbnailfilePath, $getFile, 'public');
                
                $thumbnailUrl = $thumbnailfilePath;
            }

            $events->banner = $bannerUrl;
            $events->thumbnail = $thumbnailUrl;
            $events->save();
        }
        
        $eventCategories = EventCategory::where('event_id',$request->eventId)->get();
        foreach ($eventCategories as $categoryDetail) {
            if (!empty($categoryDetail)) {
                $eventCategory = new EventCategory;
                $eventCategory->event_id = $events->id;
                $eventCategory->category_id = $categoryDetail->category_id;
                $eventCategory->save();
            }
        }

        // $eventVideos = Video::where('event_id',$request->eventId)->get();
        // foreach($eventVideos as $eventVideo){
        //     if(!empty($eventVideo)){
        //         $video = new Video;
        //         $video->title = $eventVideo->title;
        //         $userId = Auth::id();
        //         $video->user_id = $userId;

        //         $UrlToSave = "";
        //         $FinalUrl = "";
        //         if ($eventVideo->url_type == '1') {
        //             $videofile = $eventVideo->url;
        //             $videofilePath = 'org_' . $user->id . '/Video';
        //             $getVideoFile = Storage::disk('s3')->get($videofile);
        //             $videoFileLocation =Storage::disk('s3')->put($videofilePath, $getVideoFile);
        //             $UrlToSave = $videoFileLocation;
        //             //$FinalUrl .= $UrlToSave;
        //             $video->url_type = 1;
        //             $video->file_size = $eventVideo->file_size;
        //         } else {
        //             $UrlToSave = $eventVideo->url;
        //             //$FinalUrl = $UrlToSave;
        //             $video->url_type = 0;
        //         }

        //         $video->event_id = $events->id;
        //         $video->url = $UrlToSave;
        //         $video->save();
        //     }
        // }

        // $eventPodcasts = Podcast::where('event_id',$request->eventId)->get();
        // foreach($eventPodcasts as $eventPodcast){
        //     if(!empty($eventPodcast)){
        //         $podcast = new Podcast;
        //         $podcast->title = $eventPodcast->title;
        //         $userId = Auth::id();
        //         $podcast->user_id = $userId;
        //         $UrlToSave = "";
        //         $FinalUrl = "";
        //         if ($eventPodcast->url_type == '1') {
        //             $podcastVideofile = $eventPodcast->url;
        //             $podcastVideofileArr = explode('/', $podcastVideofile);
        //             $fileName = "";
        //             foreach ($podcastVideofileArr as $podcastVideofileName) {
        //                 $fileName = $podcastVideofileName;
        //             }
        //             $podcastVideoFilePath = 'org_' . $user->id . '/Podcast/' . time(). $fileName; 
        //             $getPodcastFile = Storage::disk('s3')->get($podcastVideofile);
        //             $podcastVideoFileLocation =Storage::disk('s3')->put($podcastVideoFilePath, $getPodcastFile);
        //             $UrlToSave = $podcastVideoFilePath;
        //             //$FinalUrl .= $UrlToSave;
        //             $podcast->url_type = 1;
        //             $podcast->file_size = $eventPodcast->file_size;
        //         } else {
        //             $UrlToSave = $eventPodcast->url;
        //             //$FinalUrl = $UrlToSave;
        //             $podcast->url_type = 0;
        //         }

        //         $podcast->event_id = $events->id;
        //         $podcast->url = $UrlToSave;
        //         $podcast->save();
        //     }
        // }

        // $eventSpeakers =  Speaker::where('event_id',$request->eventId)->get();
        // foreach($eventSpeakers as $eventSpeaker){
        //     if(!empty($eventSpeaker)){
        //         $speaker = new Speaker;
        //         $speaker->title = $eventSpeaker->title;
        //         $speaker->first_name = $eventSpeaker->first_name;
        //         $speaker->last_name = $eventSpeaker->last_name;
        //         $speaker->description = $eventSpeaker->description;
        //         $speaker->organization = $eventSpeaker->organization;
        //         $speaker->linkedin_url = $eventSpeaker->linkedin_url;
        //         $userId = Auth::id();

        //         $UrlToSave = "";
        //         $FinalUrl = "";
        //         if (!empty($eventSpeaker->profile_pic)) {
        //             $profilePicFile = $eventSpeaker->profile_pic;
        //             $profilePicFileArr = explode('/', $profilePicFile);
        //             $fileName = "";
        //             foreach ($profilePicFileArr as $profilePicFileName) {
        //                 $fileName = $profilePicFileName;
        //             } 
        //             $profilePicFilePath = 'org_' . $user->id . '/Speaker/' . time(). $fileName;
               
        //             $getProfilePicFile = Storage::disk('s3')->get($profilePicFile);
        //             Storage::disk('s3')->put($profilePicFilePath, $getProfilePicFile, 'public');
                
        //             $UrlToSave = $profilePicFilePath;
        //             $FinalUrl .= $UrlToSave;
        //         }

        //         $speaker->profile_pic = $FinalUrl;
        //         $speaker->event_id = $events->id;
        //         $speaker->save();
        //     }
        // }

    }

    public function saveCustomUrl(Request $request){
        $existCustomUrl = Event::where('custom_url', '=', $request->CustomUrl)->first();
        if(!empty($existCustomUrl)){
            return $existCustomUrl;
        } else{
            // return 'mansi';
            $events = Event::findOrFail($request->eventId);
            $events->custom_url = $request->CustomUrl;
            $events->save();
            // return $events;
        }
    }

    public function eventPreview($id){
        $event = Event::findOrFail($id);
        $tickets = Ticket::where('event_id', $event->id)->orderBy('id', 'DESC')->get();
        return view('org/eventPreview', compact('event', 'tickets'));
    }

    public function updateIsFeaturedEvent(Request $request){
        $event = Event::findOrFail($request->eventId);
        if($request->isFeatureCheck == "0"){
            $event->is_featured = "1";
        } else {
            $event->is_featured = "0";
        }
        $event->save();
    }

}
