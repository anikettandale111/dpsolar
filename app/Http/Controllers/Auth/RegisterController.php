<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Customers;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    // protected $redirectTo = '/dashboard';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make(
            $data,
            [
                'first_name' => ['required', 'string', 'max:255'],
                'last_name' => ['required', 'string', 'max:255'],
                'email' => ['required', 'string', 'email', 'max:255', 'unique:customers'],
                'mobile_num' => ['required', 'numeric', 'digits:10'], // ,'unique:customers'
                'mobile_otp' => ['required', 'numeric', 'digits:6'],
                'password' => ['required', 'string', 'min:8', 'confirmed'],
            ],
            [
                'mobile_num.required' => 'The mobile number is required.',
                'mobile_num.digits' => 'The mobile number must be exactly 10 digits.',
                'mobile_num.numeric' => 'The mobile number must contain only numbers.',
                'mobile_num.unique' => 'The mobile number already registered.',
                'mobile_otp.required' => 'The OTP number is required.',
                'mobile_otp.digits' => 'The OTP must be 6 digits.',
                'mobile_otp.numeric' => 'The OTP must contain only numbers.',
            ]
        );
        // return Validator::make($data, [
        //     'name' => ['required', 'string', 'max:255'],
        //     'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
        //     'password' => ['required', 'string', 'min:8', 'confirmed'],
        // ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\Models\User
     */
    protected function create(array $data)
    {
        $customer = Customers::updateOrCreate(
            ['mobile_num' => $data['mobile_num']], // The attributes to check for existence
            [
                'first_name' => $data['first_name'],
                'last_name' => $data['last_name'],
                'email' => $data['email'],
                'password' => Hash::make($data['password'])
            ]
        );
        // return User::create([
        //     'name' => $data['name'],
        //     'email' => $data['email'],
        //     'password' => Hash::make($data['password']),
        // ]);
         // Log in the customer
        auth()->guard('customer')->login($customer);

        return $customer;
    }
    protected function redirectTo()
    {
        // Default redirection if no specific role is matched
        $return_url = 'customer/dashboard';
        if (auth()->user()->role === 'admin') {
            $return_url = '/dashboard';
        } else if (auth()->user()->role === 'user') {
            $return_url = '/user/dashboard';
        }
        return $return_url;
    }
}
