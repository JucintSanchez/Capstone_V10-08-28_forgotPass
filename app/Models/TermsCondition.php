<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TermsCondition extends Model
{
    use HasFactory;

    protected $table = "terms_condition";
    protected $primaryKey = 'terms_id'; 
    public $timestamps = false;

    protected $fillable = [
        'terms_and_condition',
        'org_id',
    ];
}
