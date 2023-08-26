<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CheckoutRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        $emailValidation = auth()->user() ? 'required|email' : 'required|email|unique:users' ;

        return [
            'email'=>$emailValidation,
            'name'=> 'required',
            'address'=> 'required',
            'city'=> 'required',
            'province'=> 'required',
            'postalcode'=> 'required',
            'phone'=> 'required',
        ];


    }

    public function messages()
    {
        return[
            'email.unique' => "You already have an account with this email address. Please <a href='/login'>login</a> to continue."
        ];
    }
}
