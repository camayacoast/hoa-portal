<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Subdivision>
 */
class SubdivisionFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'hoa_subd_name'=>$this->faker->name(),
            'hoa_subd_area'=>rand(1,200),
            'hoa_subd_blocks'=>rand(1,200),
            'hoa_subd_lots'=>rand(1,200),
            'hoa_subd_contact_person'=>$this->faker->name(),
            'hoa_subd_contact_number'=>rand(1000,2000)
        ];
    }
}
