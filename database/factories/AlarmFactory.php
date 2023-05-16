<?php

namespace Database\Factories;

use App\Models\Alarm;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\Factory;

class AlarmFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Alarm::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
          //'type' => ['Admin', 'Marketing', 'Phone Call', 'Job', 'Enquiry', 'Quote', 'To Do'][rand(0, 6)],
          'params' => ['param1' => 'value1','param2' => 'value2'],
          'name' => $this->faker->company,  
          'severity' => rand(1,10),
          'path' => 'https://loremflickr.com/320/240?random='.rand(1,100)       
        ];
    }
}
