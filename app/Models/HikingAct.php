<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;

class HikingAct extends Authenticatable
{
    use HasFactory;

    protected $table = "activity_logs";
    protected $primaryKey = 'activity_id'; 
    public $timestamps = false;

    protected $fillable = [
        'act_name',
        'desc',
        'act_picture',
        'org_id',
    ];

    protected $casts = [
        'act_picture' => 'array',
    ];
}
