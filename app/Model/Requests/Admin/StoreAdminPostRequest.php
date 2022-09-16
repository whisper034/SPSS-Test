<?php

namespace App\Model\Requests\Admin;

use App\Model\Requests\PostRequest;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class StoreAdminPostRequest extends PostRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'id' => ['required'],
            'email' => ['sometimes', 'required', 'string', 'email', 'unique:admins'],
            'name' => ['required', 'string'],
            'role_id' => ['required', 'integer'],
            'password' => ['sometimes', 'required', 'string', 'min:8', 'confirmed'],
        ];
    }

    /**
     * Get the error messages for the defined validation rules.
     *
     * @return array
     */
    public function messages()
    {
        return [
            'email.required' => 'Email must not be empty',
            'email.email' => 'Email must be a valid address',
            'email.unique' => 'There is an existing admin with that email',

            'name.required' => 'Name must not be empty',

            'role_id.required' => 'Role must not be empty',

            'password.required' => 'Password must not be empty',
            'password.min' => 'Password must have at least :min characters',
            'password.confirmed' => 'Confirmation password does not match',
        ];
    }
}
