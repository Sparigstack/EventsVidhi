<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
//use Illuminate\Database\Eloquent\SoftDeletes;

class Speaker extends Model {

    protected $table = "speakers";

    ///each user may have multiple events - field - city_id
    ///returns array of object
    public function events() {
        return $this->hasMany('App\Event');
    }

}
