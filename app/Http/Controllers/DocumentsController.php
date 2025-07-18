<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;
use App\Models\Folder; 
use App\Models\Document;
use App\Models\Office;

class DocumentsController extends Controller
{

    public function index(Request $request)
    {
        $searchResults = [];

        // If a search query exists, perform the search
        if ($request->has('query')) {
            $searchQuery = $request->input('query');
            
            $searchResults = Document::whereRaw('LOWER(file_name) LIKE ?', ['%' . strtolower($searchQuery) . '%'])  
        ->with('folder') // Eager load the related folder
        ->get();
        }

        // Return the view with the search results (if any)
        return view('menu.index', compact('searchResults'));
    }

    public function search(Request $request)
    {
        $query = $request->input('query'); // Get the search query

        $searchResults = Document::where('file_name', 'like', "%{$query}%")
        ->with('folder') // Eager load the related folder
        ->get();

        // Return the view with the search results
        return view('menu.index', compact('searchResults'));
    }

    public function documentView($folderId)
{
    // Fetch documents by folder ID
    $folder = Folder::find($folderId); // Assuming you have a Folder model
    $documents = Document::where('folder_id', $folderId)->get();  // Filter documents by folder_id
    $offices = Office::all();

    return view('menu.documentView', compact('folder', 'documents','offices'));
}


public function storeFile(Request $request)
{
    $request->validate([
        'file_name' => 'required|file|mimes:pdf',
        'folder_id' => 'required|integer',
        'researcher' => 'required|string|max:255',
        'description' => 'required|string|max:255',
    ]);

    if ($request->hasFile('file_name')) {
        // Get folder info
        $folder = Folder::findOrFail($request->folder_id);
        $folderName = $folder->folder_name; // Use original folder name with spaces

        $file = $request->file('file_name');
        $originalName = $file->getClientOriginalName();
        $fileName = $originalName;

        // Store inside 'folders/{folderName}/'
        $filePath = $file->storeAs("folders/{$folderName}", $fileName);

        // Save to DB
        $document = new Document();
        $document->file_name = $fileName;
        $document->folder_id = $request->folder_id;
        $document->file_path = $filePath;
        $document->description = $request->description;
        $document->researcher = $request->researcher;
        $document->user_id = auth()->user()->id;
        $document->save();

        return redirect()->back()->with('success', 'File uploaded and saved successfully.');
    }

    return redirect()->back()->with('error', 'File upload failed.');
}

public function editFile($id)
{
    $editDocument = Document::findOrFail($id);
    $folders = Folder::all(); // for the dropdown
    $documents = Document::where('folder_id', $editDocument->folder_id)->get();
    $folder = Folder::find($editDocument->folder_id);
    $offices = Office::all();

    return view('menu.documentView', compact('editDocument', 'folders', 'documents', 'folder', 'offices'));
}


public function updateFile(Request $request, $id)
{
    $request->validate([
        'description' => 'required|string|max:255',
        'researcher' => 'required|string|max:255',
        'folder_id' => 'required|integer',
    ]);

    $document = Document::findOrFail($id);
    $document->description = $request->description;
    $document->researcher = $request->researcher;
    $document->folder_id = $request->folder_id;
    $document->save();

    return redirect()->route('documentView', $document->folder_id)->with('success', 'Document updated successfully.');
}



public function viewPdf($file_name)
{
    $decodedFileName = urldecode($file_name);

    // Find the document based on the exact file_name (case-insensitive for safety)
    $document = Document::where('file_name', $decodedFileName)->first();

    if (!$document) {
        return redirect()->back()->with('error', 'Document not found.');
    }

    $filePath = storage_path('app/' . $document->file_path);

    if (!file_exists($filePath)) {
        return redirect()->back()->with('error', 'File not found on server.');
    }

    return response()->file($filePath);
}





public function destroy($id)
{
    // Retrieve the document by ID
    $document = Document::find($id);

    if (!$document) {
        return redirect()->back()->with('error', 'Document not found.');
    }

    // Use the exact path from database (e.g., 'folders/FolderName/file.pdf')
    $filePath = $document->file_path;

    // Delete the file from storage
    if (Storage::exists($filePath)) {
        Storage::delete($filePath);
    }

    // Delete the record from the database
    $document->delete();

    return redirect()->back()->with('success', 'Document deleted successfully.');
}


}
