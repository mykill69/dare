<!-- Rename Modal -->
<div class="modal fade" id="modal-rename" tabindex="-1" role="dialog" aria-labelledby="renameFolderModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-md" role="document">
        <div class="modal-content">
            <form id="renameForm" action="{{ route('folders.rename', ':id') }}" method="POST">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title" id="renameFolderModalLabel">Rename Folder</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="input-group mb-3">
                        <div class="input-group-prepend">
                            <span class="input-group-text"><i class="fas fa-folder"></i></span>
                        </div>
                        <input type="hidden" name="folder_id" id="folderId" value="">
                        <input type="text" class="form-control" name="folder_name" id="folderName" placeholder="Folder Name" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-success">Rename Folder</button>
                </div>
            </form>
        </div>
    </div>
</div>
