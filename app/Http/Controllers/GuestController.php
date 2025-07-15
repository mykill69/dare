<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Folder; // Assuming your folder model is named DocFolder
use App\Models\Document;
use App\Models\Office;

class GuestController extends Controller
{
    public function indexGuest(Request $request)
    {
        $searchResults = [];

        // If a search query exists, perform the search
        if ($request->has('query')) {
            $searchQuery = $request->input('query');
            
         // Assuming you are searching in the documents table
    $searchResults = Document::where('file_name', 'like', "%{$query}%")
        ->with('folder') // Eager load the related folder
        ->get();
        }

        // Return the view with the search results (if any)
        return view('guest.indexGuest', compact('searchResults'));
    }

    public function searchGuest(Request $request)
    {
        $query = $request->input('query'); // Get the search query

        // Assuming you are searching in the documents table
    $searchResults = Document::where('file_name', 'like', "%{$query}%")
        ->with('folder') // Eager load the related folder
        ->get();

        // Return the view with the search results
        return view('guest.indexGuest', compact('searchResults'));
    }

    public function viewPdfGuest($id)
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

}
