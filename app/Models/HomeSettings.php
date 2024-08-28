<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HomeSettings extends Model
{
    use HasFactory;

    protected $table = "home_profile";
    protected $primaryKey = 'home_profile_id'; 
    public $timestamps = false;

    protected $fillable = [
        'landing_photo',
        'about_us',
        'contact_num',
        'email',
        'org_id', 
    ];
}
