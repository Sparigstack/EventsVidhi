<?php

namespace App\Http\Controllers\org;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Contact;
use App\ContactTag;
use App\Tag;
use Exception;
use DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class ContactsController extends Controller
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
    public function index($tage_ids=0)
    {
        $user = Auth::user();
        $tagList = Tag::where('user_id', $user->id)->get();
        
        if($tage_ids == 0){
            $contacts = $user->contacts;
        } 
        else{
            $tab_ids = $tage_ids;
            // return array($tab_ids);
            // $contactsQuery = "select c.*, t.* from contact_tag ct join contacts c on c.id=ct.contact_id join tags t on t.id=ct.tag_id where ct.tag_id IN(" . $tab_ids .  ")";
            $contacts = $user->contacts;
            foreach($contacts as $contacts1){
                $contactTags = $contacts1->tags()->whereIn('contact_tag.tag_id', array($tab_ids))->get();
                // echo $contactTags; return;
            }
            // return $contactTags;
            
            // $contactsQuery = DB::table("contact_tag as ct")
            //     ->join('contacts as c', 'c.id', '=', 'ct.contact_id')
            //     ->join('tags as t', 't.id', '=', 'ct.tag_id')
            //     ->select('c.*', 't.*')
            //     ->whereIn('ct.tag_id', array($tab_ids))
            //     ->with('tags')
            //     ->get();
             // $contactsQuery = Contact::with(['tags' => function ($query) {
             //        $query->whereIn('id', $tab_ids);
             //    }])->get();
            // $contacts = DB::select(DB::raw($contactsQuery));
            // $ids = "";
            // foreach($contacts as $contact){
            //     $ids .= $contact->id . ',';
            // }
            // $contacts = $user->contacts()->tags()->whereIn('id', array($tab_ids))->get();
            // $contacts = $user->contacts()->tags()->whereIn('id', array($tab_ids))->get();
            // var_dump($contacts);return;
        }
        return view('org/contacts', compact('contacts', 'tagList', 'tage_ids'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $user = Auth::user();
        $contacts = Contact::all();
        // $tags = Tag::all();
        $tagsData = Tag::where('user_id', $user->id)->get();
        return view('org/createContact', compact('contacts', 'tagsData'));
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
            'firstName' => 'required',
            'lastName' => 'required',
            'emailAddress' => 'required',
        ]);

        if ($validator->fails()) {
            return redirect('org/contacts/new')
                ->withErrors($validator)
                ->withInput();
        }

        $user = Auth::user();

        $contact = new Contact;
        $contact->first_name = $request->firstName;
        $contact->last_name = $request->lastName;
        $contact->email = $request->emailAddress;
        $contact->contact_number = $request->ContactNumber;
        $contact->user_id = $user->id;
        $contact->save();


        try {
            $string = $request->HiddenCategoyID;
            $tagIDS = preg_split("/\,/", $string);
            foreach ($tagIDS as $tagID) {
                $ContactTag = new ContactTag();
                $ContactTag->contact_id = $contact->id;
                $ContactTag->tag_id = number_format($tagID);
                $ContactTag->save();
            }
        } catch (Exception $e) {
        }


        return redirect('org/contacts');
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
        $user = Auth::user();
        $contact = Contact::findOrFail($id);
        $contact_tag = ContactTag::where('contact_id', $contact->id)->get();
        $tagsData = Tag::where('user_id', $user->id)->get();

        return view('org/createContact', compact('contact', 'contact_tag', 'tagsData'));
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
        $validator = Validator::make($request->all(), [
            'firstName' => 'required',
            'lastName' => 'required',
            'emailAddress' => 'required',
        ]);

        if ($validator->fails()) {
            return redirect('org/contacts/new')
                ->withErrors($validator)
                ->withInput();
        }

        $user = Auth::user();

        $contact = Contact::findOrFail($id);
        $contact->first_name = $request->firstName;
        $contact->last_name = $request->lastName;
        $contact->email = $request->emailAddress;
        $contact->contact_number = $request->ContactNumber;
        $contact->user_id = $user->id;
        $contact->save();

        // try {
            $string = $request->HiddenCategoyID;
            $tagIDS = preg_split("/\,/", $string);
            ContactTag::where('contact_id', $contact->id)->delete();
            foreach ($tagIDS as $tagID) {
                if($tagID != ''){
                    $ContactTag = new ContactTag;
                    $ContactTag->contact_id = $contact->id;
                    $ContactTag->tag_id = (int)$tagID;
                    $ContactTag->save();
                }
            }
        // } catch (Exception $e) {
        // }
        return redirect('org/contacts');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $contact_tags = ContactTag::where('contact_id', $request->contactDeleteId)->delete();
        $contact = Contact::find($request->contactDeleteId)->delete();
    }
    public function approve($id)
    {
        $contact = Contact::findOrFail($id);
        $contact->is_approved=1;
        $contact->save();
        return "success";
    }
}
