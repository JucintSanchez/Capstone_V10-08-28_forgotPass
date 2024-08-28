<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CancelReq extends Model
{
    use HasFactory;

    protected $table = "cancellation_req";
    protected $primaryKey = 'cancellation_id'; 
    public $timestamps = false;

    protected $fillable = [
        'reason',
        'status',
        'created_at',
        'pax_info_id',
    ];
}
