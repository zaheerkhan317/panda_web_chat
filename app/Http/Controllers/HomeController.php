<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;

use Illuminate\Http\Request;
use App\User;
use App\Chat;


class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    /*
     public function index()
    {
        $users = User::all();
        return view('home',compact('users'));
    }
    */
    public function index()
    {
    $users = User::allUsers(); // Assuming allUsers() method exists on the User model
    $chats = Auth::user()->chats()->orderBy("id","desc")->get();
    $me = Auth::user();
    $msgs = [];
    $total_msg = Chat::chat_update($chats);
    return view('home', compact("users","chats","me","msgs","total_msg"));
    }

   
}
