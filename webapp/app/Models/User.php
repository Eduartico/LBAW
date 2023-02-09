<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use mysql_xdevapi\Table;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $table = 'user';

    protected $guard = 'user';

    protected $casts = [
        'is_admin' => 'boolean',
    ];
    // Don't add create and update timestamps in database.
    public $timestamps  = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
            'email', 'password','username','name'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];


    public function reportedEvent(){
        return $this->belongsToMany(Event::class,'eventreport');
    }

   public function Inviter(){
        return $this->hasMany(Invite::class,'inviter');
   }

   public function Invited(){
       return $this->hasMany(Invite::class,'invited');
   }

   public function Posts(){
       return $this->hasMany(Post::class,'owner_id');
   }

   public function Notifications(){
       return $this->hasMany(Notification::class);
   }

   public function Comments(){
       return $this->hasMany(Comment::class);
   }

   public function CommentVotes(){
       return $this->hasMany(CommentVote::class);
   }

    public function Post(){
        return $this->hasMany(Post::class);
    }

   public function PostVotes(){
       return $this->hasMany(PostVote::class);
   }

   public function events(){
       return $this->hasMany(Event::class,'owner_id');
   }

    public function organizes(){
        return $this->belongsToMany(Event::class, 'organizer');
    }

    public function attends()
    {
        return $this->belongsToMany(Event::class, 'attend');
    }
}
