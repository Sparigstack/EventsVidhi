<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $table="categories";
    
    ///each user may have multiple events - field - user_id
    ///returns array of object
    public function events() {
        return $this->hasMany('App\Event');
    }
}
