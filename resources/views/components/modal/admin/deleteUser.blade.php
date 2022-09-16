<div class="modal modal-black fade" role="dialog" id="{{ $modalId }}" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Delete Admin</h5>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
                    <i class="tim-icons icon-simple-remove"></i>
                </button>
            </div>
            <div class="modal-body">
                <p class="text-center">Are you sure you want to delete this admin?</p>
            </div>
            <div class="modal-footer">
                <button class="btn btn-danger" data-dismiss="modal">Cancel</button>
                {{ Form::open(['route' => 'delete-admin']) }}
                    {{ Form::hidden('id', $adminId) }}
                    {{ Form::submit('Confirm', ['class' => 'btn btn-success']) }}
                {{ Form::close() }}
            </div>
        </div>
    </div>
</div>