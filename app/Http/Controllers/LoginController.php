<?php

namespace App\Http\Controllers;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use Session;
use App\Models\User;

class LoginController extends Controller
{

    public function index()
    {
        return view('login');
    }

    public function login(Request $request)
    {
        $validator = \Validator::make($request->all(), [
            'username'    =>  'required',
            'password'    =>  'required'
        ]);

        if ($validator->fails()) {
            return redirect('/')->with('error','Validation Error');
        }

        $check_cursor = User::where('username', $request->username)->count();
        if ($check_cursor == 0) {
            return redirect('/')->with('error', 'User not found');
        }

        $user_info = User::where('username', $request->username)->first();
        $hash_password = $user_info->password;
        if (\password_verify($request->password, $hash_password)) {
            Session::put('info_user',$user_info);
            return redirect()->route('dashboard');
        }
    }

}
