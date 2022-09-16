@extends('peserta.dashboard')

@php
    $peserta = Auth::user();
    $submitToken = Crypt::encrypt($currentTahap.'+'.$peserta->KodePeserta);

    if (isset($detailJawaban)) {
        $finalisasiToken = Crypt::encrypt(join('+', [
            $currentTahap,
            $peserta->KodePeserta,
            $detailJawaban['Timestamp Submit']
        ]));
        $answerDownloadURL = route('answer-download', ['file' => Crypt::encrypt($detailJawaban['File Submit'])]);
    }

    $soalDownloadURL = route('dashboard-download', ['file' => Crypt::encrypt('ST1')]);
@endphp

@section('dashboard-content')
    <article class="heading text-white" style="font-size: calc(15px + 2vw);">
        Pengerjaan tahap 1
    </article>
    <article class="sub-heading text-white" style="font-size: calc(12px + 1.5vw);">
        Silahkan unduh soal tahap 1 <a href="{{ $soalDownloadURL }}" class="link">disini</a>.
    </article>  <br />
    <article class="sub-heading text-white" style="font-size: calc(12px + 1.5vw);">
        Batas pengiriman jawaban <span id="time">00 hari 00 jam 00 menit 00 detik</span> lagi.
    </article>
    {{ Form::open(['route' => 'submit-answer', 'files' => true, 'id' => 'SubmitForm']) }}
        {{ Form::hidden('SubmitToken', $submitToken) }}
        <article class="sub-heading text-white" style="font-size: calc(12px + 1.5vw);">
            Unggah jawaban anda (.pdf) : 
        </article>
        <div class="form-group" style="margin-top: 12px;">
            {{ Form::label('FileSubmit', 'Pilih file', [
                'class' => 'btn btn-outline-info fit-content-btn',
                'style' => 'margin: 4px 0 0; width:120px;'
            ]) }}
            <span id="FileName" class="text-white"></span>
            {{ Form::file('FileSubmit', ['class' => 'form-control-file '.($errors->submit->any() ? 'is-invalid' : ''), 'style' => 'display:none;']) }}
            @if ($errors->submit->any())
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $errors->submit->first() }}</strong>
                </span>
            @endif
        </div>
    {{ Form::close() }}
    @isset($detailJawaban)
        <div class="form-group">
            <div class="outer-border w-100 text-white" style="margin: 24px auto;">
                <div class="inner-border">
                    <table id="FileDetailsTable">
                        <thead>
                            <tr>
                                <th style="width: 45%;"></th>
                                <th style="width: 10%;"></th>
                                <th style="width: 100%;"></th>
                            </tr>
                        </thead>
                        <tbody class="text-white">
                            <tr>
                                <td>Waktu Unggahan</td> <td>:</td> <td>{{ $detailJawaban['Upload Date'] }}</td>
                            </tr>
                            <tr>
                                <td>Nama File</td> <td>:</td> <td>{{ $detailJawaban['Name'] }}</td>
                            </tr>
                            <tr>
                                <td>Ukuran File</td> <td>:</td> <td>{{ $detailJawaban['Size'] }} kilobytes</td>
                            </tr>
                        </tbody>
                    </table>
                    <article class="download-file">
                        <a href="{{ $answerDownloadURL }}" class="link">Tekan ini</a> untuk mengunduh jawaban anda.
                    </article>
                </div>
            </div>
            <button type="button" class="btn btn-outline-info fit-content-btn" data-toggle="modal" data-target="#finaliseModal" style="margin: 12px 0 0; width:120px;">Finalisasi</button>
            {{ Form::hidden('temp', 'temp', ['class' => ($errors->finalise->any() ? 'is-invalid' : '')]) }}
            @if ($errors->finalise->any())
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $errors->finalise->first() }}</strong>
                </span>
            @endif
        </div>
        @include('components.modal.finaliseAnswer')
    @endisset
@endsection

@section('script')
<script>
    $(document).ready(function () {
        $('#FileSubmit').change(function () {
            $('#SubmitForm').submit();
        });

        var date = new Date({{ $countdown }});
        Countdown.doCountdown(Countdown.format.dashboard, 'time', date);
    });

    $(document).on('change', '#FileSubmit', function (event) {
        $('#FileName').html(event.target.files[0].name);
    });
</script>
@endsection