
    <button class="btn btn-primary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
        <i class="fa fa-plus"></i> Add New
    </button>

    <div class="dropdown-menu w-100" aria-labelledby="dropdownMenuButton">
        <button class="dropdown-item btn btn-default" data-toggle="modal" data-target="#modal-sm">Create Folder</button>
        <button class="dropdown-item btn btn-default" data-toggle="modal" data-target="#modal-user">Add User</button>
    </div>


{{-- <div class="card card-success card-outline p-1">
	<ul class="nav nav-pills nav-sidebar nav-compact flex-column">
		<li class="nav-item mb-2">
			<a href="{{ route('folders') }}" class="nav-link text-lg  {{ request()->routeIs('folders') ? 'active bg-success' : '' }}" style="text-decoration:none;color: black;">
				<i class="fas fa-folder nav-icon"></i> Folders
			</a>
		</li>
		<li class="nav-item mb-2">
			<a href="{{ route('userView') }}" class="nav-link text-lg {{ request()->routeIs('userView') ? 'active bg-success' : '' }}" style="text-decoration:none;color: black;">
				<i class="fas fa-users nav-icon"></i> Users
			</a>
		</li>
		<li class="nav-item mb-2">
			<a href="#" class="nav-link text-lg" style="text-decoration:none;color: black;">
				<i class="fas fa-file-alt nav-icon"></i> Logs
			</a>
		</li>
	</ul>
</div> --}}

@include('modal/addFolder')
@include('modal/addUser')