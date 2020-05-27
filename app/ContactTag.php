<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ContactTag extends Model
{
    protected $table="contact_tag";
    
    ///each contact_tag belongs to some contact, field - contact_id
    ///returns single object
    public function contact() {
        return $this->belongsTo('App\Contact');
    }
    
    ///each contact_tag belongs to some list_tag, field - list_tag_id
    ///returns single object
    public function tag() {
        return $this->belongsTo('App\Tag', 'tag_id');
    }
}
