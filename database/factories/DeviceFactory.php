<?php

namespace Database\Factories;

use App\Models\Device;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\Factory;

class DeviceFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Device::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
          'type' => ['Image', 'Video', 'SMS', 'Mail', 'IOT', 'Database', 'LyndaFunction'][rand(0, 6)],         
          'region' =>  [  "Central", "North-West", "Northern", "South-East", "South-West"][rand(0, 4)],
          'location' => $this->faker->postcode,
          'name' => $this->faker->company,          
        ];
    }
}
