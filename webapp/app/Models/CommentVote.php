<?php

namespace App\Models;

use Egulias\EmailValidator\Parser\Comment;
use Illuminate\Database\Eloquent\Model;

class CommentVote extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'commentvote';

    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = false;

    protected $primaryKey = ['comment_id','user_id'];
    public $incrementing = false;

    public function comment(){
        return $this->belongsTo(Comment::class);
    }

    public function user(){
        return $this->belongsTo(User::class);
    }
}
