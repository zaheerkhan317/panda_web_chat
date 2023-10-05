<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Msg;
use App\Chat;
use Auth;

class MsgController extends Controller
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
    public function store(Request $request)
    {
        $rules = [
            //'msg' => $request->hasFile('attachment') ? '' : 'required',
            'msg' => 'required_without:attachment',
            
        ];
    
        $this->validate($request, $rules);

        $cu = Auth::user()->id;
        $msg = new Msg;

        if ($request->has('msg') && !empty($request->msg)) {
            $msg->msg = $request->msg;
        }
        

        if ($request->has('dragged_message')) {
            $msg->dragged_message = $request->dragged_message; // Store the dragged message
        }
        
        if ($request->hasFile('attachment')) {
            $file = $request->file('attachment');
            $originalFileName = $file->getClientOriginalName();
            // Generate a unique filename for the attachment
            $attachmentName = uniqid() . '_' . $originalFileName;
            
            // Move the uploaded file to the desired directory
            $file->move(base_path() . '/public/chatimg/', $attachmentName);
            
            // Set the attachment column to the file path
            $msg->attachment = 'chatimg/' . $attachmentName;
            if (!empty($request->msg)) {
                $msg->msg = $request->msg;  // Set msg only if provided
            }
            else{
                $msg->msg = '';

            }
        }

        

        $msg->user_id = $cu;
        $msg->chat_id = $request->c_id;
        $msg->seen = 0;
        $msg->save();

        if(!empty($msg)) {
            $resp["status"] = 1;
            $resp['txt'] = "Successfully Create A New Msg";
            $resp['obj'] = $msg;
            $resp['seen'] = $msg->seen;

            $c = Chat::find($request->c_id);
            if(count($c->msgs) >1){
                $resp['fst'] = 0;
            }else{
                $resp['fst'] = 1;
            }

        }else{
            $resp["status"] = 0;
            $resp['txt'] = "Something went wrong";
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
    public function destroy($id)
    {
        //
    }

    public function message_list(Request $request)
    {
        $chat = Chat::find($request->c_id);
        if($request->limit > 10){
            $total = $chat->msgs()->orderBy("id","desc")->get();

            if (count($total) < $request->limit + 10) {
                $resp['end'] = true;
            }

            $msgs = $chat->msgs()->take($request->limit)->skip($request->limit - 10)->orderBy("id","desc")->get();
        }
        else{
            $msgs = $chat->msgs()->take($request->limit)->orderBy("id","desc")->get();
        }
        $me = Auth::user();

        if (!isset($resp['end'] )) {
            $resp['end'] = false;
        }

        $resp['status'] = 1;
        $resp['txt'] = (string) view('layouts.msg_list',compact("msgs","me"));
        return json_encode($resp);

    }


    public function new_message_list(Request $request)
    {
        $chat = Chat::find($request->c_id);
        $me = Auth::user();
        if($request->me == 1){
            $msgs = $chat->msgs()->where('seen','=',0)->where('user_id','=',$me->id)->orderBy("id","desc")->take(1)->get();

        }
        else{
            $msgs = $chat->msgs()->where('seen','=',0)->where('user_id','<>',$me->id)->orderBy("id","desc")->get();
        }

        if(count($msgs) > 0){
            $resp['status'] = 1;
            $resp['txt'] = (string) view('layouts.msg_list',compact("msgs","me"));
            
        }else{
            $resp['status'] = 2;
        }
       
        return json_encode($resp);
    }


    public function message_seen(Request $request)
    {
        $ck = Msg::where('seen','=',0)->where('chat_id','=', $request->c_id)->where('user_id','<>',Auth::user()->id)->update(['seen'=>1]);
        if($ck){
            $resp['status'] = 1;
        }else{
            $resp['status'] = 0;
        }
        return json_encode($resp);
    }

    public function checkSeenUpdates(Request $request)
    {
        // Fetch the message IDs that have been seen (update this according to your database structure)
        $seenMessageIds = Msg::where('seen', 1)->pluck('id')->toArray();

        // Return the seen message IDs as JSON response
        return response()->json(['seenMessageIds' => $seenMessageIds]);
    }


    



    

    /*public function message_status(Request $request)
    {
         // Retrieve the authenticated user's ID
         $userId = Auth::id();

         // Retrieve the chat ID from the request
         $chatId = $request->input('c_id');
 
         // Retrieve the updated message statuses for the given chat and user
         $updatedMessageStatuses = Msg::where('chat_id', $chatId)
            ->where('user_id', $userId)
            ->get(['id', 'seen']);

        // Create an associative array with message ID as key and seen status as value
        $statuses = [];
        foreach ($updatedMessageStatuses as $status) {
            $statuses[$status->id] = $status->seen;
        }
 
         // Return a JSON response with the updated message statuses
         return response()->json([
             'status' => 1,
             'updatedMessageStatuses' => $updatedMessageStatuses,
         ]);

    }*/
}
