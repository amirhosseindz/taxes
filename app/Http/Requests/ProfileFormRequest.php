<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProfileFormRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $user = \Auth::user();
        $routeName = $this->route()->getName();

        switch ($routeName) {
            case 'profile.info':
                return [
                    'name' => 'required|max:255',
                    'email' => 'required|email|max:255|unique:users,email,' . $user->id
                ];
            case 'profile.pass':
                return [
                    'old_password' => 'required|old_password:' . $user->password,
                    'new_password' => 'required|min:6',
                    'password_confirmation' => 'required|min:6|same:new_password'
                ];
            default:
                return [];
        }
    }
}
