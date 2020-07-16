<?php

namespace App\Http\Controllers\org;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\CustomField;
use App\ContactCustomField;
use DateTime;
use Exception;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\UploadedFile;
use File;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Redirect;

class CustomFieldController extends Controller
{
    public function __construct() {
        $this->middleware('verified');
    }
    
    public function index()
    {
        $user = Auth::user();
        $customFields = "";
        $customFields = CustomField::where('user_id', $user->id)->get();
        return view('org/customField', compact('customFields'));
    }

    public function store(Request $request)
    {
        $customField = new CustomField;
        $customField->name = $request->name;
        $customField->type = $request->DisplayType;
        $userId = Auth::id();
        $customField->user_id = $userId;
        $customField->save();
        return response()->json([
            "status"=>"success"
        ]);
        //return Redirect::back()->with('message','Operation Successful !');
    }

    public function edit($id)
    {
        // return 'mansi';
        $user = Auth::user();
        $customFields1 = CustomField::findOrFail($id);
        $customFields = CustomField::where('user_id', $user->id)->get();
        // return redirect('org/customFields/edit/'. $customFields->id);
        return view('org/customField', compact('customFields', 'customFields1'));
    }

    public function update(Request $request, $id){
        $customFields1 = CustomField::findOrFail($id);
        $customFields1->name = $request->name;
        $userId = Auth::id();
        $customFields1->user_id = $userId;
        $customFields1->save();
        return redirect('org/customFields');
    }

    public function delete($id){
        $event = CustomField::find($id)->delete();
        return response()->json([
            "status"=>"success"
        ]);
    }
}
