@extends('layouts.main')

@section('style')
    <style>
        .form-style-heading{
            font-size: 48px;
        }

        @media (max-width: 768px) {
            .form-style {
                margin: 0;
            }

            .split-img {
                transform: rotate(90deg);
                margin-top: -100px;
                margin-bottom: -100px;
            }
        }

        @media (max-width: 700px) {
            .form-style-heading{
                font-size: 28px;
            }
        }
    </style>
@endsection

@section('title', 'Register')

@section('site-content')
    <div class="">
        <div class="container">
            <div class="form-style register-form">
                <div style="font-size: 40px; color: white; font-weight: bold; margin-top: 20px;">
                    <span>Daftar</span>
                </div>

                <div class="form-style-content">
                    {{ Form::open(['route' => 'register']) }}
                    <div class="row">
                        <div class="col-md-7">
                            <div class="form-group">
                                <span style="color: #94bccf; font-weight: normal; margin-bottom: 10px; margin-top: 20px;">Nama Lengkap</span>
                                {{ Form::text('NamaLengkap', old('NamaLengkap'), ['class' => 'form-control '.($errors->has('NamaLengkap') ? 'is-invalid' : ''), 'placeholder' => 'Nama Lengkap', 'autofocus' => '']) }}
                                @error('NamaLengkap')
                                <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                                @enderror
                            </div>

                            <div class="form-group">
                                <span style="color: #94bccf; font-weight: normal; margin-bottom: 10px; margin-top: 20px;">Alamat <i>E-Mail</i></span>
                                {{ Form::email('email', old('email'), ['class' => 'form-control '.($errors->has('email') ? 'is-invalid' : ''), 'placeholder' => 'Alamat E-Mail']) }}
                                @error('email')
                                <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                                @enderror
                            </div>

                            <div class="form-group">
                                <span style="color: #94bccf; font-weight: normal; margin-bottom: 10px; margin-top: 20px;">Asal Universitas</span>
                                {{ Form::text('AsalUniversitas', old('AsalUniversitas'), ['class' => 'form-control '.($errors->has('AsalUniversitas') ? 'is-invalid' : ''), 'placeholder' => 'Universitas Asal']) }}
                                @error('AsalUniversitas')
                                <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                                @enderror
                            </div>

                            <div class="form-group">
                                <span style="color: #94bccf; font-weight: normal; margin-bottom: 10px; margin-top: 20px;">Nomor Telepon</span>
                                {{ Form::text('NoHP', old('NoHP'), ['class' => 'form-control '.($errors->has('NoHP') ? 'is-invalid' : ''), 'placeholder' => 'Nomor Telepon']) }}
                                @error('NoHP')
                                <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                                @enderror
                            </div>

                            <div class="form-group">
                                <span style="color: #94bccf; font-weight: normal; margin-bottom: 10px; margin-top: 20px;">Buat Kata Sandi</span>
                                {{ Form::password('password', ['class' => 'form-control '.($errors->has('password') ? 'is-invalid' : ''), 'placeholder' => 'Buat Kata Sandi']) }}
                                @error('password')
                                <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                                @enderror
                            </div>

                            <div class="form-group">
                                <span style="color: #94bccf; font-weight: normal; margin-bottom: 10px; margin-top: 20px;">Masukkan Ulang Kata Sandi</span>
                                {{ Form::password('password_confirmation', ['class' => 'form-control', 'placeholder' => 'Masukkan Ulang Kata Sandi']) }}
                            </div>

                            <div class="text-right" style="margin-top: 24px;">
                                {{ Form::submit('Daftar', ['class' => 'btn btn-outline-info fit-content-btn', 'style' => 'margin:0; width:140px;']) }}
                            </div>
                        </div>

                        <div class="form-style-content col-md-2" style="text-align: center; margin-top: auto; margin-bottom: auto;">
                            <img src="{{ asset('storage/assets/images/login-split.png') }}" alt="login-split" class="split-img">
                        </div>

                        <div class="col-md-3" style="text-align: center; margin-top: auto; margin-bottom: auto;">
                            <div>
                                <span class="text-white" style="font-weight: bold; font-size: 22px;">Sudah punya akun?</span>
                                <br>
                                <a href="{{ route('login') }}" class="text-info" style="font-weight: bold; color: #4ecdfc; font-size: 22px;">Masuk</a>
                            </div>
                        </div>
                    </div>
                    {{ Form::close() }}
                </div>
            </div>
        </div>
    </div>
@endsection
