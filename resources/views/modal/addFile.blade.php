<div class="modal fade" id="modal-file">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <form action="{{ route('storeFile') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title" id="createFolderModalLabel">Add File</h5>
                    <button type="button" class="close text-right" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <!-- Display Folder Name -->
                    <div class="input-group mb-3">
                        <div class="input-group-prepend">
                            <span class="input-group-text"><i class="fa fa-folder"></i></span>
                        </div>
                        <input type="text" class="form-control" value="{{ $folder->folder_name }}" readonly>
                    </div>

                    <div class="input-group mb-3">
                        <div class="input-group-prepend">
                            <span class="input-group-text"><i class="fa fa-users"></i></span>
                        </div>
                        <textarea type="text" class="form-control" name="researcher" placeholder="Researcher Name" rows="2" required>
                        </textarea>
                    </div>

                    <div class="input-group mb-3">
                        <div class="input-group-prepend">
                            <span class="input-group-text"><i class="fas fa-file-alt"></i></span>
                        </div>
                        <input type="file" class="form-control" name="file_name" accept=".pdf" required>
                        <input type="hidden" name="folder_id" value="{{ $folder->id }}">
                    </div>
                    <div class="input-group mb-3">
                        <div class="input-group-prepend">
                            <span class="input-group-text"><i class="fa fa-list-alt"></i></span>
                        </div>
                        <input type="text" class="form-control" name="file_category" placeholder="Category" required>
                    </div>
                </div>
                
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-success">Submit</button>
                </div>
            </form>
        </div>
    </div>
</div>
