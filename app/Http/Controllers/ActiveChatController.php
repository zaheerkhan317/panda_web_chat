<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Activechat;
use App\User;
use Auth;

class ActiveChatController extends Controller
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
        $this->validate($request, [
            'c_id' => 'required'
        ]);
        $cu = Auth::user()->id;
        $chk = Activechat::where('user_id','=',$cu)->first();
        if( !empty($chk)) {
            $chk->chat_id = $request->c_id;
            $chk->save();
        }else{
            $active = new Activechat;
            $active->chat_id = $request->c_id;
            $active->user_id = $cu;
            $active->typing = false;
            $active->save();
        }

        if(!empty($active) || !empty($chk)) {
            $resp['status'] =  1;
            $resp['txt'] = "Success";
        }else{
            $resp['status'] = 0;
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

    public function set_active(Request $request){
        $cu = Auth::user()->id;
        $chk = Activechat::where('user_id','=',$cu)->first();

        if( !empty($chk)){
            $chk->typing = $request->con;
            $chk->save();
        }

        if( !empty($chk) ) {
            $resp['status'] = 1;
            $resp['con'] = $request->con;
        }else{
            $resp['status'] = 0;
        }

        return json_encode($resp);
    }


    public function check_active(Request $request){
        $cu = Auth::user()->id;
        $chk = Activechat::where('chat_id','=',$request->c_id)->where('typing','=',1)->get();
        $usr = [];
        if ( count($chk) > 0) {
            foreach ($chk as $value) {
                $u = User::find($value->user_id);
                if ($u->id != $cu ){
                    $usr[] = $u->name;
                }
            }

            if ( count($usr) == 1 && $usr != Auth::user()->name && $usr != null){
                $resp['user_name'] = $usr;
                $resp['txt'] = 1;
            }elseif (count($usr) > 1 ){
                $resp['user_name'] = implode(",", $usr);
                $resp['txt'] = 1;
            }else{
                $resp['txt'] = 0;
            }
        }else{
            $resp['txt'] = 0;
        }

        if ( count($usr) ) {
            $resp['status'] = 1;
            
        }else{
            $resp['status'] = 0;
            $resp['txt'] = 'something went wrong!';
        }

        return json_encode($resp);
    }
}
