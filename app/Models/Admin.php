<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class Admin extends Authenticatable
{
    use HasFactory;
    use Notifiable;
    protected $table = "admin";
    protected $primaryKey = 'admin_id'; 
    public $timestamps = false;

    protected $fillable = [
        'email',
        'username',
        'password',
        'org_id',
    ];
}
