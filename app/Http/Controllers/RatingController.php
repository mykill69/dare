<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Rating;
use App\Models\Document;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;


class RatingController extends Controller
{
  public function rate(Request $request)
{
    $request->validate([
        'document_id' => 'required|exists:documents,id',
        'rating' => 'required|integer|min:1|max:5',
    ]);

    $ratingQuery = Rating::where('document_id', $request->document_id);

    if (auth()->check()) {
        $ratingQuery->where('user_id', auth()->id());
    } else {
        $ratingQuery->where('ip_address', $request->ip());
    }

    $existing = $ratingQuery->first();

    if ($existing) {
        $existing->update(['rating' => $request->rating]);
    } else {
        Rating::create([
            'document_id' => $request->document_id,
            'user_id' => auth()->id(),
            'ip_address' => $request->ip(),
            'rating' => $request->rating,
        ]);
    }

    return back();
}
}
