<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FileHandlingModule_model extends Model
{
    use HasFactory;
    protected $table = 'client_details';

    protected $fillable = [
        'id',
        'unique_id',
        'date_of_installation',
        'seal_name',
        'installed_at',
        'type',
        'use',
        'client',
    ];
}
