<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Chat extends Model
{

     protected $fillable = ['name', 'user_id', 'prompt', 'response', 'newchat_id'];

    public function newchat()
    {
        return $this->belongsTo(NewChat::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
