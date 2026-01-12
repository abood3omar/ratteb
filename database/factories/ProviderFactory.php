<?php

namespace Database\Factories;

use App\Models\Category;
use Illuminate\Database\Eloquent\Factories\Factory;

class ProviderFactory extends Factory
{
    public function definition(): array
    {
        $cities = ['عمان', 'الزرقاء', 'إربد', 'العقبة', 'السلط', 'مادبا', 'الكرك', 'جرش', 'عجلون', 'المفرق'];
        $isFreelance = $this->faker->boolean(30);

        return [
            'category_id' => Category::inRandomOrder()->first()->id ?? Category::factory(),
            'name_ar' => $this->faker->company(), 
            'name_en' => $this->faker->company(),
            'phone' => '07' . $this->faker->randomElement(['9', '8', '7']) . $this->faker->randomNumber(7, true),
            'email' => $this->faker->unique()->safeEmail(),
            'city' => $this->faker->randomElement($cities),
            'is_freelance' => $isFreelance,
            'location_link' => $isFreelance ? null : 'https://goo.gl/maps/' . $this->faker->regexify('[A-Za-z0-9]{10}'),
        ];
    }
}