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
    $query = $request->input('query');
    
    // Total number of documents
    $docCount = Document::count();

    // Total number of downloads
    $totalDownloads = Document::sum('download_count');

    // Document search logic
    $searchResults = Document::with('folder');

    if ($query) {
        $searchResults = $searchResults->where('file_name', 'like', "%{$query}%");
    }
    
    $searchResults = $searchResults->get();

    // Pass both counts to the view
    return view('guest.indexGuest', compact('searchResults', 'docCount', 'totalDownloads'));
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

  public function viewPdfGuest($file_name)
{
    $decodedFileName = urldecode($file_name);

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

public function downloadPdfGuest($file_name)
{
    $decodedFileName = urldecode($file_name);

    $document = Document::where('file_name', $decodedFileName)->first();

    if (!$document) {
        return redirect()->back()->with('error', 'Document not found.');
    }

    $filePath = storage_path('app/' . $document->file_path);

    if (!file_exists($filePath)) {
        return redirect()->back()->with('error', 'File not found on server.');
    }

    // Increment the download count
    $document->increment('download_count');

    return response()->download($filePath, $document->file_name);
}



}
