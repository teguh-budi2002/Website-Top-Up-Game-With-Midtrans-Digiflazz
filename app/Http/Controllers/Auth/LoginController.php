<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function loginDashboardMainPage() {
        return view("dashboard.views.Auth.login");
    }

    public function loginDashboardMemberPage() {
        return view("");
    }

    public function loginDashboardMainPageProcess(Request $request) { 
        $validation = $request->validate([ 
            'username' => 'required',
            'password' => 'required',
        ]);

        $remember_me = $request->remember_me ? true : false;
        if (Auth::attempt(['username' => $request->username, 'password' => $request->password], $remember_me)) {
            $request->session()->regenerate();
            // Auth::logoutOtherDevices($request->password);
            $user = Auth::getProvider()->retrieveByCredentials($validation);

            if ($user->status_active) {
                $user->status_online = 1;
                $user->ip_user = $request->ip();
                $user->save();

                return redirect()->intended('dashboard');
            } else {
                Auth::logout();
                return redirect()->route('login')->with('invalid-login', 'Your Account Has Been Deactivated');
            }
        }
       return redirect()->route('login')->with('invalid-login', 'Username or Password is invalid');
    }
}
