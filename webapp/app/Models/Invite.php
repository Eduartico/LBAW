<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Invite extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'invite';

    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = false;

    public function Inviter(){
        return $this->belongsTo(User::class,'inviter');
    }

    public function Invited(){
        return $this->belongsTo(User::class,'invited');
    }

    public function Event(){
        return $this->belongsTo(User::class,'event_id');
    }
}
