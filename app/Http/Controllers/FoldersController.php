<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Folder;
use App\Models\Office;
use App\Models\Document;
use Illuminate\Support\Facades\File; 
use Illuminate\Support\Facades\Storage;


class FoldersController extends Controller
{
    public function storeFolder(Request $request)
{
    // Validate the form data
    $validated = $request->validate([
        'folder_name' => 'required|string|max:255',
        // 'folder_category' => 'required|string|max:255',
        'user_access' => 'nullable|string|max:255',
    ]);

    // Create DB record
    $folder = new Folder();
    $folder->folder_name = $request->folder_name;
    $folder->folder_category = $request->folder_category;
    $folder->user_access = $request->user_access;
    $folder->save();

    // Create a folder inside storage/app/folders
    $path = 'folders/' . $request->folder_name;
    if (!Storage::exists($path)) {
        Storage::makeDirectory($path);
    }

    return redirect()->back()->with('success', 'Folder created and stored successfully!');
}

    public function showFolders()
{
    // Fetch all folder names from the doc_folder table along with the document count
    $folders = Folder::withCount('documents')->get();  // This will include a 'documents_count' attribute for each folder

    // Fetch all offices
    $offices = Office::all();
    
    // Pass the data to the view
    return view('menu.folders', compact('folders', 'offices'));  // Adjust view name accordingly
}

public function destroyFolder($id)
{
    $folder = Folder::find($id);

    if (!$folder) {
        return redirect()->back()->with('error', 'Folder not found.');
    }

    // Delete all documents linked to this folder
    $documents = Document::where('folder_id', $id)->get();

    foreach ($documents as $document) {
        // Make sure this matches your actual stored file structure
        $filePath = 'folders/' . $folder->folder_name . '/' . $document->file_name;

        if (Storage::exists($filePath)) {
            Storage::delete($filePath);
        }

        $document->delete();
    }

    // Now delete the entire folder directory
    $folderPath = 'folders/' . $folder->folder_name;

    if (Storage::exists($folderPath)) {
        Storage::deleteDirectory($folderPath);
    }

    $folder->delete();

    return redirect()->back()->with('success', 'Folder and its documents deleted successfully.');
}


public function rename(Request $request, $id)
{
    $request->validate([
        'folder_name' => 'required|string|max:255',
    ]);

    $folder = Folder::findOrFail($id);
    $oldName = $folder->folder_name;
    $newName = $request->input('folder_name');

    // Rename the folder in storage/app/folders
    $oldPath = 'folders/' . $oldName;
    $newPath = 'folders/' . $newName;

    if (Storage::exists($oldPath)) {
        Storage::move($oldPath, $newPath);
    }

    // Update the folder name in the database
    $folder->folder_name = $newName;
    $folder->save();

    return redirect()->route('folders')->with('success', 'Folder renamed successfully.');
}

}
