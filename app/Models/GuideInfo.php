<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;

class GuideInfo extends Authenticatable
{
    use HasFactory;

    protected $table = "guide_info";
    protected $primaryKey = 'guide_id'; 
    public $timestamps = false;

    protected $fillable = [
        'last_name',
        'first_name',
        'address',
        'email',
        'contact_num',
        'proof', 
        'status',
        'username',
        'password',
        'org_id',
    ];
}
