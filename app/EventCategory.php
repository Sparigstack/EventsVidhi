<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class EventCategory extends Model
{
    protected $table="event_categories";
    
    ///each user may have multiple events - field - user_id
    ///returns array of object
    public function event() {
        return $this->hasOne('App\Event');
    }
    public function categories() {
        return $this->hasMany('App\Category');
    }
}
