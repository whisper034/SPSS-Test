@extends('layouts.admin')

@section('title', 'Timeline')

@section('site-content')
@isset($timeline)
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="title">Edit Timeline</h4>
                </div>
                <div class="card-body">
                    {{ Form::open(['route' => 'update-timeline']) }}
                    {{ Form::hidden('id', $timeline->id) }}
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    {{ Form::label('Description', 'Description') }}
                                    {{ Form::text('Description', $timeline->Description, ['class' => 'form-control '.($errors->has('Description') ? 'is-invalid' : ''), 'readonly' => '']) }}
                                    @error('Description')
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
                                    {{ Form::label('DateTime', 'Date & Time') }}
                                    {{ Form::text('DateTime', is_null(old('DateTime')) ? $timeline->DateTime : old('DateTime'), 
                                    ['class' => 'form-control '.($errors->has('DateTime') ? 'is-invalid' : ''), 'autofocus' => '']) }}
                                    @error('DateTime')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    @if (Auth::user()->role_id == 1)
                                        {{ Form::submit('Update', ['class' => 'btn btn-fill btn-primary']) }}
                                    @endif
                                    <a href="/admin/timeline" class="btn btn-fill btn-danger">
                                        @if (Auth::user()->role_id == 1) Cancel @else Close @endif
                                    </a>
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
                <h4 class="card-title">Timeline List</h4>
            </div>
            <div class="card-body">
                <table class="table">
                    <thead class="text-primary">
                        <tr>
                            <th>ID</th>
                            <th>Description</th>
                            <th>DateTime</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($timelines as $item)
                            <tr>
                                <td>{{ $item->id }}</td>
                                <td>{{ $item->Description }}</td>
                                <td>{{ $item->DateTime }}</td>
                                <td>
                                    <a href="/admin/timeline/{{ $item->id }}">
                                        @if (Auth::user()->role_id == 1) Edit @else Detail @endif
                                    </a>
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