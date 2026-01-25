<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class RegisterController extends Controller
{
    use RegistersUsers;

    protected $redirectTo = '/home';

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
        return Validator::make($data, [
            'name'     => ['required', 'string', 'max:255'],
            'email'    => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'phone_1'  => [
                'required',
                'digits:11',
                'regex:/^(?!.*(\d)\1{10})\d{11}$/', // Rejects all repeated digits
                'unique:users,phone_1'
            ],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ], [
            'phone_1.regex' => 'The phone number cannot contain all the same digits.',
            'phone_1.digits' => 'The phone number must be exactly 11 digits.',
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\Models\User
     */
    protected function create(array $data)
    {
        return User::create([
            'name'     => $data['name'],
            'email'    => $data['email'],
            'phone_1'  => $data['phone_1'],
            'password' => Hash::make($data['password']),
        ]);
    }
}
