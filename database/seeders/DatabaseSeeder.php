<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category;
use App\Models\Provider;
use App\Models\Service;
use App\Models\OccasionType;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // تنظيف الجداول
        // DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        // Category::truncate();
        // Provider::truncate();
        // Service::truncate();
        // OccasionType::truncate();
        // DB::table('category_occasion_type')->truncate();
        // DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        // تنظيف مجلد الصور في الستوريج (عشان ما يتعبى عالفاضي)
        Storage::disk('public')->deleteDirectory('services');
        Storage::disk('public')->deleteDirectory('occasions');

        $this->command->info('🇯🇴 جاري تحضير الداتا الأردنية (من مجلد images)...');

        // 1. التصنيفات
        $cats = [
            'hall'   => Category::create(['name_ar' => 'القاعات والفنادق', 'name_en' => 'Halls & Hotels', 'display_order' => 1]),
            'food'   => Category::create(['name_ar' => 'البوفيه والضيافة', 'name_en' => 'Catering & Food', 'display_order' => 2]),
            'photo'  => Category::create(['name_ar' => 'التصوير والمونتاج', 'name_en' => 'Photography', 'display_order' => 3]),
            'zaffa'  => Category::create(['name_ar' => 'الزفات والفرق', 'name_en' => 'Zaffa & Bands', 'display_order' => 4]),
            'flower' => Category::create(['name_ar' => 'تنسيق الزهور', 'name_en' => 'Flowers & Decor', 'display_order' => 5]),
            'car'    => Category::create(['name_ar' => 'تأجير سيارات', 'name_en' => 'Car Rental', 'display_order' => 6]),
        ];

        // 2. الداتا الحقيقية
        $realData = [
            // --- القاعات ---
            [
                'cat' => 'hall', 'name' => 'فندق الرويال', 'city' => 'عمان',
                'services' => [
                    ['name' => 'قاعة قصر الرويال الكبرى', 'price' => 2500, 'img' => 'hall.jpg'],
                    ['name' => 'قاعة عشتار (حفلات صغيرة)', 'price' => 1200, 'img' => 'hall.jpg']
                ]
            ],
            [
                'cat' => 'hall', 'name' => 'قاعات النعمان', 'city' => 'عمان',
                'services' => [
                    ['name' => 'القاعة الماسية', 'price' => 800, 'img' => 'hall.jpg'],
                    ['name' => 'القاعة الذهبية', 'price' => 600, 'img' => 'hall.jpg']
                ]
            ],
            [
                'cat' => 'hall', 'name' => 'فندق الإنتركونتيننتال', 'city' => 'العقبة',
                'services' => [
                    ['name' => 'قاعة البحر الأحمر (Open Air)', 'price' => 3000, 'img' => 'hall.jpg']
                ]
            ],
            // --- الأكل ---
            [
                'cat' => 'food', 'name' => 'مطاعم جبري', 'city' => 'عمان',
                'services' => [
                    ['name' => 'بوفيه مفتوح (VIP) - 100 شخص', 'price' => 1500, 'img' => 'food.jpg'],
                    ['name' => 'سدور منسف بلدي (جميد كركي)', 'price' => 250, 'unit' => 'fixed', 'img' => 'food.jpg']
                ]
            ],
            [
                'cat' => 'food', 'name' => 'حلويات حبيبة', 'city' => 'عمان',
                'services' => [
                    ['name' => 'كنافة نابلسية (سدر كبير)', 'price' => 45, 'img' => 'food.jpg']
                ]
            ],
            // --- التصوير ---
            [
                'cat' => 'photo', 'name' => 'ستوديو بابل', 'city' => 'إربد',
                'services' => [
                    ['name' => 'بكج تصوير زفاف كامل (فيديو + فوتو)', 'price' => 400, 'img' => 'photo.jpg'],
                    ['name' => 'جلسة تصوير ستوديو', 'price' => 100, 'img' => 'photo.jpg']
                ]
            ],
            // --- الزفات ---
            [
                'cat' => 'zaffa', 'name' => 'فرقة معان للفنون الشعبية', 'city' => 'عمان',
                'services' => [
                    ['name' => 'زفة أردنية تراثية', 'price' => 200, 'img' => 'zaffa.jpg']
                ]
            ],
             // --- الزهور ---
             [
                'cat' => 'flower', 'name' => 'أليسار للزهور', 'city' => 'عمان',
                'services' => [
                    ['name' => 'تزيين كوشة (Natural Flowers)', 'price' => 500, 'img' => 'flower.jpg']
                ]
            ],
        ];

        foreach ($realData as $data) {
            $provider = Provider::create([
                'category_id' => $cats[$data['cat']]->id,
                'name_ar' => $data['name'],
                'name_en' => 'Provider',
                'phone' => '079' . rand(1000000, 9999999),
                'city' => $data['city'],
                'is_freelance' => false,
                'location_link' => 'http://maps.google.com',
            ]);

            foreach ($data['services'] as $srv) {
                
                // نسخ الصورة من public/images إلى storage/app/public/services
                $imagePath = null;
                $sourcePath = public_path('images/' . $srv['img']); // المسار اللي انت حطيت فيه الصور

                if (File::exists($sourcePath)) {
                    $newFileName = 'services/' . uniqid() . '_' . $srv['img'];
                    Storage::disk('public')->put($newFileName, File::get($sourcePath));
                    $imagePath = $newFileName;
                }

                Service::create([
                    'provider_id' => $provider->id,
                    'name_ar' => $srv['name'],
                    'name_en' => 'Service Name',
                    'price' => $srv['price'],
                    'price_unit' => $srv['unit'] ?? 'fixed',
                    'description' => 'خدمة مميزة واحترافية تضمن لك أفضل تجربة.',
                    'image' => $imagePath,
                ]);
            }
        }

        // 4. إنشاء المناسبات (Occasions)
        
        // تجهيز صور المناسبات
        $weddingImg = $this->copyImageToStorage('wedding.jpg', 'occasions');
        $gradImg = $this->copyImageToStorage('grad.jpg', 'occasions');

        // أ. الزفاف
        $wedding = OccasionType::create([
            'name_ar' => 'حفل زفاف',
            'name_en' => 'Wedding',
            'slug' => 'wedding',
            'description' => 'كل ما تحتاجه لليلة العمر في مكان واحد.',
            'image' => $weddingImg,
        ]);
        $wedding->categories()->attach([
            $cats['hall']->id, $cats['food']->id, $cats['photo']->id, $cats['zaffa']->id, $cats['flower']->id
        ]);

        // ب. التخرج
        $grad = OccasionType::create([
            'name_ar' => 'حفل تخرج',
            'name_en' => 'Graduation',
            'slug' => 'graduation',
            'description' => 'احتفل بإنجازك ونجاحك بأجمل التجهيزات.',
            'image' => $gradImg,
        ]);
        $grad->categories()->attach([$cats['hall']->id, $cats['food']->id, $cats['photo']->id]);

        $this->command->info('✅ تم العملية بنجاح! الصور جاهزة والداتا لوز.');
    }

    // دالة مساعدة لنسخ الصور
    private function copyImageToStorage($fileName, $folder)
    {
        $sourcePath = public_path('images/' . $fileName);
        if (File::exists($sourcePath)) {
            $newFileName = $folder . '/' . uniqid() . '_' . $fileName;
            Storage::disk('public')->put($newFileName, File::get($sourcePath));
            return $newFileName;
        }
        return null;
    }
}