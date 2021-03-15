<?php

namespace App\Http\Controllers;

use App\Jobs\EncryptFile;
use App\Jobs\MoveFileToS3;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use SoareCostin\FileVault\Facades\FileVault;
use Artisan;
use DB;
use App\Event;
use App\Video;
use App\Podcast;
use App\Country;
use App\EventCategory;
use App\Category;
use App\ContentFollower;
use App\User;
use App\Ticket;
use App\Plan;
use App\Speaker;
use App\ContentSuggestion;
use App\RegForm;
use App\RegFormInput;
use App\EventRegFormMapping;
use App\EventRegistration;
use App\EventRegAnswer;
use App\Comment;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        //$this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index(Request $request)
    {
        $events = Event::where('date_time', '>=', date('Y-m-d', strtotime(now())))->where('is_live', '1')->where('deleted_at', '=', NULL)->take(12)->orderBy('id', 'DESC')
            ->get();
        // $events = Event::where('date_time', '>=', date('Y-m-d', strtotime(now())))->where('country_id', '4')->take(12)->orderBy('id', 'DESC')
        //     ->get();
//        Artisan::call('config:clear');
//        Artisan::call('cache:clear');
//        $localFiles = Storage::files('files/' . auth()->user()->id);
//        $s3Files = Storage::disk('s3')->files('files/' . auth()->user()->id);
//        
        return view('home', compact('events'));
    }
    
    public function store(Request $request){
        if ($request->hasFile('userFile') && $request->file('userFile')->isValid()) {
            $filename = Storage::putFile('files/' . auth()->user()->id, $request->file('userFile'));

            // check if we have a valid file uploaded
            if ($filename) {
                EncryptFile::withChain([
                    new MoveFileToS3($filename),
                ])->dispatch($filename);
            }
        }

        return redirect()->route('home')->with('message', 'Upload complete');
    }
    
    public function create(){
        return view('homeUpload');
    }
    
    /**
     * Download a file
     *
     * @param  string  $filename
     * @return \Illuminate\Http\Response
     */
    public function downloadFile($filename)
    {
        // Basic validation to check if the file exists and is in the user directory
        if (!Storage::disk('s3')->has('files/' . auth()->user()->id . '/' . $filename)) {
            abort(404);
        }

        return response()->streamDownload(function () use ($filename) {
            FileVault::disk('s3')->streamDecrypt('files/' . auth()->user()->id . '/' . $filename);
        }, Str::replaceLast('.enc', '', $filename));
    }

    public function indexPage(Request $request,$tabId = NULL,$categoryId = NULL,$pageCount= NULL)
    {
        $categoryQueryVideo = " ";
        $categoryQueryPodcast = " ";
        $categoryQueryEvent = " ";
        $catSelectId = "";
        $allData = "";
        $dataCount = "";

        if($categoryId != 0 && $categoryId != NULL){
            $categoryQueryVideo .= " join event_categories ec on e.id = ec.event_id where ec.category_id = ". $categoryId . " ";
            $categoryQueryPodcast .= " join event_categories ec on e.id = ec.event_id where ec.category_id = ". $categoryId . " ";
            $categoryQueryEvent .= " join event_categories ec on e.id = ec.event_id ";
            $catSelectId .= " and ec.category_id = ". $categoryId . " ";
        }
        
        $eventQuery = "select e.id as eventId, u.id as userId, u.name as userName, u.profile_pic as userProfilePic, NULL as videoId, e.title as eventTitle, e.description as eventDesc, e.thumbnail as eventThumbnail, e.is_online as eventOnline, e.city as eventCity, e.state as eventState, e.is_paid as eventPaid, e.is_live as eventLive, e.date_time as eventDateTime, '' as videoUrl, '' as videoUrlType, NULL as podcastId,'' as eventVideoDesc, '' as videoTitle, '' as videoDesc, '' as podcastTitle   

            from events e join users u on e.user_id = u.id "
            .$categoryQueryEvent.
            " where e.is_live = 1 and e.deleted_at IS NULL and e.date_time >= CURDATE() "
            .$catSelectId."";

        $videoQuery = "select v.event_id as eventId, u.id as userId, u.name as userName , u.profile_pic as userProfilePic,v.id as videoId, '' as eventTitle, '' as eventDesc, '' as eventThumbnail, NULL as eventOnline, '' as eventCity, '' as eventState, NULL as eventPaid, '' as eventLive, NULL as eventDateTime, v.url as videoUrl, v.url_type as videoUrlType, NULL as podcastId,e.description as eventVideoDesc, v.title as videoTitle, v.description as videoDesc, '' as podcastTitle    

            from videos v join users u on v.user_id = u.id
            left join events e on v.event_id = e.id"
            .$categoryQueryVideo."";

        $podcastQuery = "select p.event_id as eventId, u.id as userId, u.name as userName , u.profile_pic as userProfilePic,NULL as videoId, '' as eventTitle, '' as eventDesc, '' as eventThumbnail, NULL as eventOnline, '' as eventCity, '' as eventState, NULL as eventPaid, '' as eventLive, NULL as eventDateTime, p.url as videoUrl, p.url_type as videoUrlType, p.id as podcastId,e.description as eventVideoDesc, '' as videoTitle, '' as videoDesc, p.title as podcastTitle  

            from podcasts p join users u on p.user_id = u.id
            left join events e on p.event_id = e.id"
            .$categoryQueryPodcast."";

        // $page = '1';
        // if (isset($pageCount) && $pageCount!= NULL) {
        //     $page = $pageCount;
        // }
        // if ($page == "" || $page == "1") {
        //     $startingRecord = 0;
        // } else {
        //     $startingRecord = $page * 4 - 4;
        // }

        if($tabId == 1 || $tabId == NULL){
            $allData .= "SELECT * FROM ("
                .$eventQuery." UNION ".$videoQuery." UNION ".$podcastQuery.
                ") allDataQuery LIMIT 11";
            $dataCount .= "SELECT * FROM ("
                .$eventQuery." UNION ".$videoQuery." UNION ".$podcastQuery.
                ") allDataQuery";
        } else if($tabId == 2){
            $allData .= "SELECT * FROM ("
                .$eventQuery.
                ") allDataQuery LIMIT 11";
            $dataCount .= "SELECT * FROM ("
                .$eventQuery.
                ") allDataQuery";
        } else if($tabId == 3){
            $allData .= "SELECT * FROM ("
                .$videoQuery.
                ") allDataQuery LIMIT 11";
            $dataCount .= "SELECT * FROM ("
                .$videoQuery.
                ") allDataQuery";
        } else {
            $allData .= "SELECT * FROM ("
                .$podcastQuery.
                ") allDataQuery LIMIT 11";
            $dataCount .= "SELECT * FROM ("
                .$podcastQuery.
                ") allDataQuery";
        }

        // return $allData;

        $allDataResult = DB::select(DB::raw($allData));

        $dataCountResult = DB::select(DB::raw($dataCount));

        $allDataCount = count($dataCountResult);
        // var_dump($allDataResult); return;



        // $events = Event::where('date_time', '>=', date('Y-m-d', strtotime(now())))->where('is_live', '=', '1')->where('deleted_at', '=', NULL)->take(8)->orderBy('id', 'DESC')
        //     ->get();
        // $videos = Video::take(8)->orderBy('id', 'DESC')->get();
        // $podcasts = Podcast::take(8)->orderBy('id', 'DESC')->get();

        $eventsFeature = Event::where('date_time', '>=', date('Y-m-d', strtotime(now())))->where('is_featured', '=', '1')->where('is_live', '=', '1')->where('deleted_at', '=', NULL)->take(4)->orderBy('id', 'DESC')
            ->get();
        $countries = DB::table('events')->select('countries.name')->join('countries', 'events.country_id', '=', 'countries.id')->distinct('countries.name')->get();
        $categories = Category::all();
        $eventCategories = EventCategory::all();
        $eventFollowersList = ContentFollower::all();
        return view('home', compact('eventsFeature', 'categories', 'countries', 'eventCategories', 'eventFollowersList', 'tabId', 'allDataResult', 'pageCount', 'allDataCount', 'categoryId'));
    }

    public function allContent($tabId = 0,$categoryId,$searchName,$pageCount)
    {
        $categoryQueryVideo = " ";
        $categoryQueryPodcast = " ";
        $categoryQueryEvent = " ";
        $catSelectId = "";
        $allData = "";
        $dataCount = "";
        $searchNameEventQuery = " ";
        $searchNameVideoQuery = " ";
        $searchNamePodcastQuery = " ";

        if($categoryId != 0){
            $categoryQueryVideo .= " join event_categories ec on e.id = ec.event_id where ec.category_id = ". $categoryId . " ";
            $categoryQueryPodcast .= " join event_categories ec on e.id = ec.event_id where ec.category_id = ". $categoryId . " ";
            $categoryQueryEvent .= " join event_categories ec on e.id = ec.event_id ";
            $catSelectId .= " and ec.category_id = ". $categoryId . " ";
        }

        if($categoryId == 0 && $searchName != '0'){
            $searchNameEventQuery .= " and e.title LIKE '%" .$searchName. "%' ";
            $searchNameVideoQuery .= " where v.title LIKE '%" .$searchName."%' ";
            $searchNamePodcastQuery .= " where p.title LIKE '%" .$searchName."%' ";
        }
        
        $eventQuery = "select e.id as eventId, u.id as userId, u.name as userName, u.profile_pic as userProfilePic, NULL as videoId, e.title as eventTitle, e.description as eventDesc, e.thumbnail as eventThumbnail, e.is_online as eventOnline, e.city as eventCity, e.state as eventState, e.is_paid as eventPaid, e.is_live as eventLive, e.date_time as eventDateTime, '' as videoUrl, '' as videoUrlType, NULL as podcastId,'' as eventVideoDesc, '' as videoTitle, '' as videoDesc, '' as podcastTitle   

            from events e join users u on e.user_id = u.id "
            .$categoryQueryEvent.
            " where e.is_live = 1 and e.deleted_at IS NULL and e.date_time >= CURDATE() "
            .$catSelectId." ". $searchNameEventQuery."";

        $videoQuery = "select v.event_id as eventId, u.id as userId, u.name as userName , u.profile_pic as userProfilePic,v.id as videoId, '' as eventTitle, '' as eventDesc, '' as eventThumbnail, NULL as eventOnline, '' as eventCity, '' as eventState, NULL as eventPaid, '' as eventLive, NULL as eventDateTime, v.url as videoUrl, v.url_type as videoUrlType, NULL as podcastId,e.description as eventVideoDesc, v.title as videoTitle, v.description as videoDesc, '' as podcastTitle    

            from videos v join users u on v.user_id = u.id
            left join events e on v.event_id = e.id"
            .$categoryQueryVideo." ". $searchNameVideoQuery."";

        $podcastQuery = "select p.event_id as eventId, u.id as userId, u.name as userName , u.profile_pic as userProfilePic,NULL as videoId, '' as eventTitle, '' as eventDesc, '' as eventThumbnail, NULL as eventOnline, '' as eventCity, '' as eventState, NULL as eventPaid, '' as eventLive, NULL as eventDateTime, p.url as videoUrl, p.url_type as videoUrlType, p.id as podcastId,e.description as eventVideoDesc, '' as videoTitle, '' as videoDesc, p.title as podcastTitle  

            from podcasts p join users u on p.user_id = u.id
            left join events e on p.event_id = e.id"
            .$categoryQueryPodcast." ". $searchNamePodcastQuery."";

        $page = '1';
        if (isset($pageCount)) {
            $page = $pageCount;
        }
        if ($page == "" || $page == "1") {
            $startingRecord = 0;
        } else {
            $startingRecord = $page * 31 - 31;
        }

        if($tabId == 1){
            $allData .= "SELECT * FROM ("
                .$eventQuery." UNION ".$videoQuery." UNION ".$podcastQuery.
                ") allDataQuery LIMIT " . $startingRecord . ",31";
            $dataCount .= "SELECT * FROM ("
                .$eventQuery." UNION ".$videoQuery." UNION ".$podcastQuery.
                ") allDataQuery";
        } else if($tabId == 2){
            $allData .= "SELECT * FROM ("
                .$eventQuery.
                ") allDataQuery LIMIT " . $startingRecord . ",31";
            $dataCount .= "SELECT * FROM ("
                .$eventQuery.
                ") allDataQuery";
        } else if($tabId == 3){
            $allData .= "SELECT * FROM ("
                .$videoQuery.
                ") allDataQuery LIMIT " . $startingRecord . ",31";
            $dataCount .= "SELECT * FROM ("
                .$videoQuery.
                ") allDataQuery";
        } else {
            $allData .= "SELECT * FROM ("
                .$podcastQuery.
                ") allDataQuery LIMIT " . $startingRecord . ",31";
            $dataCount .= "SELECT * FROM ("
                .$podcastQuery.
                ") allDataQuery";
        }

        // return $allData;

        $allDataResult = DB::select(DB::raw($allData));

        $dataCountResult = DB::select(DB::raw($dataCount));

        $allDataCount = count($dataCountResult);
        // var_dump($allDataResult); return;

        // $events = Event::where('date_time', '>=', date('Y-m-d', strtotime(now())))->where('is_live', '=', '1')->where('deleted_at', '=', NULL)->orderBy('id', 'DESC')
        //     ->get();
        // $videos = Video::orderBy('id', 'DESC')->get();
        // $podcasts = Podcast::orderBy('id', 'DESC')->get();
        $countries = DB::table('events')->select('countries.name')->join('countries', 'events.country_id', '=', 'countries.id')->distinct('countries.name')->get();
        $categories = Category::all();
        // $eventCategories = EventCategory::all();
        $eventFollowersList = ContentFollower::all();
        return view('allContent', compact('categories', 'tabId', 'countries', 'eventFollowersList', 'allDataResult', 'pageCount', 'allDataCount', 'categoryId'));
    }

    public function eventDetail($eventid)
    {
        $event = Event::find($eventid);
        $countryName = DB::table('events')->select('countries.name')->join('countries', 'events.country_id', '=', 'countries.id')->where('events.id', $eventid)->first();
        $eventsList = Event::where('date_time', '>=', date('Y-m-d', strtotime(now())))->where('is_live', '=', '1')->where('deleted_at', '=', NULL)->take(4)->orderBy('id', 'DESC')
            ->get();
        $eventFollowersList = ContentFollower::all();
        $videosList = Video::where('event_id', $eventid)->get();
        $podcastsList = Podcast::where('event_id', $eventid)->get();
        $ticketsList = Ticket::where('event_id',$eventid)->get();
        $orgFollowerCount = "SELECT c.content_id FROM content_followers c INNER JOIN events e ON c.content_id = e.user_id WHERE c.discriminator = 'o' AND e.id =". $eventid;
        $orgFollowerCount = DB::select(DB::raw($orgFollowerCount));
        $orgFollowerCountResult = count($orgFollowerCount);
        $speakersList = Speaker::where('event_id',$eventid)->get();
        $suggestionsList = ContentSuggestion::all();

        $suggestionsListCount1 = "SELECT cs.content_id FROM content_suggestions cs INNER JOIN events e ON cs.content_id = e.id WHERE cs.discriminator = 'e' AND e.id =". $eventid ." AND cs.suggestion_id = 1";
        $suggestionsListCount1 = DB::select(DB::raw($suggestionsListCount1));
        $suggestionsListCountResult1 = count($suggestionsListCount1);

        $suggestionsListCount2 = "SELECT cs.content_id FROM content_suggestions cs INNER JOIN events e ON cs.content_id = e.id WHERE cs.discriminator = 'e' AND e.id =". $eventid ." AND cs.suggestion_id = 2";
        $suggestionsListCount2 = DB::select(DB::raw($suggestionsListCount2));
        $suggestionsListCountResult2 = count($suggestionsListCount2);

        $suggestionsListCount3 = "SELECT cs.content_id FROM content_suggestions cs INNER JOIN events e ON cs.content_id = e.id WHERE cs.discriminator = 'e' AND e.id =". $eventid ." AND cs.suggestion_id = 3";
        $suggestionsListCount3 = DB::select(DB::raw($suggestionsListCount3));
        $suggestionsListCountResult3 = count($suggestionsListCount3);

        $regQueFormInputs = "SELECT rfi.* FROM event_reg_form_mappings erfm JOIN  reg_forminputs rfi ON erfm.reg_form_id = rfi.reg_form_id WHERE erfm.event_id =" . $eventid . " ORDER BY rfi.id ASC"; 
        $regQueFormInputResults = DB::select(DB::raw($regQueFormInputs));

        $commentDetail = Comment::where("event_id" , $eventid)->orderBy("id" , "DESC")->get();

        if(Auth::check()){
            $user = Auth::id();
        } else {
            $user = 0;
        }
        $getRegisterOrPurchaseEvent = "SELECT e.id FROM events e LEFT JOIN event_registrations er ON e.id = er.event_id LEFT JOIN payment_info pi ON e.id = pi.event_id WHERE (er.user_id=" .$user." AND er.event_id=" .$eventid. ") OR (pi.user_id=" .$user. " AND pi.event_id=" .$eventid. ")";
        $getRegisterOrPurchaseEventResult = DB::select(DB::raw($getRegisterOrPurchaseEvent));

        $getRegisterEvent = "SELECT e.id FROM events e LEFT JOIN event_registrations er ON e.id = er.event_id WHERE er.user_id=" .$user." AND er.event_id=" .$eventid. "";
        $getRegisterEventResult = DB::select(DB::raw($getRegisterEvent));

        return view('eventDetail', compact('event', 'eventsList', 'countryName', 'eventFollowersList', 'videosList', 'podcastsList', 'ticketsList', 'orgFollowerCountResult', 'speakersList', 'suggestionsList', 'suggestionsListCountResult1', 'suggestionsListCountResult2', 'suggestionsListCountResult3' , 'regQueFormInputResults', 'commentDetail', 'getRegisterOrPurchaseEventResult', 'getRegisterEventResult'));
    }

    public function videoDetail($videoid)
    {
        $video = Video::find($videoid);
        $eventCategories = "select c.name from videos v join event_categories e on v.event_id=e.event_id join categories c on e.category_id=c.id where v.id=". $videoid;
        $eventCategoriesResult = DB::select(DB::raw($eventCategories));
        $videosList = Video::take(4)->orderBy('id', 'DESC')->get();
        $eventFollowersList = ContentFollower::all();
        $orgFollowerCount = "SELECT c.content_id FROM content_followers c INNER JOIN videos v ON c.content_id = v.user_id WHERE c.discriminator = 'o' AND v.id =". $videoid;
        $orgFollowerCount = DB::select(DB::raw($orgFollowerCount));
        $orgFollowerCountResult = count($orgFollowerCount);

        $suggestionsList = ContentSuggestion::all();

        $suggestionsListCount1 = "SELECT cs.content_id FROM content_suggestions cs INNER JOIN videos v ON cs.content_id = v.id WHERE cs.discriminator = 'v' AND v.id =". $videoid ." AND cs.suggestion_id = 1";
        $suggestionsListCount1 = DB::select(DB::raw($suggestionsListCount1));
        $suggestionsListCountResult1 = count($suggestionsListCount1);

        $suggestionsListCount2 = "SELECT cs.content_id FROM content_suggestions cs INNER JOIN videos v ON cs.content_id = v.id WHERE cs.discriminator = 'v' AND v.id =". $videoid ." AND cs.suggestion_id = 2";
        $suggestionsListCount2 = DB::select(DB::raw($suggestionsListCount2));
        $suggestionsListCountResult2 = count($suggestionsListCount2);

        $suggestionsListCount3 = "SELECT cs.content_id FROM content_suggestions cs INNER JOIN videos v ON cs.content_id = v.id WHERE cs.discriminator = 'v' AND v.id =". $videoid ." AND cs.suggestion_id = 3";
        $suggestionsListCount3 = DB::select(DB::raw($suggestionsListCount3));
        $suggestionsListCountResult3 = count($suggestionsListCount3);

        // if(Auth::check()){
        //     $user = Auth::id();
        // } else {
        //     $user = 0;
        // }

        // if($getEventId->event_id != ""){
        //     $eventId = $getEventId->event_id;

        //     $getRegisterOrPurchaseEvent = "SELECT e.id FROM videos v LEFT JOIN events e ON v.event_id = e.id LEFT JOIN event_registrations er ON e.id = er.event_id LEFT JOIN payment_info pi ON e.id = pi.event_id WHERE (er.user_id=" .$user." AND er.event_id=" .$eventId. ") OR (pi.user_id=" .$user. " AND pi.event_id=" .$eventId. ") AND v.id = " .$videoid;
        //     $getRegisterOrPurchaseEventResult = DB::select(DB::raw($getRegisterOrPurchaseEvent));
        // } else {
        //     $getRegisterOrPurchaseEvent = "SELECT id FROM videos WHERE id=".$videoid;
        //     $getRegisterOrPurchaseEventResult = DB::select(DB::raw($getRegisterOrPurchaseEvent));
        // }

        $getEventId = Video::where('id', $videoid)->first();
        $joinClause = "";
        $whereClause = "";

        if(Auth::check() == false && $getEventId->event_id != ""){
            $joinClause = " JOIN events e ON v.event_id = e.id JOIN event_registrations er ON e.id = er.event_id JOIN payment_info pi ON e.id = pi.event_id ";
            $whereClause = " AND (er.event_id=".$getEventId->event_id." OR pi.event_id=".$getEventId->event_id.")";
        }
        if(Auth::check() && $getEventId->event_id != ""){
            $joinClause = " LEFT JOIN events e ON v.event_id = e.id LEFT JOIN event_registrations er ON e.id = er.event_id LEFT JOIN payment_info pi ON e.id = pi.event_id ";
            $whereClause = " AND (er.event_id=".$getEventId->event_id." AND er.user_id =" .Auth::id().") OR (pi.event_id=".$getEventId->event_id." AND pi.user_id =" .Auth::id().")";
        }
        $getRegisterOrPurchaseEvent = "SELECT v.event_id FROM videos v" .$joinClause." WHERE v.id =" .$videoid. $whereClause ."";
        $getRegisterOrPurchaseEventResult = DB::select(DB::raw($getRegisterOrPurchaseEvent));

        return view('videoDetail', compact('video', 'videosList', 'eventCategoriesResult', 'eventFollowersList', 'orgFollowerCountResult', 'suggestionsList', 'suggestionsListCountResult1', 'suggestionsListCountResult2', 'suggestionsListCountResult3', 'getRegisterOrPurchaseEventResult'));
    }

    public function podcastDetail($podcastid)
    {
        $podcast = Podcast::find($podcastid);
        $eventCategories = "select c.name from podcasts p join event_categories e on p.event_id=e.event_id join categories c on e.category_id=c.id where p.id=". $podcastid;
        $eventCategoriesResult = DB::select(DB::raw($eventCategories));
        $podcastsList = Podcast::take(4)->orderBy('id', 'DESC')->get();
        $eventFollowersList = ContentFollower::all();
        $orgFollowerCount = "SELECT c.content_id FROM content_followers c INNER JOIN podcasts p ON c.content_id = p.user_id WHERE c.discriminator = 'o' AND p.id =". $podcastid;
        $orgFollowerCount = DB::select(DB::raw($orgFollowerCount));
        $orgFollowerCountResult = count($orgFollowerCount);

        $suggestionsList = ContentSuggestion::all();

        $suggestionsListCount1 = "SELECT cs.content_id FROM content_suggestions cs INNER JOIN podcasts p ON cs.content_id = p.id WHERE cs.discriminator = 'p' AND p.id =". $podcastid ." AND cs.suggestion_id = 1";
        $suggestionsListCount1 = DB::select(DB::raw($suggestionsListCount1));
        $suggestionsListCountResult1 = count($suggestionsListCount1);

        $suggestionsListCount2 = "SELECT cs.content_id FROM content_suggestions cs INNER JOIN podcasts p ON cs.content_id = p.id WHERE cs.discriminator = 'p' AND p.id =". $podcastid ." AND cs.suggestion_id = 2";
        $suggestionsListCount2 = DB::select(DB::raw($suggestionsListCount2));
        $suggestionsListCountResult2 = count($suggestionsListCount2);

        $suggestionsListCount3 = "SELECT cs.content_id FROM content_suggestions cs INNER JOIN podcasts p ON cs.content_id = p.id WHERE cs.discriminator = 'p' AND p.id =". $podcastid ." AND cs.suggestion_id = 3";
        $suggestionsListCount3 = DB::select(DB::raw($suggestionsListCount3));
        $suggestionsListCountResult3 = count($suggestionsListCount3);

        // if(Auth::check()){
        //     $user = Auth::id();
        // } else {
        //     $user = 0;
        // }
        // if($getEventId->event_id != ""){
        //     $eventId = $getEventId->event_id;

        //     $getRegisterOrPurchaseEvent = "SELECT e.id FROM podcasts p JOIN events e ON p.event_id = e.id LEFT JOIN event_registrations er ON e.id = er.event_id LEFT JOIN payment_info pi ON e.id = pi.event_id WHERE (er.user_id=" .$user." AND er.event_id=" .$getEventId->event_id. ") OR (pi.user_id=" .$user. " AND pi.event_id=" .$getEventId->event_id. ")";
        // $getRegisterOrPurchaseEventResult = DB::select(DB::raw($getRegisterOrPurchaseEvent));
        // } else {
        //     $getRegisterOrPurchaseEvent = "SELECT id FROM podcasts WHERE id=".$podcastid;
        //     $getRegisterOrPurchaseEventResult = DB::select(DB::raw($getRegisterOrPurchaseEvent));
        // }

        $getEventId = Podcast::where('id', $podcastid)->first();
        $joinClause = "";
        $whereClause = "";

        if(Auth::check() == false && $getEventId->event_id != ""){
            $joinClause = " JOIN events e ON p.event_id = e.id JOIN event_registrations er ON e.id = er.event_id JOIN payment_info pi ON e.id = pi.event_id ";
            $whereClause = " AND (er.event_id=".$getEventId->event_id." OR pi.event_id=".$getEventId->event_id.")";
        }
        if(Auth::check() && $getEventId->event_id != ""){
            $joinClause = " LEFT JOIN events e ON p.event_id = e.id LEFT JOIN event_registrations er ON e.id = er.event_id LEFT JOIN payment_info pi ON e.id = pi.event_id ";
            $whereClause = " AND (er.event_id=".$getEventId->event_id." AND er.user_id =" .Auth::id().") OR (pi.event_id=".$getEventId->event_id." AND pi.user_id =" .Auth::id().")";
        }
        $getRegisterOrPurchaseEvent = "SELECT p.event_id FROM podcasts p" .$joinClause." WHERE p.id =" .$podcastid. $whereClause ."";
        $getRegisterOrPurchaseEventResult = DB::select(DB::raw($getRegisterOrPurchaseEvent));

        return view('podcastDetail', compact('podcast', 'podcastsList', 'eventCategoriesResult', 'eventFollowersList', 'orgFollowerCountResult', 'suggestionsList', 'suggestionsListCountResult1', 'suggestionsListCountResult2', 'suggestionsListCountResult3', 'getRegisterOrPurchaseEventResult'));
    }

    public function organizerDetail($orgid)
    {
        $organizer = User::find($orgid);
        $eventsList = Event::where('date_time', '>=', date('Y-m-d', strtotime(now())))->where('is_live', '=', '1')->where('deleted_at', '=', NULL)->take(4)->orderBy('id', 'DESC')
            ->get();
        $orgFutureEventsList = Event::where('date_time', '>=', date('Y-m-d', strtotime(now())))->where('is_live', '=', '1')->where('deleted_at', '=', NULL)->where('user_id', $orgid)->orderBy('id', 'DESC')
            ->get();
        $orgPastEventsList = Event::where('date_time', '<=', date('Y-m-d', strtotime(now())))->where('is_live', '=', '1')->where('deleted_at', '=', NULL)->where('user_id', $orgid)->orderBy('id', 'DESC')
            ->get();
        $videosList = Video::where('user_id', $orgid)->get();
        $podcastsList = Podcast::where('user_id', $orgid)->get();
        $eventFollowersList = ContentFollower::all();
        $orgFollowerCount = ContentFollower::where('content_id', $orgid)->where('discriminator', 'o')->get();
        
        return view('organizerDetail', compact('organizer', 'eventsList', 'orgPastEventsList', 'eventFollowersList', 'orgFutureEventsList', 'videosList', 'podcastsList', 'orgFollowerCount'));
    }

    public function saveEventFollower(Request $request){
        // if($request->userIDFollow == ''){
        if($request->userIDFollow != ''){
            if($request->fillHeartValue == '1'){
                $eventFollowerDelete = ContentFollower::where('user_id', $request->userIDFollow)->where('content_id', $request->eventId)->where('discriminator', $request->discriminator)->delete();
            } else {
                $contentFollower = new ContentFollower;
                $contentFollower->content_id = $request->eventId;
                $contentFollower->discriminator = $request->discriminator;
                $contentFollower->user_id = $request->userIDFollow;
                $contentFollower->save();
            }
        }
    }
    
    public function saveOrgFollower(Request $request){
        if($request->userIDFollow != ''){
            if($request->followOrgText == 'Following'){
                $orgFollowerDelete = ContentFollower::where('user_id', $request->userIDFollow)->where('content_id', $request->orgId)->where('discriminator', $request->discriminator)->delete();
            } else {
                $contentFollower = new ContentFollower;
                $contentFollower->content_id = $request->orgId;
                $contentFollower->discriminator = $request->discriminator;
                $contentFollower->user_id = $request->userIDFollow;
                $contentFollower->save();
            }
        }
    }

    public function saveUserSuggestion(Request $request){
        if($request->userIDFollow != ''){
            if($request->fillBoxValue == '1' && $request->smileyCardColorLength == '1'){
                $contentSuggestionDelete = ContentSuggestion::where('user_id', $request->userIDFollow)->where('content_id', $request->contentId)->where('suggestion_id', $request->dataId)->where('discriminator', $request->discriminator)->delete();
            } else if ($request->fillBoxValue == '' && $request->smileyCardColorLength == '1'){
                return 'false';
            } 
            else {
                $contentSuggestion = new ContentSuggestion;
                $contentSuggestion->content_id = $request->contentId;
                $contentSuggestion->discriminator = $request->discriminator;
                $contentSuggestion->user_id = $request->userIDFollow;
                $contentSuggestion->suggestion_id = $request->dataId;
                $contentSuggestion->save();
            }
        }
    }

    public function pricingPlan(){
        $plans = Plan::orderBy('id', 'ASC')->get();
        return view('pricingPlans', compact('plans'));
    }

    public function saveUserAnswers(Request $request){
      //EventRegistration Entry
      //if($request->loginuserID != ''){ 
      // $eventRegDelID = EventRegistration::where('event_id', $request->eventID)->where('user_id', $request->loginuserID)->first();

      // if(isset($eventRegDelID)){
      //   EventRegAnswer::where("event_reg_id", $eventRegDelID->id)->delete();
      //   EventRegistration::where('event_id', $request->eventID)->where('user_id', $request->loginuserID)->delete();
      // } 
      
      $eventReg = new EventRegistration;
      $eventReg->event_id = $request->eventID;
      $eventReg->reg_form_id = $request->regFormID;
      $eventReg->user_id = $request->loginuserID;
      $eventReg->save();

      //EventRegAnswers Entry
      $queAnsInputArray = $request->answerValues;
      for ($i = 0; $i < count($queAnsInputArray); $i++) {
          $queAnsInput = new EventRegAnswer;
          $queAnsInput->event_reg_id = $eventReg->id;
          $queAnsInput->reg_forminput_id = $queAnsInputArray[$i]['regFormInputID'];
          $queAnsInput->answer = $queAnsInputArray[$i]['answer_value'];
          $queAnsInput->save();
      }
    //}
    }

    public function saveUserComments(Request $request){
        $saveComment = new Comment;
        $saveComment->event_id = $request->eventID;
        $saveComment->user_id = $request->loginuserID;
        $saveComment->comment = $request->commentAnswerDiv;
        $saveComment->save();
    }
}
