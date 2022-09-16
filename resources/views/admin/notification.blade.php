@extends('layouts.admin')

@section('style')
<style>
    .form-control > option {
        background-color: rgb(43, 53, 83);
    }

    #notificationTable th {
        white-space: nowrap;
    }

    #notificationTable td {
        white-space: nowrap;
    }
</style>
@endsection

@section('title', 'Notifications')

@section('site-content')
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title">Notification's List</h4>
            </div>
            <div class="card-body">
                <table class="table" id="notificationTable">
                    <thead>
                        <tr>
                            <th></th>
                            <th>Description</th>
                            <th>Date and Time</th>
                            <th>Action</th>
                        </tr>
                        <tbody>
                            @foreach ($notifications as $item)
                                <tr>
                                    <td></td>
                                    <td>{!! $item['Description'] !!}</td>
                                    <td>{{ $item['DateTime'] }}</td>
                                    <td>
                                        <a type="button" rel="tooltip" class="btn btn-info btn-sm btn-icon" href="{{ $item['Redirect URL'] }}">
                                            <i class="tim-icons icon-zoom-split"></i>
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </thead>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection

@section('script')
<script>
    const COLUMN_ACTION = 3;
    $(document).ready(function () {
        var notificationTable = $('#notificationTable').DataTable({
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
                "targets": COLUMN_ACTION,
                "className": "text-center"
            }],
            "order": [[0, 'asc']],
            "sScrollXInner": "100%",
            "sScrollX": "100%",
            "bAutoWidth": true,
        });

        notificationTable.on( 'order.dt search.dt', function () {
            notificationTable.column(0, {search:'applied', order:'applied'}).nodes().each( function (cell, i) {
                cell.innerHTML = i+1;
            } );
        } ).draw();
    });
</script>
@endsection