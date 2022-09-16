<div class="col-md-12">
    <div class="card">
        <div class="card-body">
            <h4 class="mb-0">Detail Akun</h4>
            <table class="table">
                <thead>
                    <tr>
                        <th style="width: 15%"></th>
                        <th style="width: 2%"></th>
                        <th style="width: 100%"></th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>Nama</td> <td>:</td> <td>{{ $peserta['Account']['Nama'] }}</td>
                    </tr>
                    <tr>
                        <td>Email</td> <td>:</td> <td>{{ $peserta['Account']['Email'] }}</td>
                    </tr>
                    <tr>
                        <td>Nomor Handphone</td> <td>:</td> <td>{{ $peserta['Account']['No. HP'] }}</td>
                    </tr>
                    <tr>
                        <td>Asal Universitas</td> <td>:</td> <td>{{ $peserta['Account']['Asal Universitas'] }}</td>
                    </tr>
                    <tr>
                        <td>Kode Peserta</td> <td>:</td> <td>{{ $peserta['Account']['Kode Peserta'] }}</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>
@isset($peserta['Payment'])
<div class="col-md-12">
    <div class="card">
        <div class="card-body">
            <h4 class="mb-0">Pembayaran</h4>
            <table class="table">
                <thead>
                    <tr>
                        <th style="width: 15%"></th>
                        <th style="width: 2%"></th>
                        <th style="width: 100%"></th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>Nama Pengirim</td> <td>:</td> <td>{{ $peserta['Payment']['Nama Pengirim'] }}</td>
                    </tr>
                    <tr>
                        <td>Nama Bank</td> <td>:</td> <td>{{ $peserta['Payment']['Nama Bank'] }}</td>
                    </tr>
                    <tr>
                        <td>Waktu Submit</td> <td>:</td> <td>{{ $peserta['Payment']['Waktu Submit'] }}</td>
                    </tr>
                    <tr>
                        <td>Status Verifikasi</td> <td>:</td>
                        @php
                            if (is_null($peserta['Payment']['Status Verifikasi'])){
                                $statusVerifikasi = '-';
                            }
                            else if ($peserta['Payment']['Status Verifikasi'] == 1){
                                $statusVerifikasi = 'Diterima';
                            }
                            else if ($peserta['Payment']['Status Verifikasi'] == -1){
                                $statusVerifikasi = 'Ditolak';
                            }
                            else {
                                $statusVerifikasi = '-';
                            }
                        @endphp
                        <td>{{ $statusVerifikasi }}</td>
                    </tr>
                    @if ($statusVerifikasi != '-')
                    <tr>
                        <td>Diverifikasi Oleh</td> <td>:</td> <td>{{ $peserta['Payment']['Verified By'] }}</td>
                    </tr>
                    @endif
                </tbody>
            </table>
            <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#verifyPaymentModal">
                {{ ($statusVerifikasi == '-') ? 'Verifikasi' : 'Lihat Bukti' }}
            </button>
            @include('components.modal.admin.verifyPayment')
        </div>
    </div>
</div>
@endisset
@isset($peserta['Detail'])
<div class="col-md-12">
    <div class="card">
        <div class="card-body">
            <h4 class="mb-0">Data Peserta</h4>
            <table class="table" id="detailPesertaTable">
                <thead class="text-primary">
                    <tr>
                        <th>#</th>
                        <th>Nama</th>
                        <th>Jurusan</th>
                        <th>Nomor Handphone</th>
                        <th>ID Line</th>
                        <th>Kartu Tanda Mahasiswa</th>
                    </tr>
                </thead>
                <tbody>
                    @for ($i = 0; $i < count($peserta['Detail'])+1; $i++)
                        <tr>
                            <td>{{ $i + 1 }}</td>
                            <td>{{ $peserta['Detail']['Peserta'][$i]['Nama'] }}</td>
                            <td>{{ $peserta['Detail']['Peserta'][$i]['Jurusan'] }}</td>
                            <td>{{ $peserta['Detail']['Peserta'][$i]['NoHP'] }}</td>
                            <td>{{ $peserta['Detail']['Peserta'][$i]['IDLine'] ?? '-' }}</td>
                            <td>{{ $peserta['Detail']['Peserta'][$i]['KTM'] }}</td>
                        </tr>
                    @endfor
                </tbody>
            </table>
            <a href="{{ route('download-ktm', ['peserta_id' => $peserta['Account']['id']]) }}">
                <i class="fas fa-download"></i> Download KTM
            </a>
            <p class="mt-2">Waktu Submit: {{ $peserta['Detail']['Waktu Submit']->toDateTimeString() }}</p>
        </div>
    </div>
</div>
<script>
    $(document).ready(function () {
        $('#detailPesertaTable').DataTable({
            "paging": false,
            "ordering": false,
            "searching": false,
            "info": false,
            "sScrollXInner": "100%",
            "sScrollX": "100%",
            "bAutoWidth": true,
        });
    });
</script>
@endisset