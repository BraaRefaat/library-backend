<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PasswordReset extends Model
{
    protected $table = 'password_reset_tokens';
    public $timestamps = false;
    protected $primaryKey = 'U_Mail';
    protected $fillable = ['U_Mail', 'token', 'created_at'];
}
