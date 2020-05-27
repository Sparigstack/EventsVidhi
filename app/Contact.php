<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Contact extends Model
{
    protected $table="contacts";
    
    ///each contact belongs to some user, field - user_id
    ///returns single object
    public function user() {
        return $this->belongsTo('App\User');
    }
    
    public function tags(){
        //return $this->belongsToMany('App\Tag', 'contact_tag', 'contact_id', 'tag_id');
        return $this->belongsToMany('App\Tag');
    }
    
    
}
