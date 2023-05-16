<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\Device;

class Alarm extends Model
{
    use HasFactory;
    protected $table = 'alarms';

   protected $casts = [
    'params' => 'array',
    'created_at'  => 'datetime:d/m/Y H:i:s',
    'updated_at'  => 'datetime:d/m/Y H:i:s'
];
    
    protected $fillable = [
        'name',
        'params',
        'severity',
        'device_id',
        'created_at'
    ];

    

    public function device()
    {
        return $this->belongsTo(Device::class, 'device_id');
    } 

      
}
