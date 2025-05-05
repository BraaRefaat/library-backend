<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Str;

class Book extends Model
{
    use HasFactory;

    protected $primaryKey = 'book_id';
    protected $keyType = 'string';
    public $incrementing = false;

    protected $fillable = [
        'book_id',
        'B_title',
        'B_Author',
        'language',
        'AddBy',
        'DateAdd',
        'views',
    ];

    protected $casts = [
        'DateAdd' => 'date',
    ];

    /**
     * Boot function from laravel.
     */
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            if (empty($model->book_id)) {
                // Generate a book ID with format: BK + timestamp + 4 random characters
                $count = self::count() + 1;
                $model->book_id = 'BK' . str_pad($count, 6, '0', STR_PAD_LEFT) . substr(uniqid(), -4);
            }
        });
    }

    public function author(): BelongsTo
    {
        return $this->belongsTo(Author::class);
    }
}
