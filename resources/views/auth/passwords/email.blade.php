@extends('layouts.main')

@section('title', 'Forgot Password')

@section('site-content')
    <div class="container">

        <div class="form-style" style="margin-top: 50px;; margin-bottom: 50px;">
            <div class="form-style-heading">
                Lupa Kata Sandi
            </div>
            <div class="form-style-content">
                {{ Form::open(['route' => 'password.email']) }}
                <div class="form-group">
                    <span class="text-white" style="font-weight: 500;">Masukkan alamat <i>e-mail</i> Anda supaya kami dapat mengirimkan <i>e-mail</i> untuk menyetel ulang kata sandi Anda.</span>
                </div>
                <div class="form-group">
                    {{ Form::email('email', old('email'), ['class' => 'form-control '.($errors->has('email') ? 'is-invalid' : ''), 'placeholder' => 'Masukkan Alamat E-Mail', 'autofocus' => '']) }}
                    @error('email')
                    <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
                <div class="text-white">
                    Ingat kata sandi? <a href="{{ route('login') }}" class="text-info">Masuk</a>
                </div>
                <div class="text-right">
                    {{ Form::submit('Kirim', ['class' => 'btn btn-outline-info fit-content-btn', 'style' => 'margin:20px 0; min-width: 120px;']) }}
                </div>
                {{ Form::close() }}
            </div>
        </div>
    </div>
@endsection
