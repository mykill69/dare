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
                    <div class="col-md-2">
                        <!-- Add User Button -->
                        <div class="container">
                            <button class="btn bg-primary dropdown-item btn btn-default" data-toggle="modal"
                                data-target="#modal-user">
                                <i class="fa fa-plus"></i> Add User
                            </button>
                        </div>
                        {{-- Show edit form only if user is being edited --}}
                        @include('users.editUser')
                    </div>
                    <div class="col-md-10">
                        <div class="card card-success card-outline p-1">
                            <div class="card-body folder-grid">
                                <!-- Folder Grid -->
                                <div class="row">
                                    <div class="table-responsive">
                                        <table id="example1" class="table table-hover table-sm text-sm">
                                            <thead>
                                                <tr>
                                                    <th>No.</th>
                                                    <th>First Name</th>
                                                    <th>Middle Name</th>
                                                    <th>Last Name</th>
                                                    <th>Username</th>
                                                    <th>Department</th>
                                                    <th>Role</th>
                                                    <th>Date Created</th>
                                                    <th>Action</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @php $no = 1; @endphp
                                                @foreach ($users as $user)
                                                    <tr>
                                                        <td>{{ $no++ }}.</td>
                                                        <td>{{ $user->fname }}</td>
                                                        <td>{{ $user->mname }}</td>
                                                        <td>{{ $user->lname }}</td>
                                                        <td class="text-bold">{{ $user->username }}</td>
                                                        <td>{{ $user->department }}</td>
                                                        <td>
                                                            <p class="badge badge-warning" style="font-size: 9px;">
                                                                {{ $user->role }}</p>
                                                        </td>
                                                        <td>{{ $user->updated_at }}</td>
                                                        <td>

                                                            <div class="btn-group w-100">
                                                                {{-- <a href="{{ route('userEdit', $user->id) }}"
                                                                    class="btn btn-primary"
                                                                    style="text-decoration: none; color: white;">
                                                                    <i class="fas fa-pen"></i>
                                                                </a> --}}
                                                                <a href="{{ route('userEdit', $user->id) }}"
                                                                    class="btn btn-primary">
                                                                    <i class="fas fa-pen"></i>
                                                                </a>
                                                                {{-- <form action="{{ route('users.deleteUser', $user->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this user?');">
                                                            @csrf
                                                            
                                                            @method('DELETE') --}}
                                                                <a href="javascript:void(0);"
                                                                    onclick="deleteUser('{{ route('users.deleteUser', $user->id) }}')"
                                                                    class="btn btn-danger no-left-radius">
                                                                    <i class="fas fa-trash"></i>
                                                                </a>
                                                                {{-- </form> --}}
                                                            </div>


                                                        </td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection


<script>
    function deleteUser(url) {
        if (confirm('Are you sure you want to delete this user?')) {
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


@include('modal/addUser')
