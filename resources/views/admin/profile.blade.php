@extends('layouts.admin')

@section('title', 'Profile')

@section('site-content')
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title">Profil Admin</h4>
            </div>
            <div class="card-body">
                {{ Form::open(['route' => 'update-admin-profile']) }}
                {{ Form::hidden('id', $admin['id']) }}
                {{ Form::hidden('role_id', $admin['role_id']) }}
                    <div class="form-group row">
                        {{ Form::label('name', 'Name', ['class' => 'col-form-label col-sm-2']) }}
                        <div class="col-sm-10">
                            {{ Form::text('name', is_null(old('name')) ? $admin['name'] : old('name'), 
                                ['class' => 'form-control '.($errors->profile->has('name') ? 'is-invalid' : '')]) 
                            }}
                            @error('name', 'profile')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>
                    <div class="form-group row">
                        {{ Form::label('email', 'Email', ['class' => 'col-form-label col-sm-2']) }}
                        <div class="col-sm-10">
                            {{ Form::email('email', $admin['email'], ['class' => 'form-control', 'disabled']) }}
                        </div>
                    </div>
                    <div class="form-group row">
                        {{ Form::label('role', 'Role', ['class' => 'col-form-label col-sm-2']) }}
                        <div class="col-sm-10">
                            {{ Form::text('role', $admin['role'], ['class' => 'form-control', 'disabled']) }}
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-sm-10">
                            {{ Form::submit('Update', ['class' => 'btn btn-success']) }}
                        </div>
                    </div>
                {{ Form::close() }}
            </div>
        </div>
    </div>
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title">Ubah Password</h4>
            </div>
            <div class="card-body">
                {{ Form::open(['route' => 'admin-change-password']) }}
                    <div class="form-group row">
                        {{ Form::label('old_password', 'Old Password', ['class' => 'col-form-label col-sm-2']) }}
                        <div class="col-sm-10">
                            {{ Form::password('old_password', ['class' => 'form-control '.($errors->password->has('old_password') ? 'is-invalid' : '')]) }}
                            @error('old_password', 'password')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>
                    <div class="form-group row">
                        {{ Form::label('password', 'New Password', ['class' => 'col-form-label col-sm-2']) }}
                        <div class="col-sm-10">
                            {{ Form::password('password', ['class' => 'form-control '.($errors->password->has('password') ? 'is-invalid' : '')]) }}
                            @error('password', 'password')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>
                    <div class="form-group row">
                        {{ Form::label('password_confirmation', 'Confirm New Password', ['class' => 'col-form-label col-sm-2']) }}
                        <div class="col-sm-10">
                            {{ Form::password('password_confirmation', ['class' => 'form-control']) }}
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-sm-10">
                            {{ Form::submit('Change', ['class' => 'btn btn-success']) }}
                        </div>
                    </div>
                {{ Form::close() }}
            </div>
        </div>
    </div>
</div>
@endsection