<?php

namespace App\Http\Controllers\org;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DB;
use App\Tag;
use App\ContactTag;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class TagsController extends Controller
{
    public function __construct() {
        $this->middleware('verified');
    }
    
    public function show(){
        $user = Auth::id();
        $tags = Tag::where('user_id',$user)->get();
        return view('org/tags', compact('tags'));
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'tagName' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'error' => $validator->errors(),
            ]);
        }

        $user = Auth::id();
        $tag = new Tag;
        $tag->name = $request->tagName;
        $tag->user_id = $user;
        $tag->save();

        return response()->json([
            'id' => $tag->id,
            'tagName' => $tag->name,
            'error' => ''
        ]);
    }
    public function delete($id){
        $contact_tag = ContactTag::where('tag_id', $id)->delete();
        $event = Tag::find($id)->delete();
        return response()->json([
            "status"=>"success"
        ]);
    }
}
