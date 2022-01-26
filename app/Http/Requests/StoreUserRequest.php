<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreUserRequest extends FormRequest
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
        return [
            'first_name' => ['required','max:20'],
            'last_name' => ['required','max:20'],
            'email' => ['required','max:255'],
            'password' => ['required','max:12'],
            'phone_number' => ['max:30'], 
            'birthdate' => ['max:15']
        ];
    }

    public function messages(){
        return [
            'first_name.required' => 'First Name of the user is required.',
            'last_name.required' => 'Last Name of the user is required.',
            'email.required' => 'Email of the user is required.',
            'password.required' => 'Password of the user is required.',
            
        ];
    }

    /**
     *  Filters to be applied to the input.
     *
     * @return array
     */
    public function filters()
    {
        return [
            'type' => 'trim|capitalize',
            'name' => 'trim|capitalize|escape'
        ];
    }

}
