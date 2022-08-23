<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RegisterRequest extends FormRequest
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
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'firstname' => 'required|string|between:2,100',
            'email' => 'required|string|email|max:100|unique:users',
            'lastname' => 'required|string|between:2,100',
            'password' => 'required|string|between:2,100',
            // 'password' => 'required|string|confirmed|between:2,100',
            'pin' => 'required|integer|digits:4',
        ];
    }
}
// $table->string('firstname');
// $table->string('email')->unique();
// $table->string('password');
// $table->string('lastname');
// $table->string('pin');