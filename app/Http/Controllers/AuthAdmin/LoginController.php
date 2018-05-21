<?php

namespace App\Http\Controllers\AuthAdmin;

use App\Http\Controllers\Controller;
use Illuminate\Http\request;
use Illuminate\Support\Facades\Auth;

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

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest:admin')->except('logout');
    }

    /**
    *Show the application's login form.
    *
    *@return \illuminate\Http\Response
    */
    public function showLoginForm()
    {
        return view('authAdmin.login');
    }

    /**
    *Handle a login request to the application.
    *
    *@param \illuminate\Http\Request $request
    *@return \illuminate\Http\RedirectResponse|\illuminate\Http\Response\illuminate\Http\JsonResponse
    */
    public function login(Request $request)
    {
        $this->validate($request,[
            'email' => 'required|email',
            'password' => 'required|min:6'
        ]);

        $credential = [
            'email' => $request->email,
            'password' => $request->password
        ];

        //Atempt to log user in
        if (Auth::guard('admin')->attempt($credential,$request->member)){
        //if login succesful, then redirect to their intended location
        return redirect()->intended(route('admin.home'));
        }
        //if Unsuccesful, then redirect back to the login with the form data
        return redirect()->back()->withInput($request->only('email','remember'));
    }
}
