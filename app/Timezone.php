<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Timezone extends Model
{
    protected $table="timezones";
    
    ///each user may have multiple events - field - timezone_id
    ///returns array of object
     public function events() {
         return $this->hasMany('App\Timezone');
     }
}
