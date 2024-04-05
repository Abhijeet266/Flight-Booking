<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Login extends Model
{
    use HasFactory;
    protected $table = 'login_user';
    protected $fillable = [
        'usename',
        'email',
        'password',
        'current_password',
    ];


    
}
