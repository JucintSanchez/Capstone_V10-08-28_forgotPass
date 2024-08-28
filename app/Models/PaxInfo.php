<?php

namespace App\Models;

use App\Models\GuideInfo;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PaxInfo extends Model
{
    use HasFactory;

    protected $table = "pax_info";
    protected $primaryKey = 'pax_id'; 
    public $timestamps = false;

    protected $fillable = [
        'pax_name',
        'pax_count',
        'hike_date',
        'status',
        'guide_id',
        'hiker_id',
        'act_id',
    ];

    public function guide()
    {
        return $this->belongsTo(GuideInfo::class, 'guide_id');
    }

    public function leader()
    {
        return $this->belongsTo(HikerInfo::class, 'hiker_id');
    }

    public function timeIn()
    {
        return $this->hasOne(TimeIn::class, 'pax_id');
    }

    public function timeOut()
    {
        return $this->hasOne(TimeOut::class, 'pax_id');
    }
    public function members()
{
    return $this->hasMany(PaxMember::class, 'pax_info_id');
}
}
