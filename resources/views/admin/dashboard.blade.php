@extends('layouts.admin')

@section('style')
<style>
    h2 {
        margin-bottom: 0;
    }
</style>
@endsection

@section('title', 'Dashboard')

@section('site-content')
<h2 class="mb-2">Welcome, {{ Auth::user()->name }}</h2>

<div class="row">
    <div class="col-md 12">
        <div class="card text-center">
            <div class="card-header">
                <h3 class="card-title">Statistik Peserta</h3>
            </div>
            <div class="card-body">
                <div class="row mb-2">
                    <div class="col-lg-8 ml-auto mr-auto">
                        <div class="row">
                            <div class="col-md-6">
                                <h2>{{ $statistics['Registered'] }}</h2>
                                <p>Akun Terdaftar</p>
                            </div>
                            <div class="col-md-6">
                                <h2>{{ $statistics['Verified'] }}</h2>
                                <p>Email Terverifikasi</p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-8 ml-auto mr-auto">
                        <div class="row">
                            <div class="col-md-4">
                                <h2>{{ $statistics['Tahap 1'] }}</h2>
                                <p>Mencapai Tahap 1</p>
                            </div>
                            <div class="col-md-4">
                                <h2>{{ $statistics['Tahap 2'] }}</h2>
                                <p>Mencapai Tahap 2</p>
                            </div>
                            <div class="col-md-4">
                                <h2>{{ $statistics['Tahap 3'] }}</h2>
                                <p>Mencapai Tahap 3</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@if (count($reminders) > 0)
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title text-center">Reminder</h3>
            </div>
            <div class="card-body">
                <ul>
                    @foreach ($reminders as $item)
                        <li>{{ $item['Message'] }}</li>
                    @endforeach
                </ul>
            </div>
        </div>
    </div>
</div>
@endif
@endsection