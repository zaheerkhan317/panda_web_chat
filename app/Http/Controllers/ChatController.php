<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Cache;

use Illuminate\Http\Request;
use App\User;
use App\Chat;
use Auth;
class ChatController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */

     public function storechat(Request $request)
        {
            // Validate input data
            $this->validate($request, [
                'phone' => 'required', // Assuming you have a field named 'phone_number'
            ]);


            $recipient = User::where('phone', $request->phone)->first();

            if (!$recipient) {
                $resp['status'] = 0;
                $resp['txt'] = "Recipient user not found!";
                return json_encode($resp);
            }

            // Check if a chat already exists between the authenticated user and the recipient
            $existingChat = Auth::user()->chats()->whereHas('users', function ($query) use ($recipient) {
                $query->where('users.id', $recipient->id);
            })->first();

            if ($existingChat) {
                $resp['status'] = 0;
                $resp['txt'] = "Chat already exists!";
                return json_encode($resp);
            }

            // Create a new chat
            $chat = new Chat;
            $chat->user_id = Auth::user()->id;
            $chat->save();

            // Attach both the authenticated user and the recipient user to the chat
            $chat->users()->attach([Auth::user()->id, $recipient->id]);

            $resp['status'] = 1;
            $resp['txt'] = "Successfully created a new chat";
            $resp['obj'] = $chat;
            $resp['objusers'] = $chat->users;

            return json_encode($resp);
        }


     







    public function store(Request $request)
    {
        $this->validate($request, [
            'users' => "required"
        ]);

        $chk_chats = Auth::user()->chats;

        $already_exist = "";
        foreach ($chk_chats as $ct) {
            $un = [];
            $already_exist = false;
            foreach ($ct->users as $u) {
                if (Auth::user()->id != $u->id){
                    $un[] = (string)$u->id;
                }
            }

            if ($request->users == $un){
                $already_exist = true;
                break;
            }else{
                $already_exist = false;
            }
        }

        if (!$already_exist){
            $chat = new Chat;
            $chat->user_id = Auth::user()->id;
            $chat->save();
            $chat->users()->attach(Auth::user()->id);
            foreach ($request->users as $id){
                $chat->users()->attach($id);
            }
            if(!empty($chat)){
                $resp['status'] = 1;
                $resp['txt'] = "Successfully Created A New Chat";
                $resp['obj'] = $chat;
                $resp['objusers'] = $chat->users;
            }else{
                $resp['status'] = 0;
                $resp['txt'] = "Something went wrong!";
            }
        }else{
            $resp['status'] = 0;
            $resp['txt'] = "Chat Already Exist!";
        }

        return json_encode($resp);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */



    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function chat_update()
    {
        $chats = Auth::user()->chats()->orderby('id','desc')->get();
        $total_msg = Chat::chat_update($chats);
        return json_encode($total_msg);
    }

    public function chat_list()
    {
        $chats = Auth::user()->chats()->orderBy('id','desc')->get();
        $me = Auth::user();
        // Get online status for each user in the chats
        foreach ($chats as $chat) {
            foreach ($chat->users as $user) {
                $user->online = $user->isOnline();
            }
        }
        $resp['status'] = 1;
        $resp['txt'] = (string) view('layouts.chat_list', compact("chats","me"));
        return json_encode($resp);
    }


    public function toggleBlock($chatId)
    {
        $chat = Chat::findOrFail($chatId);
        $chat->blocked = !$chat->blocked;
        $chat->save();
        return view('layouts.msg_list', compact('chat'));

    }
}
