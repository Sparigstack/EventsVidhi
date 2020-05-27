<?php

namespace App\Http\Controllers\org;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DB;
use App\Contact;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\UploadedFile;
use File;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;

class CsvImportController extends Controller
{
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
        for ($i = 1; $i < $numberOfRows; $i++) {

            $contact = new Contact;
            $contact->user_id = $userId;
            $contact->first_name = $data[$i][0];
            $contact->last_name = $data[$i][1];
            $contact->email = $data[$i][2];
            $contact->save();
        }

        return 'success';
    }
}
