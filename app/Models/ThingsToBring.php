<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ThingsToBring extends Model
{
    use HasFactory;

    protected $table = "things_to_bring";
    protected $primaryKey = 'things_id'; 
    public $timestamps = false;

    protected $fillable = [
        'item_name',
        'org_id',
    ];
}
