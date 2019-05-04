<?php

namespace App\Http\Controllers;

use Auth;
use Illuminate\Http\Request;

class ProfileController extends Controller
{
    public function index()
    {
        return view('profile');
    }

    public function updateInfo(Request $request)
    {
        $user = Auth::user();

        $this->ajaxValidate($request, [
            'name' => 'required|max:255',
            'email' => 'required|email|max:255|unique:users,email,' . $user->id
        ]);

        $user->name = $request->name;
        $user->email = $request->email;
        $user->save();

        return response(['status' => 'Your information updated successfully.']);
    }

    public function updatePass(Request $request)
    {
        $user = Auth::user();

        $this->ajaxValidate($request, [
            'old_password' => 'required|old_password:' . $user->password,
            'new_password' => 'required|min:6',
            'password_confirmation' => 'required|min:6|same:new_password'
        ]);

        $user->password = bcrypt($request->new_password);
        $user->save();

        return response(['status' => 'Your password updated successfully.']);
    }
}
