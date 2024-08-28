<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ReschedHike extends Model
{
    use HasFactory;

    protected $table = "reschedule_req";
    protected $primaryKey = 'resched_id'; 
    public $timestamps = false;

    protected $fillable = [
        'resched_date',
        'pax_id',
    ];
}
