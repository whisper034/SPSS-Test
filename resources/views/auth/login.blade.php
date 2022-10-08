@extends('layouts.main')

@section('style')
    <style>
        .text-masuk {
            font-size: 40px;
            color: white;
            font-weight: bold;
            margin-top: 20px;
        }

        .btn-masuk{
            margin: 0 10px 0 0;
            width: 120px;
        }

        @media (max-width: 768px) {
            .login-form {
            }

            .form-style {
                margin: 0;
            }

            .split-img {
                transform: rotate(90deg);
                margin-top: -100px;
                margin-bottom: -100px;
            }
        }

        @media (max-width: 500px) {
            .text-masuk {
                font-size: 40px;
                color: white;
                font-weight: bold;
            }

            .btn-masuk{
                width:80px;
            }
        }

        @media (max-width: 440px) {
            .btn-masuk{
                width:100%;
                margin-bottom:12px;
            }
        }
    </style>
@endsection

@section('title', 'Login')

@section('site-content')
    <div class="" style="">
        <div class="container">
            <div class="form-style login-form">
                <div class="text-masuk">
                    <span>Masuk</span>
                </div>

                <div class="form-style-content" style="margin-top: auto; margin-bottom: auto;">
                    {{ Form::open(['route' => 'login', 'id' => 'loginForm']) }}
                    <div class="row">
                        <div class="col-md-7">
                            <div class="form-group">
                                <span style="color: #94bccf; font-weight: normal; margin-bottom: 10px; margin-top: 20px;"><i>E-mail</i> Terdaftar</span>
                                {{ Form::email('email', @old('email'), ['class' => 'form-control '.($errors->has('email') ? 'is-invalid' : ''), 'placeholder' => 'Masukkan Alamat E-mail', 'autofocus' => '']) }}
                                @error('email')
                                <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                                @enderror
                            </div>

                            <div class="form-group">
                                <span style="color: #94bccf; font-weight: normal; margin-bottom: 10px; margin-top: 20px;">Kata Sandi</span>
                                {{ Form::password('password', ['class' => 'form-control '.($errors->has('password') ? 'is-invalid' : ''), 'placeholder' => 'Masukkan Kata Sandi', 'autocomplete' => 'current-password']) }}
                                @error('password')
                                <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                                @enderror
                            </div>

                            <div class="text-right">
                                <a href="{{ route('password.request') }}" class="" style="color: #4ecdfc;">Lupa Kata Sandi</a>
                            </div>

                            <div>
                                <button class="btn btn-outline-info fit-content-btn btn-masuk" type="submit">Masuk</button>
                            </div>
                        </div>

                        <div class="form-style-content col-md-2" style="text-align: center; margin-top: auto; margin-bottom: auto;">
                            <img src="{{ asset('storage/assets/images/login-split.png') }}" alt="login-split" class="split-img">
                        </div>

                        <div class=" form-style-content col-md-3" style="text-align: center; margin-top: auto; margin-bottom: auto;">
                            <span class="text-white" style="font-weight: bold; font-size: 22px;">Belum punya akun?</span>
                            <br>
                            <a href="/register" class="" style="font-weight: bold; color: #4ecdfc; font-size: 22px;">Daftar</a>
                        </div>
                    </div>
                    {{ Form::close() }}
                </div>
            </div>
        </div>
    </div>
@endsection
