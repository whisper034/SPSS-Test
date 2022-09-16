@extends('layouts.admin')

@section('style')
<style>
    .form-control > option {
        background-color: rgb(43, 53, 83);
    }

    #adminTable th {
        white-space: nowrap;
    }

    #adminTable td {
        white-space: nowrap;
    }
</style>
@endsection

@section('title', 'User Management')

@section('site-content')
@isset($user)
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="title">
                        @if ($user['id'] == 0) Create @else Update @endif User
                    </h4>
                </div>

                <div class="card-body">
                    {{ Form::open(['route' => 'store-admin']) }}
                    {{ Form::hidden('id', $user['id']) }}
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    {{ Form::label('email', 'Email Address') }}
                                    {{ Form::email('email', is_null(old('email')) ? $user['email'] : old('email'), [
                                        'class' => 'form-control '.($errors->has('email') ? 'is-invalid' : ''),
                                        ''.(($user['id'] > 0) ? 'disabled' : '')
                                     ]) }}
                                    @error('email')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    {{ Form::label('name', 'Name') }}
                                    {{ Form::text('name', is_null(old('name')) ? $user['name'] : old('name'),
                                     ['class' => 'form-control '.($errors->has('name') ? 'is-invalid' : '')]) }}
                                    @error('name')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    {{ Form::label('role_id', 'Role') }}
                                    {{ Form::select('role_id', $roles, is_null(old('role_id')) ? $user['role_id'] : old('role_id'),[
                                        'class' => 'form-control '.($errors->has('role_id') ? 'is-invalid' : ''), 
                                        'placeholder' => '--Choose Role--'
                                    ]) }}
                                    @error('role_id')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        @if ($user['id'] == 0)
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    {{ Form::label('password', 'Initial Password') }}
                                    {{ Form::password('password', ['class' => 'form-control '.($errors->has('password') ? 'is-invalid' : '')]) }}
                                    @error('password')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    {{ Form::label('password_confirmation', 'Confirm Password') }}
                                    {{ Form::password('password_confirmation', ['class' => 'form-control']) }}
                                </div>
                            </div>
                        </div>
                        @endif
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    {{ Form::submit(($user['id'] > 0) ? 'Update' : 'Create', 
                                        ['class' => 'btn btn-fill btn-primary']) }}
                                    <a href="/admin/user" class="btn btn-fill btn-danger">Cancel</a>
                                </div>
                            </div>
                        </div>
                    {{ Form::close() }}
                </div>
            </div>
        </div>
    </div>
@endisset
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title">Admin List</h4>
            </div>
            <div class="card-body">
                <a href="/admin/user/0" class="btn btn-fill btn-info mr-2">New User</a>
                <table class="table" id="adminTable">
                    <thead class="text-primary">
                        <tr>
                            <th>ID</th>
                            <th>Email</th>
                            <th>Name</th>
                            <th>Role</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($users as $item)
                            <tr>
                                <td>{{ $item['id'] }}</td>
                                <td>{{ $item['email'] }}</td>
                                <td>{{ $item['name'] }}</td>
                                <td>{{ $item['role'] }}</td>
                                <td>
                                    <a type="button" rel="tooltip" class="btn btn-info btn-sm btn-icon" href="/admin/user/{{ $item['id'] }}">
                                        <i class="far fa-edit"></i>
                                    </a>
                                    @php
                                        $modalId = 'deleteModal-'.$item['id'];
                                    @endphp
                                    <button type="button" rel="tooltip" class="btn btn-danger btn-sm btn-icon" data-toggle="modal" data-target="#{{ $modalId }}">
                                        <i class="fas fa-times"></i>
                                    </button>
                                    @include('components.modal.admin.deleteUser', [
                                        'modalId' => $modalId,
                                        'adminId' => $item['id']
                                    ])
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection

@section('script')
<script>
    $(document).ready(function () {
        var table = $('#adminTable').DataTable({
            "language": {
                "paginate": {
                    "previous": "&lt;",
                    "next": "&gt;"
                }
            },
            "paging": false,
            "ordering": false,
            "searching": false,
            "info": false,
            "sScrollXInner": "100%",
            "sScrollX": "100%",
            "bAutoWidth": true,
        });
    });
</script>
@endsection