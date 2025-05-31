<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PasswordReset extends Model
{
    protected $table = 'password_reset_tokens';

    protected $primaryKey = 'U_Mail';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'U_Mail',
        'token',
        'created_at'
    ];

    public $timestamps = false;
}
