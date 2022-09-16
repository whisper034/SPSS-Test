@extends('layouts.main')

@section('style')
<style>
.container{
    margin-top:6vw;
    margin-bottom:8vw;
}

.btn-daftar{
    margin:0;
    width:160px;
    margin-right:2vw;
}

.form-group{
    margin-bottom:32px;
}

.heading{
    font-size: calc(18px + 2.5vw);
}

.btn-outline-info-2 {
    color: #ffb2b2;
    border-color: #ffb2b2;
}

.btn-outline-info-2:hover {
    color: #d01419;
    background-color: #ffb2b2;
    border-color: #ffb2b2;
}

@media (max-width: 680px){
    .btn-daftar{
        width:calc(100% - 4vw);
        margin: 0 2vw;
    }
}
</style>
@endsection

@section('title','Change Password')

@section('site-content')
<div class="container">
    <div class="row">
        <div class="col-md-4 text-center" style="margin-top: auto; margin-bottom: auto;">
            <img src="{{ asset('storage/assets/images/lock.png') }}" alt="lock" height="300px">
        </div>

        <div class="form-style col-md-8" style="">
            <div class="form-style-content">
                {{ Form::open(['route' => 'change-password']) }}
                <div class="form-group">
                    <span style="color: #94bccf; font-weight: normal; margin-bottom: 10px;">Kata Sandi Lama</span>
                    {{ Form::password('old_password', ['class' => 'form-control '.($errors->has('old_password') ? 'is-invalid' : ''), 'placeholder' => 'Masukkan kata sandi yang lama', 'autofocus' => '']) }}
                    @error('old_password')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                </div>

                <div class="form-group">
                    <span style="color: #94bccf; font-weight: normal; margin-bottom: 10px; margin-top: 20px;">Kata Sandi Baru</span>
                    {{ Form::password('password', ['class' => 'form-control '.($errors->has('password') ? 'is-invalid' : ''), 'placeholder' => 'Masukkan kata sandi yang baru']) }}
                    @error('password')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                </div>

                <div class="form-group">
                    <span style="color: #94bccf; font-weight: normal; margin-bottom: 10px; margin-top: 20px;">Ulangi Kata Sandi Baru</span>
                    {{ Form::password('password_confirmation', ['class' => 'form-control', 'placeholder' => 'Masukkan kembali kata sandi yang baru']) }}
                </div>
                <div class="text-right" style="margin-top: 42px;">
                    {{ Form::submit('Ubah', ['class' => 'btn btn-outline-info-2 fit-content-btn', 'style' => 'margin:0; width:168px;']) }}
                </div>
                {{ Form::close() }}
            </div>
        </div>
    </div>
</div>
@endsection
