@extends('layouts.main')

@section('body')

<style type="text/css">
	.folder-card {
    background-color: #f8f9fa;
    text-align: center;
    border-radius: 5px;
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
}

.folder-name {
    display: block;
    margin-top: 10px;
    font-weight: bold;
    color: #333;
    font-size: 14px;  /* Adjust font size */
}
.folder-hover:hover {
    background-color: lightgrey; /* bg-primary color */
    cursor: pointer;  /* Change cursor to pointer on hover */
    transition: background-color 0.3s ease, color 0.3s ease; /* Smooth transition for background and text color */
}

</style>

<div class="content-wrapper" style="padding-top:1%;">
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-2">
                    @include('menu/addFile')
                </div>
                <div class="col-md-10">
                    <div class="card card-success card-outline p-1">
                        <div class="card-body folder-grid">
                            <div class="row">
                                @foreach($folders as $folder)
                                <a href="{{ route('documentView', ['folderId' => $folder->id]) }}">
                                <div class="col-md-3 mb-3">
                                     
                                <div class="folder-item">
                                    <div class="folder-card p-3 border text-center folder-hover" style="position: relative;">
   
        <i class="fa fa-folder fa-3x text-success"></i>
        <span class="badge badge-danger badge-counter" style="position: absolute; top: 0; right: 100px; top: 20px; font-size: 0.8rem;">
            {{ $folder->documents_count }}
        </span>
        <div class="folder-name mt-2">{{ $folder->folder_name }}</div> 


    <!-- Ellipsis (three dots) icon for dropdown menu -->
    <div class="dropdown" style="position: absolute; top: 10px; right: 10px;">
        <button class="btn btn-link p-0" type="button" id="folderDropdown{{ $folder->id }}" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            <i class="fas fa-ellipsis-v text-secondary"></i>
        </button>
        <div class="dropdown-menu" aria-labelledby="folderDropdown{{ $folder->id }}">
            <a class="dropdown-item" href="#" 
               data-toggle="modal" 
               data-target="#modal-rename" 
               onclick="openRenameModal({{ $folder->id }}, '{{ $folder->folder_name }}')">
                <i class="fas fa-edit"></i> Rename Folder
            </a>
            <a class="dropdown-item text-danger" href="#" onclick="deleteFolder({{ $folder->id }})">
                <i class="fas fa-trash-alt"></i> Delete Folder
            </a>
        </div>
    </div>
</div>


                                </div>
                                    </a>
                            </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
</div>
@endsection

@include('modal/renameFolder')


<script>
    function openRenameModal(folderId, folderName) {
    const form = document.getElementById('renameForm');
     form.action = `{{ route('folders.rename', ':id') }}`.replace(':id', folderId); // Dynamically replace :id
    document.getElementById('folderId').value = folderId; // Set the folder ID
    document.getElementById('folderName').value = folderName; // Set the folder name in the input
}


</script>