<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\ResetsPasswords;
use Illuminate\Foundation\Auth\SendsPasswordResetEmails;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Password;


use Sentinel;
use App\Reminder;
use App\User;
use Mail;

class ForgotPasswordController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Password Reset Controller
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for handling password reset emails and
    | includes a trait which assists in sending these notifications from
    | your application to your users. Feel free to explore this trait.
    |
    */

    use SendsPasswordResetEmails;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    public function password(Request $request)
{
    $user = User::where('email', $request->email)->first();

    if ($user === null) {
        return redirect()->back()->with(['error' => 'Email not exists']);
    }

    $token = app('auth.password.broker')->createToken($user);

    // Now you can send the reset link using Laravel's built-in functionality
    $this->sendEmail($user, $token);

    return redirect()->back()->with(['success' => 'Reset code sent to your email.']);
}



public function sendEmail($user, $token)
{
    Mail::send(
        'email.forgot',
        ['user' => $user, 'token' => $token, 'code' => $token],  // Corrected variable name to $user
        function ($message) use ($user) {
            $message->to($user->email);
            $message->subject("$user->name, reset your password.");
        }
    );
}


    public function showResetForm($email, $token)
    {
        return view('auth.passwords.reset')->with(['email' => $email, 'token' => $token]);
    }

    /*
    public function resetPassword(Request $request)
    {
        // Validate the request
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required|confirmed|min:6',
            'token' => 'required'
        ]);
    
        // Check if validation fails
        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        // Find the user by email
        $user = User::where('email', $request->email)->first();

        if (!$user) {
            return redirect()->back()->with(['error' => 'Email not found']);
        }

        // Check the token validity
        if (!$this->isTokenValid($user, $request->token)) {
            return redirect()->back()->with(['error' => 'Invalid token']);
        }

        // Update the user's password
        $user->password = $request->password;
        $user->save();

        // You may want to invalidate the token after use

        return redirect()->route('password.reset.success')->with(['success' => 'Password reset successfully']);
    }*/

    private function isTokenValid($user, $token)
    {
        return Password::broker()->tokenExists($user, $token);
    }

    public function showResetSuccess(Request $request)
{
    // Validate the request
    $validator = Validator::make($request->all(), [
        'email' => 'required|email',
        'password' => 'required|confirmed|min:6',
        'token' => 'required'
    ]);

    // Check if validation fails
    if ($validator->fails()) {
        return redirect()->back()
            ->withErrors($validator)
            ->withInput();
    }

    // Find the user by email
    $user = User::where('email', $request->email)->first();

    if (!$user) {
        return redirect()->back()->with(['error' => 'Email not found']);
    }

    // Check the token validity
    if (!$this->isTokenValid($user, $request->token)) {
        return redirect()->back()->with(['error' => 'Invalid token']);
    }

    // Update the user's password
    
    $hashedPassword = bcrypt($request->password);

    // Update the user's password with the hashed password
    $user->password = $hashedPassword;
    $user->save();
    $user->save();

   
    return view('auth.passwords.reset_success');
}


}
