<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Journal extends Model
{
    use HasFactory;

    protected $primaryKey = 'D_ID';
    public $timestamps = false; // Disable timestamps

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

    /**
     * Set the user who added this periodical by storing their U_name
     *
     * @param int $userId The ID of the user who added this periodical
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
     * Get the user who added this periodical by U_name
     *
     * @return User|null
     */
    public function getAddedByUser()
    {
        return User::where('U_name', $this->AddBy)->first();
    }
}
