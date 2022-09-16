<?php

namespace App\Repository\Repositories;

use App\Repository\Base\BaseRepository;
use App\Repository\Contracts\IPesertaRepository;
use App\Model\DB\Peserta;
use Illuminate\Support\Facades\DB;

class PesertaRepository extends BaseRepository implements IPesertaRepository
{
    public function __construct() {
        parent::__construct(new Peserta());
    }

    public function FindByEmail($email)
    {
        return Peserta::where('email', '=', $email)->first();
    }

    public function FindAllByTahapJoinJawabanAndJoinDetailPeserta($tahap_id)
    {
        return DB::table('pesertas')
                 ->leftJoin('jawabans', function ($join) use ($tahap_id)
                 {
                     $join->on('pesertas.id', '=', 'jawabans.peserta_id')
                          ->where('jawabans.tahap_id', '=', $tahap_id);
                 })
                 ->join('detail_pesertas', 'pesertas.id', '=', 'detail_pesertas.peserta_id')
                 ->where('pesertas.tahap_id', '=', $tahap_id)
                 ->select(
                    'pesertas.KodePeserta',
                    'detail_pesertas.Nama',
                    'jawabans.FileName',
                    'jawabans.FileSubmit',
                    'jawabans.WaktuSubmit',
                    'jawabans.WaktuFinalisasi'
                 )
                 ->get();
    }

    public function FindByJawaban($jawaban_id)
    {
        return DB::table('pesertas')
                 ->join('jawabans', 'pesertas.id', '=', 'jawabans.peserta_id')
                 ->where('jawabans.id', '=', $jawaban_id)
                 ->select('pesertas.*')
                 ->first();
    }

    public function FindAllWhereInByKodePeserta($kode_pesertas)
    {
        return Peserta::whereIn('KodePeserta', $kode_pesertas)->get();
    }

    public function FindAllWhereEmailVerifiedAtNotNull()
    {
        return Peserta::whereNotNull('email_verified_at')->get();
    }
}