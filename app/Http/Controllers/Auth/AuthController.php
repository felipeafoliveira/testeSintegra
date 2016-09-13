<?php

namespace App\Http\Controllers\Auth;

use Auth;
use App\User;
use Validator;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\ThrottlesLogins;
use Illuminate\Foundation\Auth\AuthenticatesAndRegistersUsers;

class AuthController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Registration & Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users, as well as the
    | authentication of existing users. By default, this controller uses
    | a simple trait to add these behaviors. Why don't you explore it?
    |
    */

    use AuthenticatesAndRegistersUsers, ThrottlesLogins;

    /**
     * Create a new authentication controller instance.
     *
     * @return void
     */
    protected $redirectPath = '/';
    protected $loginPath = '/login';
    
    public function __construct()
    {
        $this->middleware('guest', ['except' => 'getLogout']);
    }
    
    public function postLogin(Request $request)
    {
        if (Auth::attempt(['user' => $request->user, 'password' => $request->password])) {
            // Authentication passed...
            return redirect('/');
        }
        return redirect('auth/login');
    }
    
    public function getLogout(){
        Auth::logout();
        return redirect('auth/login');
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
            'user' => 'required|max:255|unique:users',
            'password' => 'required|confirmed|min:6',
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return User
     */
    protected function create(array $data)
    {
        return User::create([
            'user' => $data['user'],
            'password' => bcrypt($data['password']),
        ]);
    }
}
