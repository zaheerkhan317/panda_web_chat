<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Support\Facades\Cache;
use App\Chat;
use Auth;
class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'phone', 'last_seen'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];
    
    static function allUsers()
    {
        return User::where("id","<>",Auth::user()->id)->get();
    }

    public function chats()
{
    return $this->belongsToMany(Chat::class, 'chat_user', 'user_id', 'chat_id');
}

    public function msgs()
    {
        return $this->hasMany(Msg::class);
    }

    public function sendMessageWithAttachment($msg, $c_id, $attachmentPath)
    {
        $message = new Msg;
        $message->msg = $msg;
        $message->attachment = $attachmentPath; // Store the file path
        $message->user_id = $this->id; // Assuming you're sending the message on behalf of the current user
        $message->chat_id = $c_id;
        $message->seen = 0;
        $message->save();

        return $message;
    }

    

    // UserController.php

    

    /*public function chats()
    {
        return $this->belongsToMany(Chat::class);
    }*/
}
