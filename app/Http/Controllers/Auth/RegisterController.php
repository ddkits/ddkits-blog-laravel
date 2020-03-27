<?php

namespace App\Http\Controllers\Auth;

use App\User;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;
use App\Http\Controllers\Profile;
use Session;
use Request;

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
    protected $redirectTo = '/dashboard';

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
        return Validator::make($data, [
            'username' => 'required|string|max:255|unique:users',
            'firstname' => 'string|max:255',
            'lastname' => 'string|max:255',
            'industry' => 'string|max:255',
            'job_title' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:3',
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\User
     */
    protected function create(array $data, $level = 1, $role = 2)
    {

        $result = DB::table('admins')->get();
        if ($result->isEmpty()) {
            DB::table('admins')->insert([
               // ['uid' => 1, 'id' => 1, 'level' => 1],
                ['uid' => 1, 'level' => 0],
            ]);
        }
        // creat the user first
       return User::create([
            'username' => $data['username'],
            'email' => $data['email'],
            'firstname' => $data['firstname'],
            'lastname' => $data['lastname'],
            'job_title' => $data['job_title'],
            'industry' => $data['industry'],
            'password' => bcrypt($data['password']),
            'ip' => Request::ip(),
            'role' => $role,
            'level' => $level,
        ]);
        
    //     $user = DB::table('users')->where('email', $data['email'])->first();
    // // Create profile for this user
    //   return DB::table('profiles')->insert([
    //         ['uid'=> $user->id],
    //         ]);
        

        // set flash data with success msg
        Session::flash('Success', 'Welcome !!');
    }
    
}
