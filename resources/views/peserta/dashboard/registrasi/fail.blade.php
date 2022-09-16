@extends('peserta.dashboard')

@section('dashboard-content')
    <center>
        @if (isset($statusPembayaran) && $statusPembayaran == 'late')
            <article class="heading text-white" style="font-size: calc(15px + 2vw);">
                Mohon Maaf, anda tidak dapat lanjut ke tahap 1
            </article>
            <article class="sub-heading text-white" style="font-size: calc(12px + 1.5vw);">
                Anda tidak menyelesaikan proses registrasi sebelum waktu registrasi berakhir.
            </article>
            <article class="sub-heading text-white" style="font-size: calc(12px + 1.5vw);">
                Anda dapat mengikuti SPSS pada tahun berikutnya.
            </article>
        @else
            <article class="heading text-white" style="font-size: calc(15px + 2vw);">
                Pembayaran Anda tidak dapat diverifikasi
            </article>

            <article class="sub-heading text-white" style="font-size: calc(12px + 1.5vw);">
                Silahkan <a href="{{ route('resubmit-pembayaran') }}" class="link">unggah</a> kembali bukti pembayaran Anda.
            </article>
        @endif
    </center>

@endsection
