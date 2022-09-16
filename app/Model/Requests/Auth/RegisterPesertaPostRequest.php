<?php

namespace App\Model\Requests\Auth;

use App\Model\Requests\PostRequest;

class RegisterPesertaPostRequest extends PostRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'email' => ['required', 'string', 'email', 'unique:pesertas'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            'AsalUniversitas' => ['required', 'string'],
            'NamaLengkap' => ['required', 'string'],
            'NoHP' => ['required', 'string'],
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
            'email.required' => 'Alamat Surel tidak boleh kosong',
            'email.email' => 'Format Alamat Surel tidak tepat',
            'email.unique' => 'Terdapat akun yang memiliki alamat surel yang sama',

            'password.required' => 'Kata Sandi tidak boleh kosong',
            'password.min' => 'Kata Sandi minimal memiliki 8 karakter',
            'password.confirmed' => 'Kata Sandi konfirmasi tidak sama',

            'AsalUniversitas.required' => 'Asal Universitas tidak boleh kosong',

            'NamaLengkap.required' => 'Nama Lengkap tidak boleh kosong',

            'NoHP.required' => 'No. HP tidak boleh kosong',
        ];
    }
}