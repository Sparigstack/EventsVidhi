<?php

namespace App\Http\Controllers;

use App\Jobs\EncryptFile;
use App\Jobs\MoveFileToS3;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use SoareCostin\FileVault\Facades\FileVault;
use Artisan;
use App\Event;
use App\Video;
use App\Podcast;
use App\Country;
use App\EventCategory;
use App\Category;

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
        $events = Event::where('date_time', '>=', date('Y-m-d', strtotime(now())))->take(12)->orderBy('id', 'DESC')
            ->get();
        $eventsFeature = Event::where('date_time', '>=', date('Y-m-d', strtotime(now())))->take(4)->orderBy('id', 'DESC')
            ->get();
        $videos = Video::where('created_at', '<=', date('Y-m-d', strtotime(now())))->take(8)->orderBy('id', 'DESC')->get();
        $podcasts = Podcast::where('created_at', '<=', date('Y-m-d', strtotime(now())))->take(8)->orderBy('id', 'DESC')->get();
        $categories = Category::all();
        // $eventCategories = EventCategory::all();
        return view('home', compact('events', 'videos', 'podcasts', 'eventsFeature', 'categories'));
    }
}
