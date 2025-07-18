<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Folder; // Assuming your folder model is named DocFolder
use App\Models\Document;
use App\Models\Office;
use App\Models\Rating;

class GuestController extends Controller
{
    public function indexGuest(Request $request)
{
    $query = $request->input('query');
    
    $docCount = Document::count();
    $totalDownloads = Document::sum('download_count');
    $totalViews = Document::sum('view_count');

    // Calculate average rating
    $averageRating = Rating::avg('rating');
    $averageRating = round($averageRating, 2); // optional rounding

    $searchResults = Document::with('folder');

    if ($query) {
        $searchResults = $searchResults->where('file_name', 'like', "%{$query}%");
    }

    $searchResults = $searchResults->get();

    return view('guest.indexGuest', compact('searchResults', 'docCount', 'totalDownloads', 'totalViews', 'averageRating'));
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

    // Increment the view count
    $document->increment('view_count');

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
