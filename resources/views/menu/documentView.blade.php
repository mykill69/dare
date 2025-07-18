<link rel="shortcut icon" type="" href="{{ asset('template/img/CPSU_L.png') }}">
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
            font-size: 14px;
            /* Adjust font size */
        }

        .folder-hover:hover {
            background-color: lightgrey;
            /* bg-primary color */
            cursor: pointer;
            /* Change cursor to pointer on hover */
            transition: background-color 0.3s ease, color 0.3s ease;
            /* Smooth transition for background and text color */
        }
    </style>
    <div class="content-wrapper" style="padding-top:1%;">
        <section class="content">
            <div class="container-fluid">
                <div class="row">
                    {{-- <div class="col-md-3">
                        <div class="container">
                            <button class="btn bg-primary dropdown-item btn btn-default" data-toggle="modal"
                                data-target="#modal-file">
                                <i class="fa fa-plus"></i> Add File
                            </button>

                        </div>
                        @include('menu.editFile', [
                            'editDocument' => $editDocument ?? null,
                            'folders' => $folders ?? [],
                        ])
                    </div> --}}
                    <div class="col-md-3">
                        <!-- Add User Button -->
                        <div class="container">
                            <button class="btn bg-success dropdown-item btn btn-default"data-toggle="modal"
                                data-target="#modal-file">
                                <i class="fa fa-plus"></i> Add Files
                            </button>
                        </div>
                        {{-- Show edit form only if user is being edited --}}
                        @include('menu.editFile', [
                            'editDocument' => $editDocument ?? null,
                            'folders' => $folders ?? [],
                        ])
                    </div>
                    <div class="col-md-9">
                        <div class="card card-success card-outline p-1">
                            <div class="card-body folder-grid">
                                <!-- Folder Name Header -->
                                <div class="row mb-3">
                                    <div class="col-12">
                                        <h5 class="text-success font-weight-bold">
                                            <i class="fa fa-folder-open"></i>
                                            {{ $folder->folder_name ?? 'Folder Name' }}
                                        </h5>
                                        <hr class="mt-1 mb-0" style="border-top: 2px solid #28a745;">
                                    </div>
                                </div>

                                <!-- Table Section -->
                                <div class="row">
                                    <div class="table-responsive">
                                        <table id="example1" class="table table-hover table-sm text-sm">
                                            <thead class="text-center">
                                                <tr>
                                                    <th>TITLE</th>
                                                    <th>DESCRIPTION</th>
                                                    <th>RESEARCHERS</th>
                                                    <th>DATE SUBMITTED</th>
                                                    <th>ACTION</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($documents as $document)
                                                    <tr>
                                                        <!-- Title with PDF icon and link -->
                                                        <td>
                                                            <i class="fas fa-file-pdf text-danger"></i>
                                                            <a href="{{ route('viewPdf', ['file_name' => urlencode($document->file_name)]) }}"
                                                                target="_blank">
                                                                {{ pathinfo($document->file_name, PATHINFO_FILENAME) }}
                                                            </a>
                                                        </td>

                                                        <!-- Description -->
                                                        <td>{{ $document->description ?? 'No short description' }}</td>

                                                        <!-- Researchers -->
                                                        <td>{{ $document->researcher }}</td>

                                                        <!-- Date Submitted -->
                                                        <td>{{ $document->created_at->format('M d, Y') }}</td>

                                                        <!-- Action Buttons -->
                                                        <td>
                                                            <div class="btn-group w-100">
                                                                <!-- Edit Button -->
                                                                <a href="{{ route('editFile', $document->id) }}"
                                                                    class="btn btn-primary btn-sm">
                                                                    <i class="fas fa-edit"></i>
                                                                </a>

                                                                <!-- Delete Button -->
                                                                <a href="javascript:void(0);"
                                                                    onclick="deleteDocument('{{ route('destroy', $document->id) }}')"
                                                                    class="btn btn-danger no-left-radius">
                                                                    <i class="fas fa-trash"></i>
                                                                </a>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div> <!-- /.table-responsive -->
                                </div> <!-- /.row -->
                            </div> <!-- /.card-body -->
                        </div> <!-- /.card -->
                    </div> <!-- /.col-md-9 -->

                </div>
            </div>
        </section>
    </div>
@endsection

<script>
    function deleteDocument(url) {
        if (confirm('Are you sure you want to delete this document and its file?')) {
            // Create a form element
            var form = document.createElement('form');
            form.method = 'POST';
            form.action = url;

            // Add CSRF token input
            var csrfInput = document.createElement('input');
            csrfInput.type = 'hidden';
            csrfInput.name = '_token';
            csrfInput.value = '{{ csrf_token() }}'; // Get the CSRF token
            form.appendChild(csrfInput);

            // Add DELETE method input
            var methodInput = document.createElement('input');
            methodInput.type = 'hidden';
            methodInput.name = '_method';
            methodInput.value = 'DELETE';
            form.appendChild(methodInput);

            // Append the form to the body and submit it
            document.body.appendChild(form);
            form.submit();
        }
    }
</script>


@include('modal/addFile')
