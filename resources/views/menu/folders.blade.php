@extends('layouts.main')

@section('body')
    <style>
        .folder-grid {
            display: flex;
            flex-wrap: wrap;
            gap: 35px;
            justify-content: flex-start;
        }

        .folder {
            width: 220px;
            text-align: center;
            position: relative;
            transition: transform 0.2s ease;
        }

        .folder:hover {
            transform: translateY(-6px);
            cursor: pointer;
        }

        .folder img {
            width: 100px;
            height: 85px;
            object-fit: contain;
        }

        .folder-name {
            font-size: 17px;
            font-weight: 600;
            margin-top: 12px;
            color: #343a40;
            word-break: break-word;
        }

        .badge-counter {
            position: absolute;
            top: -5px;
            left: 10px;
            background-color: #dc3545;
            color: white;
            font-size: 0.8rem;
            padding: 6px 10px;
            border-radius: 12px;
            font-weight: bold;
        }

        .dropdown {
            position: absolute;
            top: -5px;
            right: 10px;
        }

        .dropdown-menu a:hover {
            background-color: #f8f9fa;
        }
    </style>

    <div class="content-wrapper pt-3">
        <section class="content">
            <div class="container-fluid">
                <div class="card card-outline card-success shadow-sm">
                    <div class="card-header bg-white">
                        <div class="row w-100 align-items-center">
                            <div class="col-md-11">
                                <h5 class="mb-0 font-weight-bold">My Folders</h5>
                            </div>
                            <div class="col-md-1 text-right">
                                @include('menu/addFile')
                            </div>
                        </div>
                    </div>

                    <div class="card-body">
                        <div class="folder-grid">
                            @foreach ($folders as $folder)
                                <a href="{{ route('documentView', ['folderId' => $folder->id]) }}"
                                    style="text-decoration: none;">
                                    <div class="folder">
                                        <!-- Badge -->
                                        <span class="badge badge-counter">
                                            {{ $folder->documents_count }}
                                        </span>

                                        <!-- Folder Image -->
                                        <img src="https://img.icons8.com/fluency/96/folder-invoices.png" alt="Folder">

                                        <!-- Folder Name -->
                                        <div class="folder-name">
                                            {{ $folder->folder_name }}
                                        </div>

                                        <!-- Dropdown -->
                                        <div class="dropdown">
                                            <button class="btn btn-sm btn-link p-0" type="button"
                                                id="dropdownMenu{{ $folder->id }}" data-toggle="dropdown"
                                                aria-haspopup="true" aria-expanded="false">
                                                <i class="fas fa-ellipsis-v text-secondary"></i>
                                            </button>
                                            <div class="dropdown-menu dropdown-menu-right"
                                                aria-labelledby="dropdownMenu{{ $folder->id }}">
                                                <a class="dropdown-item" href="#" data-toggle="modal"
                                                    data-target="#modal-rename"
                                                    onclick="openRenameModal({{ $folder->id }}, '{{ $folder->folder_name }}')">
                                                    <i class="fas fa-edit text-primary mr-2"></i> Rename
                                                </a>
                                                <a class="dropdown-item text-danger" href="#"
                                                    onclick="deleteFolder({{ $folder->id }})">
                                                    <i class="fas fa-trash-alt mr-2"></i> Delete
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </a>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>

    @include('modal/renameFolder')

    <script>
        function openRenameModal(folderId, folderName) {
            const form = document.getElementById('renameForm');
            form.action = `{{ route('folders.rename', ':id') }}`.replace(':id', folderId);
            document.getElementById('folderId').value = folderId;
            document.getElementById('folderName').value = folderName;
        }
    </script>
@endsection
