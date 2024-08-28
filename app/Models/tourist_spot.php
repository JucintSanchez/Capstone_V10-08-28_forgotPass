<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;

class tourist_spot extends Authenticatable
{
    use HasFactory;

    protected $table = "tourist_spot";
    protected $primaryKey = 'tourist_spot_ID'; 
    public $timestamps = false;

    protected $fillable = [
        'desc',
        'images',
        'org_id',
    ];

    protected $casts = [
        'images' => 'array',
    ];
}
