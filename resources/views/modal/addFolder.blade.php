<div class="modal fade" id="modal-sm">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <form action="{{ route('folders.storeFolder') }}" method="POST">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title" id="createFolderModalLabel">Create Folder</h5>
                    <button type="button" class="close text-right" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="input-group mb-3">
                        <div class="input-group-prepend">
                            <span class="input-group-text"><i class="fas fa-folder"></i></span>
                        </div>
                        <input type="text" class="form-control" name="folder_name" placeholder="Folder Name" required>
                    </div>

                    {{-- <div class="input-group mb-3">
                        <div class="input-group-prepend">
                            <span class="input-group-text"><i class="fa fa-list-alt"></i></span>
                        </div>
                        <input type="text" class="form-control" name="folder_category" placeholder="Category" required>
                        <input type="hidden" class="form-control" name="user_access" value="All">
                    </div> --}}
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-success">Create Folder</button>
                </div>
            </form>
        </div>
    </div>
</div>
