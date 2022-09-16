<div class="modal modal-black fade" role="dialog" id="verifyPaymentModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Verifikasi Pembayaran</h4>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
                    <i class="tim-icons icon-simple-remove"></i>
                </button>
            </div>
            <div class="modal-body">
                <a href="{{ route('payment-photo', ['peserta_id' => $peserta['Account']['id'] ]) }}" target="_blank">
                    <img src="{{ route('payment-photo', ['peserta_id' => $peserta['Account']['id'] ]) }}" class="img-fluid">
                </a>
            </div>
            @if ($statusVerifikasi == '-')
            <div class="modal-footer">
                {{ Form::open(['route' => 'verify-payment', 'style' => 'width:100%;']) }}
                    {{ Form::hidden('pembayaran_id', $peserta['Payment']['id']) }}
                    <div class="row justify-content-between">
                        <div class="col">
                            <button type="submit" class="btn btn-success" name="status" value="1">Confirm</button>
                        </div>
                        <div class="col">
                            <button type="submit" class="btn btn-danger float-right" name="status" value="-1">Deny</button>
                        </div>
                    </div>
                {{ Form::close() }}
            </div>
            @endif
        </div>
    </div>
</div>