<div class="container mt-2">
    <div class="card">
        <div class="card-header bg-success text-white">
            <h5 class="mb-0">Edit User</h5>
        </div>
        <div class="card-body">
            <form action="{{ isset($editUser) ? route('userUpdate', $editUser->id) : '#' }}" method="POST">
                @csrf
                @if (isset($editUser))
                    @method('PUT')
                @endif

                <div class="form-group">
                    <label>Username</label>
                    <input type="text" name="username" class="form-control"
                        value="{{ isset($editUser) ? $editUser->username : '' }}">
                </div>

                <div class="form-group">
                    <label>First Name</label>
                    <input type="text" name="fname" class="form-control"
                        value="{{ isset($editUser) ? $editUser->fname : '' }}">
                </div>

                <div class="form-group">
                    <label>Middle Name</label>
                    <input type="text" name="mname" class="form-control"
                        value="{{ isset($editUser) ? $editUser->mname : '' }}">
                </div>

                <div class="form-group">
                    <label>Last Name</label>
                    <input type="text" name="lname" class="form-control"
                        value="{{ isset($editUser) ? $editUser->lname : '' }}">
                </div>

                <div class="form-group">
                    <label>Department</label>
                    <select name="department" class="form-control" required>
                        @if (isset($editUser))
                            <option value="{{ $editUser->department }}" selected>{{ $editUser->department }}</option>
                        @else
                            <option value="" selected disabled>Select Department</option>
                        @endif

                        @foreach ($offices as $office)
                            @if (!isset($editUser) || $office->office_abbr !== $editUser->department)
                                <option value="{{ $office->office_abbr }}">{{ $office->office_name }}</option>
                            @endif
                        @endforeach
                    </select>
                </div>

                <div class="form-group">
                    <label>Role</label>
                    <select name="role" class="form-control" required>
                        @if (isset($editUser))
                            <option value="{{ $editUser->role }}" selected>{{ ucfirst($editUser->role) }}</option>
                        @else
                            <option value="" selected disabled>Select Role</option>
                        @endif

                        @foreach (['Administrator', 'Librarian', 'Staff', 'Research_Admin'] as $role)
                            @if (!isset($editUser) || $role !== $editUser->role)
                                <option value="{{ $role }}">{{ ucfirst(str_replace('_', ' ', $role)) }}
                                </option>
                            @endif
                        @endforeach
                    </select>
                </div>

                <div class="form-group">
                    <label>New Password <small>(leave blank to keep current)</small></label>
                    <input type="password" name="password" class="form-control" placeholder="Enter new password">
                </div>

                <button type="submit" class="btn btn-success" {{ isset($editUser) ? '' : 'disabled' }}>Update
                    User</button>
                <a href="{{ url()->current() }}" class="btn btn-secondary">Cancel</a>
            </form>

        </div>
    </div>
</div>
