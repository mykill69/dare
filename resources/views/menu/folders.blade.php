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
                                <h5 class="mb-0 font-weight-bold">All Folders</h5>
                            </div>
                            <div class="col-md-1 text-right">
                                <button type="button" class="btn btn-success btn-sm w-100" data-toggle="modal"
                                    data-target="#modal-sm">
                                    <i class="fas fa-plus mr-1"></i> Folder
                                </button>
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
                                        <span class="badge badge-counter">{{ $folder->documents_count }}</span>

                                        <!-- Folder Link: Only image and name -->
                                        <a href="{{ route('documentView', ['folderId' => $folder->id]) }}"
                                            style="text-decoration: none; color: inherit;">
                                            <img src="https://img.icons8.com/fluency/96/folder-invoices.png" alt="Folder">
                                            <div class="folder-name">{{ $folder->folder_name }}</div>
                                        </a>

                                        <!-- Dropdown outside of <a> -->
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
                                                <a class="dropdown-item text-danger"
                                                    href="{{ route('destroyFolder', $folder->id) }}"
                                                    onclick="event.preventDefault(); confirmDelete({{ $folder->id }});">
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
    @include('modal/addFolder')



    <script>
        function confirmDelete(folderId) {
            Swal.fire({
                title: 'Are you sure?',
                text: "This will permanently delete the folder and its contents.",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#6c757d',
                confirmButtonText: 'Yes, delete it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    // Create a form for DELETE request
                    const form = document.createElement('form');
                    form.method = 'POST';
                    form.action = '{{ route('destroyFolder', ':id') }}'.replace(':id', folderId);

                    const csrf = document.createElement('input');
                    csrf.type = 'hidden';
                    csrf.name = '_token';
                    csrf.value = '{{ csrf_token() }}';

                    const method = document.createElement('input');
                    method.type = 'hidden';
                    method.name = '_method';
                    method.value = 'DELETE';

                    form.appendChild(csrf);
                    form.appendChild(method);
                    document.body.appendChild(form);
                    form.submit();
                }
            });
        }
    </script>



    <script>
        function openRenameModal(folderId, folderName) {
            const form = document.getElementById('renameForm');
            form.action = `{{ route('folders.rename', ':id') }}`.replace(':id', folderId);
            document.getElementById('folderId').value = folderId;
            document.getElementById('folderName').value = folderName;
        }
    </script>
@endsection
