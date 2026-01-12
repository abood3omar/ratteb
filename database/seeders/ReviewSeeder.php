<?php

namespace Database\Seeders;

use App\Models\Review;
use App\Models\User;
use Illuminate\Database\Seeder;

class ReviewSeeder extends Seeder
{
    public function run()
    {
        // تأكد من وجود مستخدمين أولاً
        if(User::count() == 0) User::factory(5)->create();
        
        $users = User::all();

        $reviews = [
            [
                'comment' => 'بصراحة الموقع وفر علي وقت وجهد كبير في تجهيز حفلة تخرجي، الباقات كانت ممتازة والتعامل راقي جداً.',
                'occasion_type' => 'حفل تخرج',
                'rating' => 5
            ],
            [
                'comment' => 'حجزت القاعة والضيافة من خلال نَسَق، الأسعار كانت واضحة وما في أي تكاليف مخفية، شكراً لكم.',
                'occasion_type' => 'حفل زفاف',
                'rating' => 5
            ],
            [
                'comment' => 'فكرة الباقات جاهزة ريحتني كثير، خصوصاً إني كنت مستعجل بتجهيز استقبال المولود.',
                'occasion_type' => 'استقبال مولود',
                'rating' => 4
            ],
            [
                'comment' => 'خدمة العملاء جداً متعاونين، ساعدوني اختار المصور الأنسب لميزانيتي.',
                'occasion_type' => 'جلسة تصوير',
                'rating' => 5
            ],
            [
                'comment' => 'تنسيق الزهور كان خيالي، نفس الصورة اللي طلبتها بالضبط.',
                'occasion_type' => 'تنسيق زهور',
                'rating' => 5
            ],
        ];

        foreach ($reviews as $review) {
            Review::create([
                'user_id' => $users->random()->id,
                'rating' => $review['rating'],
                'comment' => $review['comment'],
                'occasion_type' => $review['occasion_type'],
                'show_on_home' => true,
            ]);
        }
    }
}