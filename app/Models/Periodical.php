<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Periodical extends Model
{
    use HasFactory;

    protected $primaryKey = 'D_ID';

    protected $fillable = [
        'D_title',
        'D_Author',
        'AddBy',
        'Num_magazine',
        'name_magazine',
        'Magazine_folder',
        'year',
        'D_number',
        'D_notes',
        'DateAdd',
    ];

    protected $casts = [
        'DateAdd' => 'date',
        'year' => 'integer',
    ];
}
