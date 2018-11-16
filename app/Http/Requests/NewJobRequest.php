<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class NewJobRequest extends FormRequest
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
            'title' => 'required',
            'description' => 'required',
            'email' => 'required|email'
        ];
    }

    /**
     * Return arrat of validation messages
     * @return array Validation messages
     */
    public function messages()
    {
        return [];
    }
}
