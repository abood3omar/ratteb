<?php

namespace Database\Factories;

use App\Models\Provider;
use Illuminate\Database\Eloquent\Factories\Factory;

class ServiceFactory extends Factory
{
    public function definition(): array
    {
        $services = [
            'ar' => ['قاعة الملوك', 'جلسة تصوير زفاف', 'بوفيه مفتوح VIP', 'زفة فلسطينية', 'دي جي وإضاءة', 'تأجير ليموزين', 'تزيين كوشة', 'كيكة 5 طوابق'],
            'en' => ['Kings Hall', 'Wedding Photoshoot', 'VIP Buffet', 'Zaffa Group', 'DJ & Light', 'Limo Rental', 'Kosha Design', '5-Layer Cake']
        ];
        
        $index = array_rand($services['ar']);
        $unit = $this->faker->randomElement(['fixed', 'per_hour', 'per_person']);
        $price = $unit == 'fixed' ? $this->faker->numberBetween(500, 2000) : $this->faker->numberBetween(10, 50);

        return [
            'provider_id' => Provider::inRandomOrder()->first()->id ?? Provider::factory(),
            'name_ar' => $services['ar'][$index] . ' ' . $this->faker->numberBetween(1, 10),
            'name_en' => $services['en'][$index] . ' ' . $this->faker->numberBetween(1, 10),
            'price' => $price,
            'price_unit' => $unit,
            'capacity' => str_contains($services['ar'][$index], 'قاعة') ? $this->faker->numberBetween(200, 600) : null,
            'description' => $this->faker->paragraph(),
            'image' => null, 
        ];
    }
}