<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TimeOut extends Model
{
    use HasFactory;

    protected $table = "time_out";
    protected $primaryKey = 'out_id'; 
    public $timestamps = false;

    protected $fillable = [
        'time',
        'pax_id',
    ];
}
