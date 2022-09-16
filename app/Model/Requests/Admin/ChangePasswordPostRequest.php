<?php

namespace App\Model\Requests\Admin;

use App\Model\Requests\Auth\ChangePasswordPostRequest as BaseChangePasswordRequest;

class ChangePasswordPostRequest extends BaseChangePasswordRequest
{
    protected $errorBag = 'password';

    protected $passwordNotMatchErrorMessage = 'Old Password did not match';

    /**
     * Get the error messages for the defined validation rules.
     *
     * @return array
     */
    public function messages()
    {
        return [
            'old_password.required' => 'Old Password must not be empty',

            'password.required' => 'New Password must not be empty',
            'password.min' => 'New Password must have at least 8 characters',
            'password.confirmed' => 'Confirmation Password did not match',
            'password.different' => 'New Password must not match old password',
        ];
    }
}
