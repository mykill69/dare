<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;
use App\Models\Folder; // Assuming your folder model is named DocFolder
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
            
            $searchResults = Document::where('file_name', 'like', "%{$query}%")
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
    // Validate the request data
    $request->validate([
        'file_name' => 'required|file|mimes:pdf',  // Ensure the file is a PDF and the size is <= 2MB
        'folder_id' => 'required|integer',  // Ensure the folder_id is provided
        'researcher' => 'required|string|max:255',
        'file_category' => 'required|string|max:255',
    ]);

    // Check if a file is uploaded
    if ($request->hasFile('file_name')) {
        // Store the file
        $file = $request->file('file_name');
        $file_name = $file->getClientOriginalName();  // Add a timestamp to the file name
        $filePath = $file->storeAs('documents', $file_name, 'public');  // Store in the 'public/documents' folder

        // Save the document details in the 'documents' table
        $document = new Document();
        $document->file_name = $file_name;
        $document->folder_id = $request->folder_id;  // Store folder ID
        $document->file_path = $filePath;  // Save the file path
        $document->file_category = $request->file_category;
        $document->researcher = $request->researcher;
        $document->user_id = auth()->user()->id;  // Assuming the user is authenticated
        $document->save();

        return redirect()->back()->with('success', 'File uploaded and saved successfully.');
    }

    return redirect()->back()->with('error', 'File upload failed.');
}

public function viewPdf($id)
{
    // Retrieve the document by its ID
    $document = Document::find($id);

    // Check if the document exists
    if (!$document) {
        return redirect()->back()->with('error', 'Document not found.');
    }

    // Build the full file path
    $filePath = storage_path('app/public/' . $document->file_path);

    // Check if the file exists on the server
    if (!file_exists($filePath)) {
        return redirect()->back()->with('error', 'File not found.');
    }

    // Return the PDF file for inline viewing in the browser
    return response()->file($filePath);
}

public function destroy($id)
{
    // Retrieve the document by ID
    $document = Document::find($id);

    // Check if the document exists
    if (!$document) {
        return redirect()->back()->with('error', 'Document not found.');
    }

    // Build the full file path
    $filePath = 'public/' . $document->file_path;  // Ensure 'file_path' contains the relative path like 'documents/file.pdf'

    // Delete the file from the storage folder
    if (Storage::exists($filePath)) {
        Storage::delete($filePath);
    }

    // Delete the record from the database
    $document->delete();

    return redirect()->back()->with('success', 'Document deleted successfully.');
}

}

