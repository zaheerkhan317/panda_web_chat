<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Cache;
use Illuminate\Http\Request;
use Auth;
use App\User;
use Carbon\Carbon;

use Session;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $users = User::select("*")
                        ->whereNotNull('last_seen')
                        ->orderBy('last_seen', 'DESC')
                        ->paginate(10);
          
        return view('users', compact('users'));
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

    public function profile()
    {
        $me = Auth::user();
        $users = User::allUsers();
        return view('profile', compact('me','users'));
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => "required",
            'email' => "required|unique:users,email,".Auth::user()->id,
        ]);
        $user = User::find(Auth::user()->id);
        $user->name = $request->name;
        $user->email = $request->email;
        $user->save();
        Session::flash('success', "Saved Successfully");
        return redirect('/profile');
    }

    public function pic(Request $request)
    {
        $this->validate($request, ['pic_file' => "required|image|mimes:jpeg,png,jpg",]);
        $user = User::find(Auth::user()->id);
        $imageName = $user->id .'-'. uniqid() .'.'. $request->file('pic_file')->getClientOriginalExtension();
        $request->file('pic_file')->move( base_path() .'/public/img/', $imageName);
        $user->pic = $imageName;
        $user->save();
        Session::flash('success', "Image Updated Successfully");
        return redirect('/profile');
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

    public function fetchUserName(Request $request)
    {
        try {
            $phoneNumber = $request->input('searchPhoneInput');
            
            $user = User::where('phone', $phoneNumber)->first();

            if (!is_null($user)) {
                return response()->json(['exists' => true, 'name' => $user->name]);
            } else {
                return response()->json(['exists' => false]);
            }
        } catch (\Exception $e) {
            \Log::error('Error fetching user name: ' . $e->getMessage());
            return response()->json(['exists' => false]);
        }
    }


    public function getUserSuggestions(Request $request)
    {
        $searchValue = $request->input('q');
        $authUserId = auth()->user()->id;
        
        $users = User::where('name', 'like', '%' . $searchValue . '%')
                    ->orWhere('phone', 'like', '%' . $searchValue . '%')
                    ->where('id', '!=', $authUserId)
                    ->limit(5)
                    ->get(['id', 'name', 'phone']);

        return response()->json($users);
    }

    public function checkPhoneExistence(Request $request)
    {
        $phoneNumber = $request->input('searchPhoneInput');

        $user = User::where('phone', $phoneNumber)->first();

        return response()->json(['exists' => !is_null($user)]);
    }

    
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


    public function pass_update(Request $request)
    {
        $this->validate($request, [
            'new_password' => "required|min:4|confirmed",
        ]);
        $user = User::find(Auth::user()->id);
        $user->password = bcrypt($request->new_password);
        $user->save();
        Session::flash('success', "Password Updated Successfully");
        return redirect('/profile');
    }


    public function updateOnlineStatus(Request $request)
    {
        $users = User::all();
        return view('status', compact('users'));
    }

    public function checkOnlineStatus($userId)
    {
        $isOnline = Cache::has('is_online' . $userId);
        $lastSeen = $isOnline ? '' : Carbon::parse(User::find($userId)->last_seen)->diffForHumans();

        return response()->json(['isOnline' => $isOnline, 'lastSeen' => $lastSeen]);
    }
    

    
}
