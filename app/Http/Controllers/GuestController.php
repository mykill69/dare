<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Folder; // Assuming your folder model is named DocFolder
use App\Models\Document;
use App\Models\Office;
use App\Models\Rating;
use Illuminate\Support\Facades\DB;

class GuestController extends Controller
{

public function indexGuest(Request $request)
{
    $query = $request->input('query');

    $docCount = Document::count();
    $totalDownloads = Document::sum('download_count');
    $totalViews = Document::sum('view_count');
    $averageRating = Rating::avg('rating');
    $averageRating = round($averageRating, 2);
    $mostViewedResearch = Document::orderByDesc('view_count')->first();
    $mostDownloadedResearch = Document::orderByDesc('download_count')->first();

    // Get top rated document based on average rating
    $topRated = Rating::select('document_id', DB::raw('AVG(rating) as avg_rating'))
        ->groupBy('document_id')
        ->orderByDesc('avg_rating')
        ->first();

    $featuredResearch = null;

    if ($topRated) {
        $document = Document::find($topRated->document_id); // Make sure this returns a record
        if ($document) {
            $document->avg_rating = round($topRated->avg_rating, 2);
            $featuredResearch = $document;
        }
    }

    $searchResults = Document::with('folder');

    if ($query) {
        $searchResults = $searchResults->where('file_name', 'like', "%{$query}%");
    }

    $searchResults = $searchResults->get();

    return view('guest.indexGuest', compact(
        'searchResults',
        'docCount',
        'totalDownloads',
        'totalViews',
        'averageRating',
        'featuredResearch',
        'mostViewedResearch',
        'mostDownloadedResearch'
    ));
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
