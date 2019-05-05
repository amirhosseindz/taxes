<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StateFormRequest extends FormRequest
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
        switch ($this->method()) {
            case 'POST':
            case 'PUT':
            case 'PATCH':
                return [
                    'name' => 'required|string|max:191'
                ];
            case 'DELETE':
                return [];
        }
    }
}
