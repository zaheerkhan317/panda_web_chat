<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class LogoutController extends Controller
{
    //

    protected function loggedOut(Request $request)
    {
        $user = Auth::user();

        if ($user) {
            $this->updateOnlineStatus($user, false);
        }

        return redirect('/');
    }

    protected function updateOnlineStatus($user, $status)
    {
        $user->is_online = $status;
        $user->save();
    }


}
