<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Rating extends Model
{
    use HasFactory;
    
    protected $fillable = ['document_id', 'user_id', 'ip_address', 'rating'];

    public function document()
    {
        return $this->belongsTo(Document::class);
    }
}
