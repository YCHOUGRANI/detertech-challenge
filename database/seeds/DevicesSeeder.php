<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\{Device, Alarm};

class DevicesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Device::factory()->count(100)->create()->each(function ($device) {
            $device->alarms()->saveMany(Alarm::factory()->count(100)->make());
        });
    }
}
