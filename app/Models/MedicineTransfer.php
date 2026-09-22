<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MedicineTransfer extends Model
{
    use HasFactory;

    protected $fillable = [
        'type',
        'format',
        'file_path',
        'original_name',
        'status',
        'error',
        'processed',
    ];
}
