<style>
    .modal-button{
        width: 80px;
    }
    .modal-close{
       margin-left: 95%;
       font-size: 25px
    }
    .row{
        margin:0;
    }
</style>
<div class="modal fade" id="finaliseModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-body" style="padding:1.5rem 3rem 3rem 3rem">
                <span class="modal-close" data-dismiss="modal">&times;</span>
                <p class="text-center" style="font-weight:700; font-size:24px; margin-top:0.5rem;">Apakah anda yakin ingin memfinalisasi jawaban anda?</p>
                <p class="text-center" style="font-weight:600; color:gray; margin-bottom:1.5rem;">Anda tidak dapat mengubah jawaban anda kembali.</p>
                <div class="row justify-content-center">
                    <div class="col-6">
                        {{ Form::open(['route' => 'finalise-answer']) }}
                            {{ Form::hidden('FinaliseToken', $finalisasiToken) }}
                            {{ Form::submit('Iya', ['class' => 'btn btn-success float-right modal-button']) }}
                        {{ Form::close() }}
                    </div>
                    <div class="col-6">
                        <button class="btn btn-secondary modal-button" data-dismiss="modal">Batal</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>