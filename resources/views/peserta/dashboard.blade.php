@extends('layouts.main')

<style>
    .wrapper {
        width: calc(400px + 50vw);
        margin: auto
    }

    .bg-atas {
        background-image: url("../storage/assets/images/lomba-atas.png");
        background-size: auto;
        background-repeat: no-repeat;
        background-position-x: left;
        background-position-y: top;
    }

    .bg-bawah {
        background-image: url("../storage/assets/images/lomba-bawah.png");
        background-size: auto;
        background-repeat: no-repeat;
        background-position-x: right;
        background-position-y: bottom;
        margin-bottom: -36px;
    }

    .box {
        background-color: #135780;
        border-radius: 24px;
        padding: calc(10px + 1.5vw) 5vw;
    }

    @media (max-width: 1000px) {
        .wrapper {
            margin: auto;
            width: 80vw;
        }
    }

    @media (max-width: 800px) {
        .wrapper {
            margin: auto;
            width: 90vw;
        }

        .article {
            font-size: 24px;
        }

        .keterangan {
            margin-top: 20px;
        }
    }
</style>

@section('title', 'Dashboard')

@php
    $peserta = Auth::user();
@endphp

@section('site-content')
    <div class="wrapper">
        <br><br><br>
        <center class="box">
            <article class="heading text-white">{{ $peserta->name }}</article>
            <article class="sub-heading text-white" style="font-weight: 500;">{{ $peserta->KodePeserta }}</article>
        </center>


        <div class="row" style="margin: 3.5vw -6px;">
            <div class="col-3 col-md" style="padding-right: 6px; padding-left: 6px; align-self:end;">
                <img class="w-100" src="{{ asset("storage/assets/state/0-${statusTahap['Registrasi']}.png") }}">
            </div>
            <div class="col-3 col-md" style="padding-right: 6px; padding-left: 6px; align-self:end;">
                <img class="w-100" src="{{ asset("storage/assets/state/1-${statusTahap['Tahap 1']}.png") }}">
            </div>
            <div class="col-3 col-md" style="padding-right: 6px; padding-left: 6px; align-self:end;">
                <img class="w-100" src="{{ asset("storage/assets/state/2-${statusTahap['Tahap 2']}.png") }}">
            </div>
            <div class="col-3 col-md" style="padding-right: 6px; padding-left: 6px; align-self:end;">
                <img class="w-100" src="{{ asset("storage/assets/state/3-${statusTahap['Tahap 3']}.png") }}">
            </div>
            <div class="col-3 col-md keterangan" style="padding-right: 6px; padding-left: 6px; align-self:end;">
                <img class="w-100" src="{{ asset('storage/assets/images/keterangan.png') }}">
            </div>
        </div>
        <br>
        <div class="box" style="padding: calc(10px + 3vw) 5vw">
            @yield('dashboard-content')
        </div>
        <br><br><br>
    </div>

@endsection
