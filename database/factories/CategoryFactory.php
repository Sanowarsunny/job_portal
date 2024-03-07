<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Category>
 */
class CategoryFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => $this->faker->randomElement(['Software Engineer',
            'Web Developer',
            'Data Analyst',
            'UI/UX Designer',
            'Project Manager',
            'Marketing Specialist',
            'Accountant',
            'HR Manager',
            'Sales Representative',
            'Customer Support Specialist',
            'Graphic Designer',
            'Network Administrator',
            'Content Writer',
            'Financial Analyst',
            'Business Analyst',
            'System Administrator',
            'Digital Marketing Manager',
            'Product Manager',
            'Quality Assurance Engineer',
            'Operations Manager',
            'Other'
        ]),
        ];
    }
}
