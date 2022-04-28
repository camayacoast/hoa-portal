<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Privilege>
 */
class PrivilegeFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'hoa_privilege_package_name'=>$this->faker->title(),
            'hoa_privilege_package_desc'=>$this->faker->word(),
            'hoa_privilege_package_category'=>'Hotel Room',
            'hoa_privilege_package_cost'=>1,
            'hoa_privilege_package_createdby'=>1
        ];
    }
}
