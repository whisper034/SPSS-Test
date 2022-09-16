@extends('peserta.dashboard')

@php
    $panduanDownloadURL = route('dashboard-download', ['file' => Crypt::encrypt('PT1')]);
@endphp

@section('dashboard-content')
    <center>
        @if (isset($level) && $level == 'Pengumuman')
            <article class="heading text-white" style="font-size: calc(15px + 2vw);">
                Pengumuman Tahap 1
            </article>
                
            <article class="sub-heading text-white" style="font-size: calc(12px + 1.5vw);">
                Pengumuman tahap 1 <span id="time">00 hari 00 jam 00 menit 00 detik</span> lagi.
            </article>
        @else
            <article class="heading text-white" style="font-size: calc(15px + 2vw);">
                Pembayaran anda berhasil diverifikasi
            </article>
                
            <article class="sub-heading text-white" style="font-size: calc(12px + 1.5vw);">
                Tahap 1 akan dimulai <span id="time">00 hari 00 jam 00 menit 00 detik</span> lagi.
            </article>
                
            <article class="sub-heading text-white" style="font-size: calc(12px + 1.5vw);">
                Silahkan unduh panduan tahap 1 <a href="{{ $panduanDownloadURL }}" class="link">di sini</a>.
            </article>
        @endif
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