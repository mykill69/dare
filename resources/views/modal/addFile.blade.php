<div class="modal fade" id="modal-file">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <form action="{{ route('storeFile') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-header bg-success text-white">
                    <h5 class="modal-title" id="createFolderModalLabel">Add New Research File</h5>
                    <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                <div class="modal-body">
                    <!-- Folder Name (Read-only) -->
                    <div class="form-group">
                        <label for="folder" class="font-weight-bold">Folder</label>
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text bg-secondary text-white"><i class="fa fa-folder"></i></span>
                            </div>
                            <input type="text" class="form-control" value="{{ $folder->folder_name }}" readonly>
                        </div>
                    </div>

                    <!-- Researcher/s -->
                    <div class="form-group">
                        <label for="researcher" class="font-weight-bold">Researcher/s</label>
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text bg-secondary text-white"><i class="fa fa-users"></i></span>
                            </div>
                            <textarea class="form-control" name="researcher" rows="2" placeholder="Enter researcher names" required></textarea>
                        </div>
                    </div>

                    <!-- PDF Upload -->
                    <div class="form-group">
                        <label for="file_name" class="font-weight-bold">Upload PDF File</label>
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text bg-secondary text-white"><i class="fas fa-file-alt"></i></span>
                            </div>
                            <input type="file" class="form-control" name="file_name" accept=".pdf" required>
                            <input type="hidden" name="folder_id" value="{{ $folder->id }}">
                        </div>
                    </div>

                    <!-- Description -->
                    <div class="form-group">
                        <label for="description" class="font-weight-bold">Description</label>
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text bg-secondary text-white"><i class="fa fa-list-alt"></i></span>
                            </div>
                            <textarea class="form-control" name="description" rows="3" placeholder="Brief description of the research..." required></textarea>
                        </div>
                    </div>
                </div>

                <div class="modal-footer justify-content-between">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">
                        <i class="fas fa-times"></i> Cancel
                    </button>
                    <button type="submit" class="btn btn-success">
                        <i class="fas fa-upload"></i> Submit
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
