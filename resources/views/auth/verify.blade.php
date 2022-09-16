@extends('layouts.main')

@section('style')
<style>
.bingkai{
    width:70%;
    margin:20px 15%;
}

.box{
    margin:34px 22vw;
}

.text-white{
    font-size: 18px;
}

.font-size{
    font-size:calc(16px + 0.65vw);
}


@media (max-width: 800px) {
    .bingkai{
        width:80%;
        margin:20px 10%;
    }
    .box{
        margin:32px 18vw;
    }
}
</style>
@endsection

@section('title','Verify Email')
@section('site-content')
<div class="container">
    <div class="row">
        <div class="col-md-4" style="margin-top: auto; margin-bottom: auto;">
            <img class="" src="{{ asset('storage/assets/images/verif-email.png') }}" alt="verif-email" width=250px">
        </div>

        <div class="col-md-8">
            <div class="text-left text-white form-style-content" style="padding-top: 70px; padding-bottom: 70px;">
                <p class="font-size">Kami telah mengirimkan email verifikasi pada email yang Anda gunakan untuk mendaftar. Silakan periksa email Anda secara berkala.</p>

                <a href="{{ route('verification.resend') }}" class="text-info font-size"
                   onclick="event.preventDefault(); document.getElementById('email-resend-form').submit();">
                    Klik ini untuk mengirim ulang e-mail verifikasi
                </a>

                {{ Form::open(['route' => 'verification.resend', 'id' => 'email-resend-form', 'style' => 'display:none;']) }}
                {{ Form::close() }}

                <p class="font-size" style="margin-top: 16px; font-weight: bold;">Jika belum mendapatkan email verifikasi, silakan hubungi narahubung kami yang dapat dilihat pada bagian bawah halaman ini.</p>
            </div>
        </div>
    </div>
</div>

@endsection
