<?php

namespace App\Http\Controllers\org;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Contact;
use App\ContactCustomField;
use App\ContactTag;
use App\CustomField;
use App\Tag;
use Exception;
use DB;
use DateTime;
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
    public function index($tag_ids = '0') {

        $user = Auth::user();
        //$tagList = Tag::where('user_id', $user->id)->get();
        $tagList = $user->tags;

        if ($tag_ids == '0') {
            $contacts = $user->contacts;
        } else {
            //$tag_ids='23,30';
            $tag_arr = explode(',', $tag_ids);

            $contact_ids = DB::table('contacts')->select('contacts.id')->distinct()
                    ->join('contact_tag', 'contacts.id', '=', 'contact_tag.contact_id')
                    ->join('tags', 'contact_tag.tag_id', '=', 'tags.id')
                    ->where('contacts.user_id', $user->id)
                    ->whereIn('tags.id', $tag_arr)
                    ->get()->toArray();
            $ids = [];
            foreach($contact_ids as $cid){
                $ids[] = $cid->id;
            }
            $contacts = Contact::whereIn('id', $ids)->get(); 
        }
        return view('org/contacts', compact('contacts', 'tagList', 'tag_ids'));
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
        $customFields = CustomField::where('user_id', $user->id)->get();
        return view('org/createContact', compact('contacts', 'tagsData', 'customFields'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // $value= $request->RehersalDate;
        // $DateTime = $value;
       
        // $DateValue = new DateTime($DateTime);
        // return $DateValue;
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
        if ($user->auto_approve_follower == 1) {
            $contact->is_approved = 1;
        }
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
        $customFields = CustomField::where('user_id', $user->id)->get();
        foreach ($customFields as $customField) {
            $NewcustomField = new ContactCustomField;
            $NewcustomField->contact_id = $contact->id;
            $NewcustomField->customfield_id = $customField->id;
            $name = $customField->name;
            $ConvertedName = str_replace(' ', '', $customField->name);
            $value = $request->$ConvertedName;
            if ($customField->type == 1) {
                $NewcustomField->string_value = $value;
            } elseif ($customField->type == 2) {
                $NewcustomField->int_value = $value;
            } else {
                if(!empty($value) || $value!="" || $value!=null){
                    $DateTime = $value;
                    $DateValue = new DateTime($DateTime);
                    $NewcustomField->date_value = $DateValue;
                }
            }
            $NewcustomField->save();
        }

        return redirect('org/my_contacts');
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
        $customFields = CustomField::where('user_id', $user->id)->get();
        $ContactCustomFields = ContactCustomField::where('contact_id', $contact->id)->get();

        return view('org/createContact', compact('contact', 'contact_tag', 'tagsData', 'customFields', 'ContactCustomFields'));
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
            if ($tagID != '') {
                $ContactTag = new ContactTag;
                $ContactTag->contact_id = $contact->id;
                $ContactTag->tag_id = (int) $tagID;
                $ContactTag->save();
            }
        }

        $customFields = CustomField::where('user_id', $user->id)->get();
        foreach ($customFields as $customField) {
            $NewcustomField = ContactCustomField::where('contact_id', $id)->where('customfield_id', $customField->id)->first();
            if ($NewcustomField==null) {
                $NewcustomField = new ContactCustomField;
                $NewcustomField->contact_id = $contact->id;
                $NewcustomField->customfield_id = $customField->id;
            }

            $name = $customField->name;
            $ConvertedName = str_replace(' ', '', $customField->name);
            $value = $request->$ConvertedName;
            if ($customField->type == 1) {
                $NewcustomField->string_value = $value;
            } elseif ($customField->type == 2) {
                $NewcustomField->int_value = $value;
            } else {
                $DateTime = $value;
                $DateValue = new DateTime($DateTime);
                $NewcustomField->date_value = $DateValue;
            }

            $NewcustomField->save();
        }

        return redirect('org/my_contacts');
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
        $customField = ContactCustomField::where('contact_id', $request->contactDeleteId)->delete();
        $contact = Contact::find($request->contactDeleteId)->delete();
    }
    
    public function approve($id)
    {
        $contact = Contact::findOrFail($id);
        $contact->is_approved = 1;
        $contact->save();
        return "success";
    }
}
