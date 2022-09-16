<?php

namespace App\Model\Requests\Auth;

use App\Model\Requests\PostRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class ChangePasswordPostRequest extends PostRequest
{
    protected $passwordNotMatchErrorMessage = 'Kata sandi lama tidak sesuai';
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $passwordNotMatchErrorMessage = $this->passwordNotMatchErrorMessage;
        return [
            'old_password' => ['required', 'string', function ($attribute, $value, $fail)
                use ($passwordNotMatchErrorMessage)
            {
                    $user = Auth::user();
                    if (!Hash::check($value, $user->password)){
                        $fail($passwordNotMatchErrorMessage);
                    }
                },
            ],
            'password' => ['required', 'string', 'min:8', 'confirmed', 'different:old_password'],
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
            'old_password.required' => 'Kata sandi lama tidak boleh kosong',

            'password.required' => 'Kata sandi baru tidak boleh kosong',
            'password.min' => 'Kata sandi baru minimal memiliki 8 karakter',
            'password.confirmed' => 'Kata sandi konfirmasi baru tidak sama',
            'password.different' => 'Kata sandi baru tidak boleh sama dengan kata sandi lama',
        ];
    }
}