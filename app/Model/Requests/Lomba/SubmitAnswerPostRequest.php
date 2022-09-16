<?php

namespace App\Model\Requests\Lomba;

use App\Model\Requests\PostRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;

class SubmitAnswerPostRequest extends PostRequest
{
    protected $errorBag = 'submit';
    
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $invalidSubmitTokenMessage = $this->invalidSubmitTokenMessage;
        return [
            'SubmitToken' => ['required', 'string', 
                function ($attribute, $value, $fail) use ($invalidSubmitTokenMessage){
                    try {
                        $decryptedToken = Crypt::decrypt($value);

                        $tokenPart = explode('+', $decryptedToken);
                        if (count($tokenPart) != 2)
                            throw new \Exception();

                        $peserta = Auth::user();
                        
                        if ($tokenPart[0] != $peserta->tahap_id)
                            throw new \Exception();
                        
                        if ($tokenPart[1] != $peserta->KodePeserta)
                            throw new \Exception();
                    } catch (\Exception $e) {
                        $fail($invalidSubmitTokenMessage);
                    }
                }
            ],
            'FileSubmit' => ['required', 'file', 'mimes:pdf,doc,docx,zip']
        ];
    }

    private $invalidSubmitTokenMessage = 'Terjadi kesalahan saat memverifikasi token. Mohon unggah jawaban kembali.';

    /**
     * Get the error messages for the defined validation rules.
     *
     * @return array
     */
    public function messages()
    {
        return [
            'SubmitToken.required' => $this->invalidSubmitTokenMessages,
            'SubmitToken.string' => $this->invalidSubmitTokenMessages,

            'FileSubmit.required' => 'Jawaban unggahan tidak boleh kosong',
            'FileSubmit.string' => 'Jawaban unggahan harus berupa file',
            'FileSubmit.mimes' => 'Jawaban unggahan tidak sesuai format yang diminta',
        ];
    }
}