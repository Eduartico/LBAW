<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Poll extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'poll';

    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = false;

    public function Post(){
        return $this->belongsTo(Post::class,'post_id');
    }
}
