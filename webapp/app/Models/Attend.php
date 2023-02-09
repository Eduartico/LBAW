<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Attend extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'attend';

    protected $primaryKey = ['user_id','poll_id'];

    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = false;

    public function user(){
        return $this->belongsTo(User::class);
    }

    public function event(){
        return $this->belongsTo(Event::class);
    }

}
