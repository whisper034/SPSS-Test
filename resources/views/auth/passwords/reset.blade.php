@extends('layouts.main')

@section('title', 'Forgot Password')

@section('site-content')
<div class="container">
    <div class="fit-banner text-center">
        <img src="{{ asset('storage/assets/logos/spss-logo.png') }}">
    </div>

    <div class="form-style" style="margin: 24px auto">
        <div class="form-style-heading">
            <span class="heading text-white" style="font-size: calc(10px + 3vw);">Ubah Kata Sandi</span>
        </div>
        <div class="form-style-content">
            {{ Form::open(['route' => 'password.update']) }}
            {{ Form::hidden('token', $token) }}
            <div class="form-group">
                {{ Form::email('email', $email ?? old('email'), ['class' => 'form-control '.($errors->has('email') ? 'is-invalid' : ''), 'placeholder' => 'Masukkan alamat surel', 'autofocus' => '']) }}
                @error('email')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>
            <div class="form-group">
                {{ Form::password('password', ['class' => 'form-control '.($errors->has('password') ? 'is-invalid' : ''), 'placeholder' => 'Masukkan kata sandi baru']) }}
                @error('password')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>
            <div class="form-group">
                {{ Form::password('password_confirmation', ['class' => 'form-control', 'placeholder' => 'Ulangi kata sandi baru']) }}
            </div>
                <div class="text-right" style="margin-top: 24px;">
                    {{ Form::submit('Ubah', ['class' => 'btn btn-outline-info fit-content-btn', 'style' => 'margin:0;']) }}
                </div>
            {{ Form::close() }}
        </div>
    </div>
</div>
@endsection
