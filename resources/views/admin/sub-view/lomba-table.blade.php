<div class="col-md-12">
    <div class="card">
        <div class="card-header">
            <h4 class="card-title">{{ $title }}</h4>
        </div>
        <div class="card-body">
            <h4>
                <span id="countdown-text"></span>
                <span id="time">00:00:00:00</span>
            </h4>
            <div class="row mb-2">
                <div class="col-auto mr-auto">
                    <button type="button" class="btn btn-primary btn-sm" id="btn-refresh">
                        <i class="tim-icons icon-refresh-02"></i> Refresh
                    </button>
                </div>
                <div class="col-auto">
                    <a class="btn btn-primary btn-sm" href="{{ route('download-data-lomba', ['tahap_id' => $tahap_id]) }}">
                        <i class="fas fa-download"></i> Download All
                    </a>
                </div>
            </div>
            <table class="table" id="pesertaLombaTable">
                <thead class="text-primary">
                    <tr>
                        <th>Kode Tim</th>
                        <th>Peserta 1</th>
                        <th>Peserta 2</th>
                        <th>Peserta 3</th>
                        <th>Nama File</th>
                        <th>Waktu Submit</th>
                        <th>Waktu Finalisasi</th>
                        <th>Action</th>
                    </tr>
                </thead>
            </table>
        </div>
    </div>
</div>
<div class="col-md-12" id="nextPhaseWrapper" style="display:none;">
    <div class="card">
        <div class="card-header">
            <h4 class="card-title">Next Phase Table</h4>
        </div>
        <div class="card-body">
            {{ Form::open(['url' => route('next-phase', ['tahap_id' => $tahap_id])]) }}
            <button type="button" class="btn btn-success" data-toggle="modal" data-target="#nextPhaseModal">Pilih Peserta</button>
            {{ Form::hidden('temp', null, ['class' => 'form-control is-invalid']) }}
            <span class="invalid-feedback" role="alert">
                <strong>*Pilih setidaknya satu peserta</strong>
            </span>
            <table class="table" id="nextPhaseTable">
                <thead class="text-primary">
                    <tr>
                        <th>Kode Time</th>
                        <th>Peserta 1</th>
                        <th>Peserta 2</th>
                        <th>Peserta 3</th>
                        <th>Lanjut Tahap</th>
                    </tr>
                </thead>
            </table>
            @include('components.modal.admin.nextPhase')
            {{ Form::close() }}
        </div>
    </div>
</div>

<script>
    var START_TO_PROCESS = 1;
    var PROCESS_TO_END = 2;
    function changePhase(phaseType, nextDate) {
        if (phaseType == START_TO_PROCESS){
            $('#countdown-text').text('{{ $title }} will end in ');
            var temp = Countdown.doCountdown(Countdown.format.home, 'time', nextDate, false, function () {
                changePhase(PROCESS_TO_END);
            });
            GlobalIntervalList.push(temp);
        }
        else if (phaseType == PROCESS_TO_END){
            $('#countdown-text').text('{{ $title }} has ended.');
            $('#time').text('');
            nextPhaseToDataTable();
        }
    }

    $(document).ready(function () {
        var lombaTable = $('#pesertaLombaTable').DataTable({
            "ajax": {
                "url": "/admin/lomba/{{ $tahap_id }}/data",
                "dataSrc" : function (json) {
                    var return_data = new Array();
                    json.forEach(data => {
                        var downloadAction = '';
                        if (data['Download URL'] !== ''){
                            downloadAction = 
                                `<a href="${data['Download URL']}">
                                    <i class="fas fa-download"></i>
                                 </a>`;
                        }
                        return_data.push({
                            "Kode Peserta": data["Kode Peserta"],
                            "Peserta 1": data["Peserta 1"],
                            "Peserta 2": data["Peserta 2"],
                            "Peserta 3": data["Peserta 3"],
                            "Nama File": data["Nama File"],
                            "Waktu Submit": data["Waktu Submit"],
                            "Waktu Finalisasi": data["Waktu Finalisasi"],
                            "Download Action": downloadAction,
                        });
                    });
                    return return_data;
                }
            },
            "columns": [
                { "data": "Kode Peserta" },
                { "data": "Peserta 1" },
                { "data": "Peserta 2" },
                { "data": "Peserta 3" },
                { "data": "Nama File" },
                { "data": "Waktu Submit" },
                { "data": "Waktu Finalisasi" },
                { "data": "Download Action", "className": "text-center" }
            ],
            "columnDefs": [
            {
                "searchable": false,
                "orderable": false,
                "targets": 6
            }],
            "language": {
                "paginate": {
                    "previous": "&lt;",
                    "next": "&gt;"
                }
            },
            "sScrollXInner": "100%",
            "sScrollX": "100%",
            "bAutoWidth": true,
        });

        $('#btn-refresh').click(function () {
            lombaTable.ajax.reload();
        });

        var currDate = new Date();
        var startDate = new Date({{ $startDate }});
        var endDate = new Date({{ $endDate }});

        if (currDate < startDate){
            $('#countdown-text').text('{{ $title }} will start in ');
            var temp = Countdown.doCountdown(Countdown.format.home, 'time', startDate, false, function () {
                changePhase(START_TO_PROCESS, endDate);
            });
            GlobalIntervalList.push(temp);
        }
        else if (currDate < endDate){
            $('#countdown-text').text('{{ $title }} will end in ');
            var temp = Countdown.doCountdown(Countdown.format.home, 'time', endDate, false, function () {
                changePhase(PROCESS_TO_END, endDate);
            });
            GlobalIntervalList.push(temp);
        }
        else {
            $('#countdown-text').text('{{ $title }} has ended.');
            $('#time').text('');
            nextPhaseToDataTable();
        }
    });

    function nextPhaseToDataTable() {
        $('#nextPhaseWrapper').show();
        $('#nextPhaseTable').DataTable({
            "ajax": {
                "url": "/admin/lomba/{{ $tahap_id }}/data",
                "dataSrc": function (json) {
                    var return_data = new Array();
                    json.forEach(data => {
                        var defaultCbx = '{{ Form::checkbox('KodePeserta[]', '{value}') }}';
                        return_data.push({
                            "Kode Peserta": data["Kode Peserta"],
                            "Peserta 1": data["Peserta 1"],
                            "Peserta 2": data["Peserta 2"],
                            "Peserta 3": data["Peserta 3"],
                            "Checkbox": defaultCbx.replace("{value}", data["Kode Peserta"])
                        });
                    });
                    return return_data;
                }
            },
            "columns": [
                { "data": "Kode Peserta" },
                { "data": "Peserta 1" },
                { "data": "Peserta 2" },
                { "data": "Peserta 3" },
                { "data": "Checkbox", "className": "text-center" }
            ],
            "columnDefs": [
            {
                "searchable": false,
                "orderable": false,
                "targets": 3
            }],
            "language": {
                "paginate": {
                    "previous": "&lt;",
                    "next": "&gt;"
                }
            },
            "paging": false,
            "ordering": false,
            "info": false,
            "sScrollXInner": "100%",
            "sScrollX": "100%",
            "bAutoWidth": true,
        });
    }
</script>