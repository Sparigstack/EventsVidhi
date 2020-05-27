<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Tag extends Model
{
    protected $table="tags";
    
    ///each tag belongs to some user, field - user_id
    ///returns single object
    public function user() {
        return $this->belongsTo('App\User');
    }
    
    public function contacts(){
        return $this->belongsToMany('App\Contact');
    }
}
