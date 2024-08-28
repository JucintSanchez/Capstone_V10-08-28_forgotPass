<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;

class HikerInfo extends Authenticatable
{
    use HasFactory;

    protected $table = "hiker_info";
    protected $primaryKey = 'hiker_id'; 
    public $timestamps = false;

    protected $fillable = [
        'last_name',
        'first_name',
        'email',
        'age',
        'contact_num',
        'username',
        'password',
        'org_id',
    ];
}
