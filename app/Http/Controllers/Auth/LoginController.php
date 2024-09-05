<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Auth;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/dashboard';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }
    public function login(Request $request)
    {
        // Validate the request
        $this->validate($request, [
            'email' => 'required',
            'password' => 'required|string|min:6',
        ]);

        // Check if the email field is numeric, indicating a mobile number
        if (is_numeric($request->email)) {
            // Attempt to log in as a customer
            if (Auth::guard('customer')->attempt(['mobile_num' => $request->email, 'password' => $request->password])) {
                // Authentication passed for customer
                if (Auth::guard('customer')->check()) {
                    return redirect()->intended('/customer/dashboard');
                } else {
                    dd('Authentication passed, but session not maintained.');
                }
            }
        } else {
            // Attempt to log in as a user
            if (Auth::guard('web')->attempt(['email' => $request->email, 'password' => $request->password])) {
                // Authentication passed for user
                return redirect()->intended('/dashboard'); // Redirect to user dashboard or intended route
            }
        }
        // If neither guard was able to authenticate, redirect back with an error
        return redirect()->back()->withErrors([
            'email' => 'The provided credentials do not match our records.',
        ]);
    }
}
