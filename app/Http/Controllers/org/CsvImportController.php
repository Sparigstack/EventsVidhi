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
        // if ($request->hasFile('CsvFile')) {
        //     $file = $request->file('CsvFile');
        //     $customerArr = $this->csvToArray($file);
        // }
        $file = $request->file('CsvFile');
        $customerArr =csvToArray($file);

        return $customerArr;
    }
}
