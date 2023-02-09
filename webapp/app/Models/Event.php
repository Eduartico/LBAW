<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'event';

    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = false;

    public function owner(){
        return $this->belongsTo(User::class,'owner_id');
    }

    public function location(){
        return $this->belongsTo(Location::class,'location_id');
    }

    public function posts(){
        return $this->hasMany(Post::class);
    }

    public function organizers(){
        return $this->belongsToMany(User::class);
    }

    public function attenders(){
        return $this->belongsToMany(User::class,'attend');
    }

    //public function tags() {
    //    return $this->belongsToMany(Tag::class, 'event_tag', 'event_id', 'tag_id');
    //}
}
