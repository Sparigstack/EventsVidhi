<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class EventRegFormMapping extends Model
{
    protected $table="event_reg_form_mappings";
    
    public function regForm() {
        return $this->belongsToMany('App\RegForm', 'reg_form');
    }

    public function events() {
        return $this->belongsToMany('App\Event');
    }
}
