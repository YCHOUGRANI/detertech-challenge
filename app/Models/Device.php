<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\Alarm;

class Device extends Model
{
    use HasFactory;
    protected $table = 'devices';
    
    protected $fillable = [
        'name',
        'location',
        'region',
        'type',        
        'latitude',
        'longitude'
    ];     

    
   
    public function alarms()
    {
       return $this->hasMany(Alarm::class, 'device_id');
    }

   

  
}
