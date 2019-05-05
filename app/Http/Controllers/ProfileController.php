<?php

namespace App\Http\Controllers;

use Auth;
use App\Http\Requests\ProfileFormRequest;

class ProfileController extends Controller
{
    public function index()
    {
        return view('profile');
    }

    public function updateInfo(ProfileFormRequest $request)
    {
        $user = Auth::user();

        $user->name = $request->name;
        $user->email = $request->email;
        $user->save();

        return response(['status' => 'Your information updated successfully.']);
    }

    public function updatePass(ProfileFormRequest $request)
    {
        $user = Auth::user();

        $user->password = bcrypt($request->new_password);
        $user->save();

        return response(['status' => 'Your password updated successfully.']);
    }
}
