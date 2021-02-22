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

    public function country() {
        return $this->belongsTo('App\Country');
    }
    
    ///each event belongs to some timezone, field - timezone_id
    ///returns single object
    public function timezone() {
        return $this->belongsTo('App\Timezone');
    }

//    public function eventCategory() {
//        return $this->hasMany('App\EventCategory');
//    }
    
    public function categories() {
        return $this->belongsToMany('App\Category', 'event_categories');
    }
    
    public function Videos() {
        return $this->hasMany('App\Video');
    }
    
    
    public function tickets(){
        return $this->hasMany('App\Ticket');
    }

     public function eventRegFormMappings() {
        return $this->belongsToMany('App\EventRegFormMapping', 'event_reg_form_mappings');
    }

}
