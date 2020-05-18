<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Video extends Model
{
    //
    protected $table="videos";

    public function events() {
        return $this->belongsTo('App\Event');
    }

}
