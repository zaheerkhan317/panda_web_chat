<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\User;
use App\Msg;
use Auth;

class Chat extends Model
{
    public function users()
{
    return $this->belongsToMany(User::class, 'chat_user', 'chat_id', 'user_id');
}

    public function selectedUser()
    {
        return $this->belongsTo(User::class, 'selected_user_id');
    }

    public function msgs()
    {
        return $this->hasMany(Msg::class);
    }

    static public function chat_update($chats)
    {
        $total_msg = [];
        foreach ($chats as $chat){
            $i = 0;
            foreach ($chat->msgs as $msg){
                if($msg->seen == 0 && $msg->user_id != Auth:: user()->id){
                    $i++;
                    $total_msg[$chat->id] = $i;
                }
            }
        }
        return $total_msg;
    }
}
