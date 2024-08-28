<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Organization extends Model
{
    use HasFactory;

    protected $table = "organization";
    protected $primaryKey = 'org_id'; 
    public $timestamps = false;

    protected $fillable = [
        'org_name',
        'logo',
        'address',
    ];
}
