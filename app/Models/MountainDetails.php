<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MountainDetails extends Model
{
    use HasFactory;

    protected $table = "mountain_details";
    protected $primaryKey = 'mountain_id'; 
    public $timestamps = false;

    protected $fillable = [
        'mountain_name',
        'difficulty',
        'elevation',
        'station',
        'features',
        'overview',
        'org_id',
    ];
}
