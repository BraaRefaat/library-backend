<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Message extends Model
{
    use HasFactory;

    protected $primaryKey = 'M_ID';
    public $timestamps = false; // Disable timestamps

    protected $fillable = [
        'M_title',
        'M_Author',
        'type',
        'copies',
        'AddBy',
        'DateAdd',
        'year',
        'M_number',
        'M_notes',
        'department_id',
    ];

    protected $casts = [
        'DateAdd' => 'date',
        'copies' => 'integer',
    ];

    /**
     * Get the department that the message belongs to
     */
    public function department(): BelongsTo
    {
        return $this->belongsTo(Department::class, 'department_id', 'C_ID');
    }

    /**
     * Set the user who added this message by storing their U_name
     *
     * @param int $userId The ID of the user who added this message
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
     * Get the user who added this message by U_name
     *
     * @return User|null
     */
    public function getAddedByUser()
    {
        return User::where('U_name', $this->AddBy)->first();
    }
}
