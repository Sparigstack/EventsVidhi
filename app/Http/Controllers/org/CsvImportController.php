<?php

namespace App\Http\Controllers\org;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DB;
use App\Contact;
use App\ContactCustomField;
use App\CustomField;
use App\Tag;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\UploadedFile;
use File;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;

class CsvImportController extends Controller
{
    public function __construct() {
        $this->middleware('verified');
    }
    
    public function index(){
        $userId = Auth::id();
        $customFields=CustomField::where('user_id',$userId)->orderBy('id', 'ASC')->get();
        
        $customFieldOrder="";
        foreach($customFields as $customField){
            $customFieldOrder .=", ".$customField->name;
        }
        return view('org/csvImport',compact('customFieldOrder'));
    }
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'CsvFile' => 'required|mimes:csv',
        ]);

        // if ($validator->fails()) {
        //     return response()->json([
        //         'error' => $validator->errors(),
        //     ]);
        // }

        $path = $request->file('CsvFile')->getRealPath();
        $data = array_map('str_getcsv', file($path));
        // $csv_data = array_slice($data, 0, 2);


        $userId = Auth::id();
        $numberOfRows = count($data);
        $customFields=CustomField::where('user_id',$userId)->orderBy('id', 'ASC')->get();
        for ($i = 1; $i < $numberOfRows; $i++) {

            $contact = new Contact;
            $contact->user_id = $userId;
            $contact->first_name = $data[$i][0];
            $contact->last_name = $data[$i][1];
            $contact->email = $data[$i][2];
            $contact->contact_number = $data[$i][3];
            $contact->save();

            if (isset($data[$i][4])) {
                $CustomCounter = 4;
                foreach ($customFields as $customField) {
                    $contctCustomField = new ContactCustomField;
                    $contctCustomField->contact_id = $contact->id;
                    $contctCustomField->customfield_id = $customField->id;
                    if ($customField->type == 1) {
                        $contctCustomField->string_value = $data[$i][$CustomCounter];
                    } elseif ($customField->type == 2) {
                        $contctCustomField->int_value = $data[$i][$CustomCounter];
                    } else {
                        $contctCustomField->date_value = $data[$i][$CustomCounter];
                    }
                    $contctCustomField->save();
                    $CustomCounter ++;
                }
            }

        }

        return 'success';
    }
}
