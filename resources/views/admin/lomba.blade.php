@extends('layouts.admin')

@section('style')
<style>
    select > option {
        background-color: rgb(43, 53, 83);
    }

    .dataTables_wrapper {
        margin-top: .5rem;
    }

    .table th {
        white-space: nowrap;
    }

    .table td {
        white-space: nowrap;
    }
</style>
@endsection

@section('title', 'Peserta Lomba')

@section('site-content')
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title">Pilih Tahap</h4>
            </div>
            <div class="card-body">
                {{ Form::select('ddlTahap', $tahap['ddl'], strval($tahap['selected']), ['class' => 'form-control', 'placeholder' => '-- Pilih Tahap --', 'id' => 'ddlTahap']) }}
            </div>
        </div>
    </div>
</div>
<div class="row" id="lombaContent"></div>
@endsection

@section('script')
<script>
    $(document).ready(function () {
        $('#ddlTahap').change(function () {
            if (this.value !== ''){
                GlobalIntervalList.forEach(clearInterval);
                $('#lombaContent').load(`/admin/lomba/${this.value}`);
            }
        });

        $('#ddlTahap').trigger('change');
    });
</script>
@endsection