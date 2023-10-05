<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ActiveChat extends Model
{
    public $timestamps = false;
    protected $table = 'activechats';
}
