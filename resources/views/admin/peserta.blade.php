@extends('layouts.admin')

@section('style')
<style>
    .custom-select > option {
        background-color: rgb(43, 53, 83);
    }

    .dataTables_wrapper {
        margin-top: .5rem;
    }

    #pesertaTable th {
        white-space: nowrap;
    }

    #pesertaTable td {
        white-space: nowrap;
    }
</style>
@endsection

@section('title', 'Daftar Peserta')

@section('site-content')
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title">Daftar Peserta</h4>
            </div>
            <div class="card-body">
                <h4 class="mb-0">Filter:</h4>
                <div class="row">
                    <div class="col">
                        <div class="form-check form-check-inline">
                            <label class="form-check-label">
                                <input type="checkbox" class="form-check-input cbx-tahap" checked value="Registrasi">Registrasi
                                <span class="form-check-sign"></span>
                            </label>
                        </div>
                        <div class="form-check form-check-inline">
                            <label class="form-check-label">
                                <input type="checkbox" class="form-check-input cbx-tahap" checked value="Tahap 1">Tahap 1
                                <span class="form-check-sign"></span>
                            </label>
                        </div>
                        <div class="form-check form-check-inline">
                            <label class="form-check-label">
                                <input type="checkbox" class="form-check-input cbx-tahap" checked value="Tahap 2">Tahap 2
                                <span class="form-check-sign"></span>
                            </label>
                        </div>
                        <div class="form-check form-check-inline">
                            <label class="form-check-label">
                                <input type="checkbox" class="form-check-input cbx-tahap" checked value="Tahap 3">Tahap 3
                                <span class="form-check-sign"></span>
                            </label>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col">
                        <div class="form-check form-check-inline">
                            <label class="form-check-label">
                                <input type="checkbox" class="form-check-input cbx-regis" checked value="In Progress">In Progress
                                <span class="form-check-sign"></span>
                            </label>
                        </div>
                        <div class="form-check form-check-inline">
                            <label class="form-check-label">
                                <input type="checkbox" class="form-check-input cbx-regis" checked value="Needs Verification">Needs Verification
                                <span class="form-check-sign"></span>
                            </label>
                        </div>
                        <div class="form-check form-check-inline">
                            <label class="form-check-label">
                                <input type="checkbox" class="form-check-input cbx-regis" checked value="Verification Failed">Verification Failed
                                <span class="form-check-sign"></span>
                            </label>
                        </div>
                        <div class="form-check form-check-inline">
                            <label class="form-check-label">
                                <input type="checkbox" class="form-check-input cbx-regis" checked value="Finished">Finished
                                <span class="form-check-sign"></span>
                            </label>
                        </div>
                    </div>
                </div>
                <table class="table" id="pesertaTable">
                    <thead class="text-primary">
                        <tr>
                            <th></th>
                            <th>Kode Peserta</th>
                            <th>Nama Akun</th>
                            <th>Email</th>
                            <th>Tahap</th>
                            <th>Status Registrasi</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($pesertas as $peserta)
                        <tr>
                            <td></td>
                            <td>{{ $peserta['KodePeserta'] }}</td>
                            <td>{{ $peserta['Nama'] }}</td>
                            <td>{{ $peserta['email'] }}</td>
                            <td>{{ $peserta['Tahap'] }}</td>
                            <td>{{ $peserta['Status Registrasi'] }}</td>
                            <td>
                                <a href="javascript:void(0)" onclick="GetDetailPeserta({{ $peserta['id'] }})">Detail</a>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<div class="row" id="detail-peserta"></div>
@endsection

@section('script')
<script>
    const COLUMN_TAHAP = 4;
    const COLUMN_REGISTRASI = 5;
    const COLUMN_ACTION = 6;
    var pesertaTable;
    $(document).ready(function () {
        pesertaTable = $('#pesertaTable').DataTable({
            "language": {
                "paginate": {
                    "previous": "&lt;",
                    "next": "&gt;"
                }
            },
            "columnDefs": [
            {
                "title": "#",
                "searchable": false,
                "orderable": false,
                "targets": 0
            },
            {
                "searchable": false,
                "orderable": false,
                "targets": COLUMN_ACTION
            }],
            "order": [[0, 'asc']],
            "sScrollXInner": "100%",
            "sScrollX": "100%",
            "bAutoWidth": true,
        });

        pesertaTable.on( 'order.dt search.dt', function () {
            pesertaTable.column(0, {search:'applied', order:'applied'}).nodes().each( function (cell, i) {
                cell.innerHTML = i+1;
            } );
        } ).draw();

        $('.cbx-tahap').change(function () {
            checkBoxFilter('cbx-tahap', COLUMN_TAHAP);
        });

        $('.cbx-regis').change(function () {
            checkBoxFilter('cbx-regis', COLUMN_REGISTRASI);
        });

        @isset ($redirect_id)
        GetDetailPeserta({{ $redirect_id }});
        @endisset
    });

    function checkBoxFilter(cbxClass, filterColumn) {
        var checkedVal = $(`.${cbxClass}:checked`).map(function () {
            return `(${this.value})`;
        }).get().join('|');

        if (checkedVal != ''){
            checkedVal = `^(${checkedVal})`;
            pesertaTable.column(filterColumn).search(checkedVal, true, false).draw();
        }
        else {
            pesertaTable.column(filterColumn).search('No Record').draw();
        }
    }

    function GetDetailPeserta(id) {
        $('#detail-peserta').load('/admin/peserta', { id: id });
    }
</script>
@endsection