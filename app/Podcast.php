<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
//use Illuminate\Database\Eloquent\SoftDeletes;

class Podcast extends Model
{
	//use SoftDeletes;
    protected $table="podcasts";
    
    public function event() {
        return $this->belongsTo('App\Event');
    }

    public function user() {
        return $this->belongsTo('App\User');
    }
}
