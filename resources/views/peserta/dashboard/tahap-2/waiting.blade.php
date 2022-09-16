@extends('peserta.dashboard')

@php
    $panduanDownloadURL = route('dashboard-download', ['file' => Crypt::encrypt('PT2')]);
@endphp

@section('dashboard-content')
    <center>
        @if (isset($level) && $level == 'Pengumuman')
            <article class="heading text-white" style="font-size: calc(15px + 2vw);">
                Pengumuman Tahap 2
            </article>
                
            <article class="sub-heading text-white" style="font-size: calc(12px + 1.5vw);">
                Pengumuman tahap 2 <span id="time">00 hari 00 jam 00 menit 00 detik</span> lagi.
            </article>
        @elseif (isset($level) && $level == 'Menunggu Babak')
            <article class="heading text-white" style="font-size: calc(15px + 2vw);">
                Selamat ! Anda lolos ke tahap 2
            </article>
            
            <article class="sub-heading text-white" style="font-size: calc(12px + 1.5vw);">
                Tahap 2 akan dimulai <span id="time">00 hari 00 jam 00 menit 00 detik</span> lagi.
            </article>
            
            <article class="sub-heading text-white" style="font-size: calc(12px + 1.5vw);">
                Silahkan unduh panduan tahap 2 <a href="{{ $panduanDownloadURL }}" class="link">disini</a>.
            </article>
        @else
            <article class="heading text-white" style="font-size: calc(15px + 2vw);">
                Pengumuman Tahap 1
            </article>
                
            <article class="sub-heading text-white" style="font-size: calc(12px + 1.5vw);">
                Pengumuman tahap 1 <span id="time">00 hari 00 jam 00 menit 00 detik</span> lagi.
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