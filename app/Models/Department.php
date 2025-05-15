<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Department extends Model
{
    use HasFactory;

    protected $primaryKey = 'C_ID';

    protected $fillable = [
        'C_name',
    ];

    /**
     * Get the messages that belong to the department
     */
    public function messages(): HasMany
    {
        return $this->hasMany(Message::class, 'department_id', 'C_ID');
    }
}
