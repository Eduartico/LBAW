<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Post extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'post';

    protected $fillable = ['owner_id','event_id','title','text'];

    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = false;

    public function owner(){
        return $this->belongsTo(User::class,'owner_id');
    }

    public function event(){
        return $this->belongsTo(Event::class,'event_id');
    }

    public function votes(){
        return $this->hasMany(PostVote::class);
    }

    public function comments(){
        return $this->hasMany(Comment::class,'parent_post');
    }

}
