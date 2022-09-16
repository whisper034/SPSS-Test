@extends('layouts.main')

@section('title','Registrasi Peserta')

@section('style')
<style>
.section{
    padding:0;
    margin:5vw 8vw;
}
.form-control[readonly]{
    background-color: #8c949b;
}
.pesertas{
    display:flex;
    flex-direction:row;
}
.peserta{
    width: 40vw;
    margin: 0 2vw;
}
.form-group{
    margin: 28px 0;
}
.btn-daftar{
    margin:0;
    width:160px;
    margin-right:2vw;
}

@media (max-width: 680px){
    .pesertas{
        flex-direction:column;
    }
    .peserta{
        width: 80vw;
    }
    .btn-daftar{
        width:calc(100% - 4vw);
        margin: 0 2vw;
    }
}

</style>
@endsection

@php
    $peserta = Auth::user();
@endphp

@section('site-content')
<div class="section">
    <div class="text-left heading text-white">
        <span>Registrasi Peserta</span>
    </div>

    <div>
        {{ Form::open(['route' => 'data-peserta', 'files' => true]) }}
        <div class="pesertas">
            <!-- Peserta 1 -->
            <div class="peserta">
                <div class="form-group sub-heading text-white" style="font-style: italic;">
                    <span>Peserta 1</span>
                </div>

                <div class="form-group">
                    <span style="color: #94bccf; font-weight: normal; margin-bottom: 10px; margin-top: 20px;">Nama Lengkap</span>
                    {{ Form::text('Peserta1_Nama', $peserta->name, ['class' => 'form-control '.($errors->has('Peserta1_Nama') ? 'is-invalid' : ''), 'readonly' => '', 'placeholder' => 'Nama']) }}
                    @error('Peserta1_Nama')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>

                <div class="form-group">
                    <span style="color: #94bccf; font-weight: normal; margin-bottom: 10px; margin-top: 20px;">Jurusan</span>
                    {{ Form::text('Peserta1_Jurusan', old('Peserta1_Jurusan'), ['class' => 'form-control '.($errors->has('Peserta1_Jurusan') ? 'is-invalid' : ''), 'placeholder' => 'Jurusan', 'autofocus' => '']) }}
                    @error('Peserta1_Jurusan')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>

                <div class="form-group">
                    <span style="color: #94bccf; font-weight: normal; margin-bottom: 10px; margin-top: 20px;">Nomor Telepon</span>
                    {{ Form::text('Peserta1_NoHP', $peserta->NoHP, ['class' => 'form-control '.($errors->has('Peserta1_NoHP') ? 'is-invalid' : ''), 'readonly' => '', 'placeholder' => 'No. HP']) }}
                    @error('Peserta1_NoHP')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>

                <div class="form-group">
                    <span style="color: #94bccf; font-weight: normal; margin-bottom: 10px; margin-top: 20px;">ID Line</span>
                    {{ Form::text('Peserta1_IDLine', old('Peserta1_IDLine'), ['class' => 'form-control '.($errors->has('Peserta1_IDLine') ? 'is-invalid' : ''), 'placeholder' => 'ID Line (Opsional)']) }}
                    @error('Peserta1_IDLine')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>

                <div class="form-group">
                    <article class="text-white">
{{--                        inget, di database itu masih KTM--}}
                        Unggah Bukti Transfer (.jpg)
                        <img src="{{ asset('storage/assets/images/unggah-bukti-transfer.png') }}" alt="upload-image" width="22px" height="22px" style="margin-left: 10px;">
                    </article>
                    {{ Form::label('Peserta1_KTM', 'Pilih file', ['class' => 'btn btn-outline-info fit-content-btn', 'style' => 'margin: 12px 0 0 0; width:120px;']) }}
                    <span id="FilePeserta1" class="text-white"></span>
                    {{ Form::file('Peserta1_KTM', ['class' => 'form-control '.($errors->has('Peserta1_KTM') ? 'is-invalid' : ''), 'style' => 'display:none;']) }}
                    @error('Peserta1_KTM')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
            </div>

            <!-- Peserta 2 -->
            <div class="peserta">
                <div class="form-group sub-heading text-white" style="font-style: italic;">
                    <span>Peserta 2</span>
                </div>

                <div class="form-group">
                    <span style="color: #94bccf; font-weight: normal; margin-bottom: 10px; margin-top: 20px;">Nama Lengkap</span>
                    {{ Form::text('Peserta2_Nama', old('Peserta2_Nama'), ['class' => 'form-control '.($errors->has('Peserta2_Nama') ? 'is-invalid' : ''), 'placeholder' => 'Nama']) }}
                    @error('Peserta2_Nama')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>

                <div class="form-group">
                    <span style="color: #94bccf; font-weight: normal; margin-bottom: 10px; margin-top: 20px;">Jurusan</span>
                    {{ Form::text('Peserta2_Jurusan', old('Peserta2_Jurusan'), ['class' => 'form-control '.($errors->has('Peserta2_Jurusan') ? 'is-invalid' : ''), 'placeholder' => 'Jurusan']) }}
                    @error('Peserta2_Jurusan')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>

                <div class="form-group">
                    <span style="color: #94bccf; font-weight: normal; margin-bottom: 10px; margin-top: 20px;">Nomor Telepon</span>
                    {{ Form::text('Peserta2_NoHP', old('Peserta2_NoHP'), ['class' => 'form-control '.($errors->has('Peserta2_NoHP') ? 'is-invalid' : ''), 'placeholder' => 'No. HP']) }}
                    @error('Peserta2_NoHP')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>

                <div class="form-group">
                    <span style="color: #94bccf; font-weight: normal; margin-bottom: 10px; margin-top: 20px;">ID Line</span>
                    {{ Form::text('Peserta2_IDLine', old('Peserta2_IDLine'), ['class' => 'form-control '.($errors->has('Peserta2_IDLine') ? 'is-invalid' : ''), 'placeholder' => 'ID Line (Opsional)']) }}
                    @error('Peserta2_IDLine')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>

                <div class="form-group">
                    <article class="text-white">
                        {{--                        inget, di database itu masih KTM--}}
                        Unggah Bukti Transfer (.jpg)
                        <img src="{{ asset('storage/assets/images/unggah-bukti-transfer.png') }}" alt="upload-image" width="22px" height="22px" style="margin-left: 10px;">
                    </article>
                    {{ Form::label('Peserta2_KTM', 'Pilih file', ['class' => 'btn btn-outline-info fit-content-btn', 'style' => 'margin:12px 0 0 0; width:120px;']) }}
                    <span id="FilePeserta2" class="text-white"></span>
                    {{ Form::file('Peserta2_KTM', ['class' => 'form-control '.($errors->has('Peserta2_KTM') ? 'is-invalid' : ''), 'style' => 'display:none;']) }}
                    @error('Peserta2_KTM')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
            </div>

            <!-- Peserta 3 -->
            <div class="peserta">
                <div class="form-group sub-heading text-white" style="font-style: italic;">
                    <span>Peserta 3</span>
                </div>

                <div class="form-group">
                    <span style="color: #94bccf; font-weight: normal; margin-bottom: 10px; margin-top: 20px;">Nama Lengkap</span>
                    {{ Form::text('Peserta3_Nama', old('Peserta3_Nama'), ['class' => 'form-control '.($errors->has('Peserta3_Nama') ? 'is-invalid' : ''), 'placeholder' => 'Nama']) }}
                    @error('Peserta3_Nama')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>

                <div class="form-group">
                    <span style="color: #94bccf; font-weight: normal; margin-bottom: 10px; margin-top: 20px;">Jurusan</span>
                    {{ Form::text('Peserta3_Jurusan', old('Peserta3_Jurusan'), ['class' => 'form-control '.($errors->has('Peserta3_Jurusan') ? 'is-invalid' : ''), 'placeholder' => 'Jurusan']) }}
                    @error('Peserta3_Jurusan')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>

                <div class="form-group">
                    <span style="color: #94bccf; font-weight: normal; margin-bottom: 10px; margin-top: 20px;">Nomor Telepon</span>
                    {{ Form::text('Peserta3_NoHP', old('Peserta3_NoHP'), ['class' => 'form-control '.($errors->has('Peserta3_NoHP') ? 'is-invalid' : ''), 'placeholder' => 'No. HP']) }}
                    @error('Peserta3_NoHP')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>

                <div class="form-group">
                    <span style="color: #94bccf; font-weight: normal; margin-bottom: 10px; margin-top: 20px;">ID Line</span>
                    {{ Form::text('Peserta3_IDLine', old('Peserta3_IDLine'), ['class' => 'form-control '.($errors->has('Peserta3_IDLine') ? 'is-invalid' : ''), 'placeholder' => 'ID Line (Opsional)']) }}
                    @error('Peserta3_IDLine')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>

                <div class="form-group">
                    <article class="text-white">
                        {{--                        inget, di database itu masih KTM--}}
                        Unggah Bukti Transfer (.jpg)
                        <img src="{{ asset('storage/assets/images/unggah-bukti-transfer.png') }}" alt="upload-image" width="22px" height="22px" style="margin-left: 10px;">
                    </article>
                    {{ Form::label('Peserta3_KTM', 'Pilih file', ['class' => 'btn btn-outline-info fit-content-btn', 'style' => 'margin:12px 0 0 0; width:120px;']) }}
                    <span id="FilePeserta3" class="text-white"></span>
                    {{ Form::file('Peserta3_KTM', ['class' => 'form-control '.($errors->has('Peserta3_KTM') ? 'is-invalid' : ''), 'style' => 'display:none;']) }}
                    @error('Peserta3_KTM')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
            </div>
        </div>

        <div class="text-right" style="margin-top: 24px;">
            {{ Form::submit('Daftar', ['class' => 'btn btn-outline-info fit-content-btn btn-daftar']) }}
        </div>

        {{ Form::close() }}
    </div>
</div>
@endsection

@section('script')
<script>
    $(document).on('change', '#Peserta1_KTM', function (event) {
        $('#FilePeserta1').html(event.target.files[0].name);
    });

    $(document).on('change', '#Peserta2_KTM', function (event) {
        $('#FilePeserta2').html(event.target.files[0].name);
    });

    $(document).on('change', '#Peserta3_KTM', function (event) {
        $('#FilePeserta3').html(event.target.files[0].name);
    });
</script>
@endsection
