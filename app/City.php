<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class City extends Model
{
    protected $table="cities";
    
    ///each user may have multiple events - field - city_id
    ///returns array of object
     public function events() {
         return $this->hasMany('App\Event');
     }

     public function state() {
        return $this->belongsTo('App\State');
    }
    public function country() {
        return $this->belongsTo('App\Country');
    }
}
