<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Event extends Model
{
    use SoftDeletes;
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

    ///each event belongs to some city, field - city_id
    ///returns single object
    public function city() {
        return $this->belongsTo('App\City');
    }
    
    ///each event belongs to some timezone, field - timezone_id
    ///returns single object
    public function timezone() {
        return $this->belongsTo('App\Timezone');
    }

    public function eventCategory() {
        return $this->hasMany('App\EventCategory');
    }
}
