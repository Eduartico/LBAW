<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Tag extends Model
{
    public $table = 'tag';

    public function events() {
        return $this->belongsToMany(Event::class);        
    }
}
