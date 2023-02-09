<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PollVote extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'pollVote';

    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = false;
    protected $primaryKey = ['poll_id','user_id'];
    public $incrementing = false;

    public function user(){
        return $this->belongsTo(User::class);
    }

    public function poll(){
        return $this->belongsTo(Poll::class);
    }

    public function option(){
        return $this->belongsTo(Option::class);
    }
}
