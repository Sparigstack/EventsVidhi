<?php

namespace App\Http\Controllers;

use App\Jobs\EncryptFile;
use App\Jobs\MoveFileToS3;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
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
        $events = Event::where('date_time', '>=', date('Y-m-d', strtotime(now())))->take(12)->orderBy('id', 'DESC')
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

    public function indexPage(Request $request)
    {
        $events = Event::where('date_time', '>=', date('Y-m-d', strtotime(now())))->where('is_live', '=', '1')->where('deleted_at', '=', NULL)->take(8)->orderBy('id', 'DESC')
            ->get();
        $eventsFeature = Event::where('date_time', '>=', date('Y-m-d', strtotime(now())))->where('is_featured', '=', '1')->where('is_live', '=', '1')->where('deleted_at', '=', NULL)->take(4)->orderBy('id', 'DESC')
            ->get();
        $videos = Video::take(8)->orderBy('id', 'DESC')->get();
        $podcasts = Podcast::take(8)->orderBy('id', 'DESC')->get();

        // $countries = Country::all();
        $countries = DB::table('events')->select('countries.name')->join('countries', 'events.country_id', '=', 'countries.id')->distinct('countries.name')->get();
        $categories = Category::all();
        $eventCategories = EventCategory::all();
        $eventFollowersList = ContentFollower::all();
        return view('home', compact('events', 'videos', 'podcasts', 'eventsFeature', 'categories', 'countries', 'eventCategories', 'eventFollowersList'));
    }

    public function allContent($tabId = 0,$categoryId,$pageCount)
    {
        // $categoryId = 0;
        $categoryQuery = "";
        $joinClause = " left ";

        if($categoryId != 0){
            if($tabId == 1){
                $categoryQuery .= " and ec.category_id = " . $categoryId;
                $joinClause = " right ";
            }

        }

        $page = '1';
        if (isset($pageCount)) {
            $page = $pageCount;
        }
        if ($page == "" || $page == "1") {
            $startingRecord = 0;
        } else {
            $startingRecord = $page * 32 - 32;
        }
        
        $allData = "select e.*, ec.*, v.*, p.* from events e join event_categories ec on e.id = ec.event_id" .$joinClause.  "join videos v on e.id = v.event_id" .$joinClause. "join podcasts p on e.id = p.event_id where e.is_live = 1 and e.deleted_at IS NULL and e.date_time >= CURDATE()" .$categoryQuery;

        // return $allData;

        $allDataResult = DB::select(DB::raw($allData));
        // var_dump(count($allDataResult)); return;

        $events = Event::where('date_time', '>=', date('Y-m-d', strtotime(now())))->where('is_live', '=', '1')->where('deleted_at', '=', NULL)->orderBy('id', 'DESC')
            ->get();
        $videos = Video::orderBy('id', 'DESC')->get();
        $podcasts = Podcast::orderBy('id', 'DESC')->get();
        $countries = DB::table('events')->select('countries.name')->join('countries', 'events.country_id', '=', 'countries.id')->distinct('countries.name')->get();
        $categories = Category::all();
        $eventCategories = EventCategory::all();
        $eventFollowersList = ContentFollower::all();
        return view('allContent', compact('events', 'videos', 'podcasts', 'categories', 'tabId', 'countries', 'eventCategories', 'eventFollowersList', 'allDataResult', 'pageCount'));
    }

    public function eventDetail($eventid)
    {
        // $events = FailedJob::all();
        // return view('events', compact('events'));
        $event = Event::find($eventid);
        $countryName = DB::table('events')->select('countries.name')->join('countries', 'events.country_id', '=', 'countries.id')->where('events.id', $eventid)->first();
        $eventsList = Event::where('date_time', '>=', date('Y-m-d', strtotime(now())))->where('is_live', '=', '1')->where('deleted_at', '=', NULL)->take(4)->orderBy('id', 'DESC')
            ->get();
        $eventFollowersList = ContentFollower::all();
        return view('eventDetail', compact('event', 'eventsList', 'countryName', 'eventFollowersList'));
    }

    public function videoDetail($videoid)
    {
        $video = Video::find($videoid);
        $eventCategories = "select c.name from videos v join event_categories e on v.event_id=e.event_id join categories c on e.category_id=c.id where v.id=". $videoid;
        $eventCategoriesResult = DB::select(DB::raw($eventCategories));
        $videosList = Video::take(4)->orderBy('id', 'DESC')->get();
        return view('videoDetail', compact('video', 'videosList', 'eventCategoriesResult'));
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
}
