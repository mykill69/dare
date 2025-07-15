<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Folder extends Model
{
    use HasFactory;

 protected $table = 'doc_folder';
 // Define fillable fields (fields that can be mass assigned)
    protected $fillable = [
        'folder_name',
        'folder_category',
        'user_access',
    ];


public function documents()
{
    return $this->hasMany(Document::class, 'folder_id');
}
}