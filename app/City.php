<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class City extends Model
{
    protected $table="cities";
    
    ///each user may have multiple events - field - user_id
    ///returns array of object
    // public function events() {
    //     return $this->hasMany('App\Event');
    // }
}
