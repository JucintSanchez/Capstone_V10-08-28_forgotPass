<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TimeIn extends Model
{
    use HasFactory;

    protected $table = "time_in";
    protected $primaryKey = 'in_id'; 
    public $timestamps = false;

    protected $fillable = [
        'time',
        'pax_id',
    ];
}
