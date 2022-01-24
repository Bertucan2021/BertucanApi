<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreMembershipRequest extends FormRequest
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
            'name' => ['required', 'max:30'],
            'type' => ['required'],
            'show_ad' => ['required'],
            'add_per_minute' => ['required'],
            'allowed_add_per_month' => ['required'],

        ];
    }

    public function messages(){
        return [
            'name.required' => 'Name of the memebrship is required.',
            'name.max' => 'Maximum number of characters for membership name is 30.',
            'type.required' => 'Type of the memebrship is required.',
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
