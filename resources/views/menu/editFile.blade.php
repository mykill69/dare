<div class="container mt-2">
<div class="card">
    <div class="card-header bg-default text-black">
        <h5 class="mb-0">{{ isset($editDocument) ? 'Edit File' : 'Edit Panel ' }}</h5>
    </div>
    <div class="card-body">
        <form method="POST"
            action="{{ isset($editDocument) ? route('updateFile', $editDocument->id) : '#' }}">
            @csrf
            @if (isset($editDocument))
                @method('POST') {{-- or PUT if you're using PUT --}}
            @endif

            <div class="form-group">
                <label for="description">Description</label>
                <input type="text" name="description" class="form-control"
                    value="{{ $editDocument->description ?? '' }}" {{ isset($editDocument) ? '' : 'disabled' }}>
            </div>

            <div class="form-group">
                <label for="researcher">Researcher</label>
                <input type="text" name="researcher" class="form-control"
                    value="{{ $editDocument->researcher ?? '' }}" {{ isset($editDocument) ? '' : 'disabled' }}>
            </div>

            <div class="form-group">
                <label for="folder_id">Folder</label>
                <select name="folder_id" class="form-control" {{ isset($editDocument) ? '' : 'disabled' }}>
                    @foreach ($folders as $folder)
                        <option value="{{ $folder->id }}"
                            {{ (isset($editDocument) && $editDocument->folder_id == $folder->id) ? 'selected' : '' }}>
                            {{ $folder->folder_name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <button type="submit" class="btn btn-success" {{ isset($editDocument) ? '' : 'disabled' }}>
                <i class="fas fa-save"></i> Update File
            </button>
            <a href="{{ route('documentView', $editDocument->folder_id ?? request()->route('folderId')) }}"
                class="btn btn-secondary">Cancel</a>
        </form>
    </div>
</div>
</div>