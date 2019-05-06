<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CountyFormRequest extends FormRequest
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
                    'name' => 'required|string|max:191',
                    'state_id' => 'required|integer|exists:states,id',
                    'tax_rate' => 'required|numeric|min:0|max:99.99',
                    'collected_taxes' => 'required|numeric|min:0'
                ];
            case 'DELETE':
                return [];
        }
    }
}
