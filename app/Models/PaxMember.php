<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PaxMember extends Model
{
    use HasFactory;

    protected $table = "pax_member";
    protected $primaryKey = 'pax_member_ID'; 
    public $timestamps = false;

    protected $fillable = [
        'member_name',
        'age',
        'gender',
        'pax_info_id',
    ];
}
