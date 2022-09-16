@extends('layouts.main')

@section('style')
<style>
.container{
    margin-top: 6vw;
    margin-bottom: 6vw;
}

.btn{
    width:120px;
}

.btn-kirim{
    margin:0;
    margin-top: 16px;
}

.btn-outline-info-2 {
    color: #ffb2b2;
    border-color: #ffb2b2;
}

.btn-outline-info-2:hover {
    color: #d01419;
    background-color: #ffb2b2;
    border-color: #ffb2b2;
}

.h{
    margin-top:36px;
    margin-bottom:20px;
    text-align:center;
    font-size:calc(16px + 2.4vw);
}

@media (max-width: 800px) {
    .article{
        font-size:24px;
    }
}

@media (max-width: 400px) {
    .btn{
        width:100%;
    }
    .btn-kirim{
        margin-top: 20px;
    }
}
</style>
@endsection

@section('title', 'Confirm Payment')

@section('site-content')
<div class="container">
    <div class="row">
        <div class="col-md-4" style="margin-top: auto; margin-bottom: auto;">
            <img src="{{ asset("storage/assets/images/konfirmasi-pembayaran.png") }}" alt="konfirmasi-pembayaran" width=250px">
        </div>

        <div class="col-md-8">
            <div class="heading text-white">
                <span>Konfirmasi Pembayaran</span>
            </div>

            <div class="text-white" style="font-size: 28px; margin-top: 20px;">
                <span>Total biaya pendaftaran: Rp. 75.000,-</span>
            </div>

            <div style="font-size: 20px; font-weight: bold; font-style: italic;" class="text-white">
                <span>Pembayaran biaya pendaftaran melalui BCA a.n. ANGELICA</span>
                <br>
                <span>(No. rekening: 1740401927)</span>
            </div>

            <div class="form-style-content">
                {{ Form::open(['route' => 'pembayaran', 'files' => true]) }}
                <span style="color: #94bccf; font-weight: normal; margin-bottom: 10px; margin-top: 20px;">Nama Pengirim</span>
                <div class="form-group" style="margin-bottom:32px;">
                    {{ Form::text('NamaPengirim', old('NamaPengirim'), ['class' => 'form-control '.($errors->has('NamaPengirim') ? 'is-invalid' : ''), 'placeholder' => 'Masukkan Nama Pengirim', 'autofocus' => '']) }}
                    @error('NamaPengirim')
                    <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                </div>

                <span style="color: #94bccf; font-weight: normal; margin-bottom: 10px; margin-top: 20px;">Nama Bank</span>
                <div class="form-group" style="margin-bottom:32px;">
                    {{ Form::text('NamaBank', old('NamaBank'), ['class' => 'form-control '.($errors->has('NamaBank') ? 'is-invalid' : ''), 'placeholder' => 'Masukkan Nama Bank Pengirim']) }}
                    @error('NamaBank')
                    <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>

                <div class="form-group">
                    <article class="text-white" style="font-size:18px;">
                        Unggah Bukti Transfer (.jpg)
                        <img src="{{ asset('storage/assets/images/unggah-bukti-transfer.png') }}" alt="upload-image" width="22px" height="22px" style="margin-left: 10px;">
                    </article>
                    {{ Form::label('BuktiTransfer', 'Pilih file', ['class' => 'btn btn-outline-info fit-content-btn', 'style' => 'margin: 12px 10px 0 0;']) }}
                    <span id="FileBuktiTransfer" class="text-white"></span>
                    {{ Form::file('BuktiTransfer', ['class' => 'form-control '.($errors->has('BuktiTransfer') ? 'is-invalid' : ''), 'style' => 'display:none;;']) }}
                    @error('BuktiTransfer')
                    <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
                <div class="text-right" style="margin-top:42px;">
                    {{ Form::submit('Kirim', ['class' => 'btn btn-outline-info-2 fit-content-btn btn-kirim']) }}
                </div>
                {{ Form::close() }}
            </div>
        </div>
    </div>
</div>
@endsection

@section('script')
<script>
    $(document).on('change', '#BuktiTransfer', function (event) {
        $('#FileBuktiTransfer').html(event.target.files[0].name);
    });
</script>
@endsection
