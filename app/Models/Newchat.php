<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Newchat extends Model
{
    protected $fillable=['name','user_id','chat_id'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
