<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Rules_Regulation extends Model
{
    use HasFactory;

    protected $table = "rules_regulation";
    protected $primaryKey = 'rules_id'; 
    public $timestamps = false;

    protected $fillable = [
        'rules_n_regulation',
        'org_id',
    ];
}
