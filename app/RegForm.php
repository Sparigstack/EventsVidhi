<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class RegForm extends Model
{
	use SoftDeletes;
    protected $table="reg_forms";
    
    public function event_reg_form_mappings() {
        return $this->belongsTo('App\EventRegFormMapping');
    }
}
