<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'comment';

    protected $primaryKey = 'id';

    protected $fillable = ['owner_id', 'parent_post', 'parent_comment', 'text'];

    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = false;

    public function parent_post(){
        return $this->belongsTo(Post::class,'parent_post');
    }

    public function parent_comment(){
        return $this->belongsTo(Comment::class,'parent_comment');
    }

    public function children_comment(){
        return $this->hasMany(Comment::class,'parent_comment');
    }

    public function owner(){
        return $this->belongsTo(User::class,'owner_id');
    }

    public function CommentVotes(){
        return $this->hasMany(CommentVote::class);
    }


}
