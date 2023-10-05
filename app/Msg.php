<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Chat;

class Msg extends Model
{
    public function chat()
    {
        return $this->belongsTo(Chat::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
