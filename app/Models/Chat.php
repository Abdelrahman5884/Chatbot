<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Chat extends Model
{
    protected $fillable=['name','user_id','prompt','response'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
