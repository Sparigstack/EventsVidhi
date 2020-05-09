<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    protected $table="events";
    
    ///each event belongs to some user, field - user_id
    ///returns single object
    public function user() {
        return $this->belongsTo('App\User', 'user_id');
    }
    
    ///each event belongs to some category, field - category_id
    ///returns single object
    public function category() {
        return $this->belongsTo('App\Category');
    }
}
