<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SystemNotif extends Model
{
    use HasFactory;

    protected $table = 'system_notif'; // Ensure this matches your table name
    protected $primaryKey = 'notif_id';
    public $timestamps = false;

    protected $fillable = [
        'notification',
        'hiker_id',
    ];
}
