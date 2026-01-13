<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MediaFile extends Model
{
    protected $table = 'media_files';
    
    protected $fillable = [
        'file_name',
        'file_path',
        'media_type',
    ];
}
