<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Folder;
use App\Models\Office;

class FoldersController extends Controller
{
    public function storeFolder(Request $request)
    {
        // Validate the form data
        $validated = $request->validate([
            'folder_name' => 'required|string|max:255',
            'folder_category' => 'required|string|max:255',
            'user_access' => 'required|string|max:255',

        ]);

        // Create the folder and save it in the 'doc_folder' table
        $folder = new Folder();
        $folder->folder_name = $request->folder_name;
        $folder->folder_category = $request->folder_category;
        $folder->user_access = $request->user_access;

        $folder->save();

        // Redirect to a relevant page with a success message
        return redirect()->back()->with('success', 'Folder created successfully!');
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
public function rename(Request $request, $id)
{
    $request->validate([
        'folder_name' => 'required|string|max:255',
    ]);

    $folder = Folder::findOrFail($id);
    $folder->folder_name = $request->input('folder_name');
    $folder->save();

    return redirect()->route('folders')->with('success', 'Folder renamed successfully.');
}

}
