<?php

namespace App\Model\Requests\Lomba;

use App\Model\Requests\PostRequest;
use App\Service\Contracts\ILombaService;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;

class FinaliseAnswerPostRequest extends PostRequest
{
    protected $errorBag = 'finalise';
    
    private $lombaService;

    public function __construct(ILombaService $lombaService) {
        $this->lombaService = $lombaService;
    }
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $invalidFinaliseTokenMessage = $this->invalidFinaliseTokenMessage;
        return [
            'FinaliseToken' => ['required' ,'string', 
                function ($attribute, $value, $fail) use ($invalidFinaliseTokenMessage){
                    try {
                        $decryptedToken = Crypt::decrypt($value);

                        $tokenPart = explode('+', $decryptedToken);
                        
                        if (count($tokenPart) != 3)
                            throw new \Exception();

                        $peserta = Auth::user();
                        
                        if ($tokenPart[0] != $peserta->tahap_id)
                            throw new \Exception();
                        
                        if ($tokenPart[1] != $peserta->KodePeserta)
                            throw new \Exception();

                        $jawaban = $this->lombaService->GetJawabanByPesertaAndTahap($peserta->id, $peserta->tahap_id);
                        $timestampSubmit = $jawaban->WaktuSubmit->timestamp;

                        if ($tokenPart[2] !== (string) $timestampSubmit)
                            throw new \Exception();
                    } catch (\Exception $e) {
                        $fail($invalidFinaliseTokenMessage);
                    }
                }
            ],
        ];
    }

    private $invalidFinaliseTokenMessage = 'Terjadi kesalahan saat memverifikasi token. Mohon finalisasi jawaban kembali.';

    /**
     * Get the error messages for the defined validation rules.
     *
     * @return array
     */
    public function messages()
    {
        return [
            'FinaliseToken.required' => $this->invalidFinaliseTokenMessages,
            'FinaliseToken.string' => $this->invalidFinaliseTokenMessages,
        ];
    }
}