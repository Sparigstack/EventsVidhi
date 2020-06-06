<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Ticket extends Model
{
    protected $table="tickets";
    
    ///each tag belongs to some event, field - event_id
    ///returns single object
    public function event() {
        return $this->belongsTo('App\Event');
    }
    
}
