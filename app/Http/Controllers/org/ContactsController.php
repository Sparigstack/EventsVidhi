<?php

namespace App\Http\Controllers\org;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Contact;
use App\ContactTag;
use App\Tag;
use Exception;
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
    public function index(Request $request)
    {
        $user = Auth::user();
        $contacts = $user->contacts;
        $tagList = Tag::where('user_id', $user->id)->get();

        if(isset($request->tagSelection)){
            $tagSelection = $request->tagSelection;
            $tagSelection = implode(',', $tagSelection);
            // $contacts = ContactTag::where('tag_id', explode(',', $tagSelection))->get();
        }
        return view('org/contacts', compact('contacts', 'tagList'));
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
}
