<div class="modal modal-black fade" role="dialog" id="nextPhaseModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Lanjut Tahap</h5>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
                    <i class="tim-icons icon-simple-remove"></i>
                </button>
            </div>
            <div class="modal-body">
                <p class="text-center">Apakah anda yakin dengan pilihan peserta anda untuk dilanjutkan ke tahap selanjutnya? Perubahan yang anda lakukan tidak dapat dibalikkan!</p>
            </div>
            <div class="modal-footer">
                {{ Form::submit('Yakin', ['class' => 'btn btn-success']) }}
                <button class="btn btn-danger" data-dismiss="modal">Batal</button>
            </div>
        </div>
    </div>
</div>