<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Newchat extends Model
{
    protected $table = 'newchats';
    protected $fillable = ['title', 'user_id'];

    public function chats()
    {
        return $this->hasMany(Chat::class);
    }
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
