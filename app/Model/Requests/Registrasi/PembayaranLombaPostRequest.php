<?php

namespace App\Model\Requests\Registrasi;

use App\Model\Requests\PostRequest;

class PembayaranLombaPostRequest extends PostRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'NamaPengirim' => ['required', 'string', 'max:255'],
            'NamaBank' => ['required', 'string', 'max:255'],
            'BuktiTransfer' => ['required', 'file', 'image', 'max:3999', 'mimes:jpg,jpeg'],
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
            'NamaPengirim.required' => 'Nama Pengirim tidak boleh kosong',
            'NamaPengirim.max' => 'Nama Pengirim tidak boleh melebihi 255 karakter',

            'NamaBank.required' => 'Nama Bank tidak boleh kosong',
            'NamaBank.max' => 'Nama Bank tidak boleh melebihi 255 karakter',

            'BuktiTransfer.required' => 'Bukti Transfer tidak boleh kosong',
            'BuktiTransfer.file' => 'Bukti Transfer harus berupa file',
            'BuktiTransfer.image' => 'Bukti Transfer harus berupa gambar',
            'BuktiTransfer.max' => 'Ukuran gambar tidak boleh melebihi :max kilobytes',
            'BuktiTransfer.mimes' => 'Bukti Transfer harus memiliki format .jpg',
        ];
    }
}