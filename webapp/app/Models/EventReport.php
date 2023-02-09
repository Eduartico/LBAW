<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EventReport extends Model
{
    protected $table = 'eventreport';

    // Don't add create and update timestamps in database.
    public $timestamps  = false;


    public function event(){
        $this->hasOne(Event::class,'event_id');
    }

    public function user(){
        $this->hasOne(User::class,'user_id');
    }

}
