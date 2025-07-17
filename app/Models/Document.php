<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Document extends Model
{
    use HasFactory;

    // Specify the table if the model name doesn't match the table name
    protected $table = 'documents';

    // Define fillable fields (fields that can be mass assigned)
    protected $fillable = [
        'user_id',
        'folder_id',
        'file_name',
        'file_path',
        'file_category',
        'researcher',
        'created_at',
        'download_count',
    ];

    // If your table does not have timestamps (created_at, updated_at), you can disable them
    public $timestamps = true;

public function folder()
{
    return $this->belongsTo(Folder::class, 'folder_id');
}
}