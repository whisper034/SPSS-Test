<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">

    <link href="https://fonts.googleapis.com/css?family=Poppins:200,300,400,600,700,800" rel="stylesheet" />
    <link href="https://use.fontawesome.com/releases/v5.0.6/css/all.css" rel="stylesheet">
    <link href="{{ asset('css/nucleo-icons.css') }}" rel="stylesheet" />
    <link href="{{ asset('css/black-dashboard.min.css?v=1.0.0') }}" rel="stylesheet" />

    <title>Admin - Login</title>
</head>
<body>
    <div class="container">
        <div class="text-center" style="margin:3rem auto; max-width:300px;">
            <h2>Sign In</h2>
            {{ Form::open(['route' => 'admin-login'])  }}
                <div class="form-group">
                    {{ Form::label('email', 'Email Address') }}
                    {{ Form::email('email', old('email'), ['class' => 'form-control '.($errors->has('email') ? 'is-invalid' : ''), 'placeholder' => 'Email Address', 'autofocus' => '']) }}
                    @error('email')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
                <div class="form-group">
                    {{ Form::label('password', 'Password') }}
                    {{ Form::password('password', ['class' => 'form-control '.($errors->has('password') ? 'is-invalid' : ''), 'placeholder' => 'Password']) }}
                    @error('password')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
                <div class="form-group">
                    {{ Form::submit('Sign In', ['class' => 'btn btn-fill btn-primary']) }}
                </div>
            {{ Form::close() }}
            <a href="/">Back to Main Site</a>
            <p>&copy; 2020 HIMSTAT BINUS</p>
        </div>
    </div>
</body>
</html>