@extends('peserta.dashboard')

@php
    $panduanDownloadURL = route('dashboard-download', ['file' => Crypt::encrypt('PT1')]);
@endphp

@section('dashboard-content')
<center>
    <article class="heading text-white" style="font-size: calc(15px + 2vw);">
        Pembayaran Anda berhasil diverifikasi
    </article>

    <article class="sub-heading text-white" style="font-size: calc(12px + 1.5vw);">
        Tahap 1 akan dimulai <span id="time">00 hari 00 jam 00 menit 00 detik</span> lagi.
    </article>

    <article class="sub-heading text-white" style="font-size: calc(12px + 1.5vw);">
        Silahkan unduh panduan tahap 1 <a href="{{ $panduanDownloadURL }}" class="link"><img src="{{ asset('storage/assets/images/download-icon.png') }}" alt="download-icon" width="22px"></a>.
    </article>
</center>
@endsection

@section('script')
<script>
    $(document).ready(function () {
        var date = new Date({{ $countdown }});
        Countdown.doCountdown(Countdown.format.dashboard, 'time', date);
    });
</script>
@endsection
