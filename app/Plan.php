<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Plan extends Model
{
    protected $table="plans";

    public function user() {
        return $this->belongsTo('App\User', 'user_id');
    }
}