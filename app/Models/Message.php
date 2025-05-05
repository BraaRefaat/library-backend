<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    use HasFactory;

    protected $primaryKey = 'M_ID';

    protected $fillable = [
        'M_title',
        'M_Author',
        'type',
        'copies',
        'AddBy',
        'DateAdd',
        'M_number',
        'M_notes',
    ];

    protected $casts = [
        'DateAdd' => 'date',
        'copies' => 'integer',
    ];
}
