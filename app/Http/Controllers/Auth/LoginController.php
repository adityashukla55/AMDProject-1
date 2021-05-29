<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\User;
use Redirect;

class LoginController extends Controller
{
    use AuthenticatesUsers;
   
    public function login(Request $request)
    {
        $user = User::where("username", $request->username)->first();
        $errors = [$this->username() => trans('auth.failed')];
        if(is_null($user)) {
            return redirect()->back()->withInput($request->only($this->username(), 'remember'))->withErrors($errors);
        }

        Auth::login($user);
        if (Auth::user()->role) {
            return redirect('/meetings');
        } else {
            return redirect('/home');
        }       

    }

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    public function username()
    {
        return 'username';
    }

}
