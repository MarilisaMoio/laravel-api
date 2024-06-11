<div class="modal" tabindex="-1" id="defDelModal">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Eliminazione Permanente</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p></p>
            </div>
            <div class="modal-footer">
                <form id="delForm" action="{{ route('admin.projects.destroy', $project ) }}" method="POST">
                    @csrf
                    @method('DELETE')

                    <button type="submit" class="btn btn-danger" id="defDelete">Elimina Definitivamente</button>
                </form>
            </div>
        </div>
    </div>
</div>
