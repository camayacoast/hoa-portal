<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Agent>
 */
class AgentFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'hoa_sales_agent_email'=>$this->faker->email(),
            'hoa_sales_agent_fname'=>$this->faker->firstName(),
            'hoa_sales_agent_lname'=>$this->faker->lastName(),
            'hoa_sales_agent_contact_number'=>rand(1,200),
            'hoa_sales_agent_supervisor'=>$this->faker->name(),
        ];
    }
}
