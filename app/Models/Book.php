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
    public $timestamps = false; // Disable timestamps

    protected $fillable = [
        'book_id',
        'B_title',
        'B_Author',
        'language',
        'AddBy',
        'DateAdd',
        'year', // Add year to fillable
        'views',
        'image', // Add image to fillable
        'stock', // Add stock to fillable
    ];

    protected $casts = [
        'DateAdd' => 'date',
        'year' => 'integer', // Cast year as integer
        'stock' => 'integer', // Cast stock as integer
    ];

    protected $appends = ['image_url'];

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

    /**
     * Set the user who added this book by storing their U_name
     *
     * @param int $userId The ID of the user who added this book
     * @return void
     */
    public function setAddedByUserId(int $userId): void
    {
        $user = User::find($userId);
        if ($user) {
            $this->AddBy = $user->U_name;
            $this->save();
        }
    }

    /**
     * Get the user who added this book by U_name
     *
     * @return User|null
     */
    public function getAddedByUser()
    {
        return User::where('U_name', $this->AddBy)->first();
    }

    public function getImageUrlAttribute()
    {
        return $this->image ? asset('storage/' . $this->image) : null;
    }
}
