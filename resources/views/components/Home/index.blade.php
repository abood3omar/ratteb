@extends('components.layout')

@section('title', 'الرئيسية - نَسَق')

@section('content')
    {{-- 1. Hero Section - البطل الرئيسي --}}
    <div class="relative flex flex-col items-center justify-center min-h-[70vh] text-center mb-16">
        {{-- تأثيرات الخلفية الديناميكية --}}
        <div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-[500px] h-[500px] bg-blue-600/20 rounded-full blur-[120px] -z-10 pointer-events-none"></div>

        <div class="space-y-6 max-w-4xl z-10 fade-in-up">
            <div class="inline-flex items-center gap-2 px-4 py-2 rounded-full border border-blue-500/30 bg-blue-950/40 backdrop-blur-md text-blue-300 text-xs font-bold shadow-lg animate-bounce-slow">
                <span class="w-2 h-2 rounded-full bg-blue-400 animate-pulse"></span>
                منصتك الذكية لتنظيم المناسبات في الأردن
            </div>

            <h1 class="text-5xl md:text-7xl font-black text-white tracking-tight leading-tight drop-shadow-2xl">
                نظم مناسبتك <br>
                <span class="text-transparent bg-clip-text bg-cyan-300  drop-shadow-[0_2px_10px_rgba(0,0,0,0.8)]">
                    بذكاء وسهولة
                </span>
            </h1>

            <p class="text-lg text-slate-300 font-medium max-w-2xl mx-auto leading-relaxed opacity-90">
                اكتشف أفضل القاعات، المصورين، وخدمات الضيافة. قارن الأسعار، واحجز باقتك المثالية أو صممها بنفسك في دقائق.
            </p>

            <div class="flex flex-wrap justify-center gap-4 mt-8">
                <a href="{{ route('front.packages.index') }}" 
                   class="px-8 py-4 bg-blue-600 hover:bg-blue-500 text-white rounded-2xl font-bold shadow-lg shadow-blue-900/40 transition transform hover:-translate-y-1">
                    <i class="fa-solid fa-gift mr-2"></i> تصفح الباقات الجاهزة
                </a>
                <a href="{{ route('front.services.index') }}" 
                   class="px-8 py-4 bg-white/5 hover:bg-white/10 text-white border border-white/10 rounded-2xl font-bold backdrop-blur-md transition transform hover:-translate-y-1">
                    <i class="fa-solid fa-layer-group mr-2"></i> تصفح الخدمات الفردية
                </a>
            </div>
        </div>
    </div>

    {{-- 3. تصفح حسب الخدمة --}}
    <section class="py-10">
        <div class="container mx-auto">
            <div class="flex flex-col md:flex-row justify-between items-end mb-8 border-b border-white/5 pb-4">
                <div>
                    <h2 class="text-3xl font-black text-white mb-2 flex items-center gap-2">
                        <span class="w-2 h-8 bg-blue-500 rounded-full"></span>
                        تصفح حسب الخدمة 📂
                    </h2>
                    <p class="text-slate-400">كل ما تحتاجه لمناسبتك في مكان واحد.</p>
                </div>
                <a href="{{ route('front.services.index') }}" class="text-sm text-blue-400 hover:text-white transition mt-4 md:mt-0">
                    عرض كل الخدمات <i class="fa-solid fa-arrow-left mr-1"></i>
                </a>
            </div>

            <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-6 gap-4">
                @php
                    $cats = [
                        ['icon' => 'fa-hotel', 'name' => 'القاعات', 'color' => 'blue'],
                        ['icon' => 'fa-camera', 'name' => 'التصوير', 'color' => 'purple'],
                        ['icon' => 'fa-fan', 'name' => 'الأزهار', 'color' => 'pink'],
                        ['icon' => 'fa-utensils', 'name' => 'الضيافة', 'color' => 'orange'],
                        ['icon' => 'fa-music', 'name' => 'صوتيات', 'color' => 'teal'],
                        ['icon' => 'fa-car', 'name' => 'زفة وسيارات', 'color' => 'red'],
                    ];
                @endphp

                @foreach($cats as $cat)
                    <a href="{{ route('front.services.index') }}" 
                       class="group bg-slate-900/50 hover:bg-slate-800 border border-white/5 hover:border-{{ $cat['color'] }}-500/30 rounded-2xl p-6 flex flex-col items-center gap-4 transition duration-300">
                        <div class="w-14 h-14 rounded-2xl bg-{{ $cat['color'] }}-500/10 text-{{ $cat['color'] }}-400 group-hover:bg-{{ $cat['color'] }}-500 group-hover:text-white flex items-center justify-center text-2xl transition duration-300 shadow-lg group-hover:scale-110">
                            <i class="fa-solid {{ $cat['icon'] }}"></i>
                        </div>
                        <span class="text-slate-300 font-bold group-hover:text-white text-sm">{{ $cat['name'] }}</span>
                    </a>
                @endforeach
            </div>
        </div>
    </section>

    {{-- 4. أحدث الباقات الحصرية --}}
    <section class="py-16">
        <div class="container mx-auto">
            <div class="flex flex-col md:flex-row justify-between items-end mb-10 gap-4">
                <div>
                    <h2 class="text-3xl font-black text-white mb-2 flex items-center gap-2">
                        <span class="w-2 h-8 bg-purple-500 rounded-full"></span>
                        أحدث الباقات الحصرية 🔥
                    </h2>
                    <p class="text-slate-400">باقات متكاملة (قاعة + خدمات) بأسعار توفيرية.</p>
                </div>
                <a href="{{ route('front.packages.index') }}" 
                   class="group flex items-center gap-2 text-white font-bold text-sm bg-blue-600/20 hover:bg-blue-600 px-5 py-3 rounded-xl border border-blue-500/30 transition">
                    عرض كل الباقات 
                    <i class="fa-solid fa-arrow-left group-hover:-translate-x-1 transition-transform"></i>
                </a>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                {{-- باقة 1: الملكية --}}
                <div class="group relative bg-slate-900/60 backdrop-blur-md border border-white/5 rounded-[2.5rem] overflow-hidden hover:-translate-y-2 transition-all duration-500 hover:shadow-2xl hover:shadow-blue-900/20">
                    <div class="h-64 bg-cover bg-center relative group-hover:scale-105 transition duration-700" 
                         style="background-image: url('https://images.unsplash.com/photo-1519741497674-611481863552?q=80&w=2070');">
                        <div class="absolute inset-0 bg-gradient-to-t from-slate-900 via-slate-900/20 to-transparent"></div>
                        <div class="absolute top-4 right-4 bg-white/10 backdrop-blur-md text-white text-xs font-bold px-3 py-1.5 rounded-xl border border-white/20 shadow-lg">
                            <i class="fa-solid fa-crown text-yellow-400 mr-1"></i> زفاف
                        </div>
                    </div>
                    <div class="p-8 relative">
                        <h3 class="text-2xl font-bold text-white mb-2 group-hover:text-blue-400 transition">الباقة الملكية</h3>
                        <p class="text-slate-400 text-sm mb-6 line-clamp-2">شامل القاعة، البوفيه المفتوح لـ 200 شخص، التصوير، وتنسيق الزهور الطبيعية.</p>
                        <div class="flex items-center justify-between border-t border-white/10 pt-4">
                            <div class="flex flex-col">
                                <span class="text-xs text-slate-500 line-through">950 د.أ</span>
                                <span class="text-2xl font-black text-white">750 <span class="text-xs font-normal text-slate-400">د.أ</span></span>
                            </div>
                            <a href="{{ route('front.packages.index') }}" 
                               class="w-12 h-12 rounded-xl bg-blue-600 hover:bg-blue-500 text-white flex items-center justify-center shadow-lg shadow-blue-900/30 transition hover:scale-110">
                                <i class="fa-solid fa-arrow-left"></i>
                            </a>
                        </div>
                    </div>
                </div>

                {{-- باقة 2: النجاح --}}
                <div class="group relative bg-slate-900/60 backdrop-blur-md border border-white/5 rounded-[2.5rem] overflow-hidden hover:-translate-y-2 transition-all duration-500 hover:shadow-2xl hover:shadow-purple-900/20">
                    <div class="h-64 bg-cover bg-center relative group-hover:scale-105 transition duration-700" 
                         style="background-image: url('https://images.unsplash.com/photo-1551818255-e6e10975bc17?q=80&w=1973');">
                        <div class="absolute inset-0 bg-gradient-to-t from-slate-900 via-slate-900/20 to-transparent"></div>
                        <div class="absolute top-4 right-4 bg-white/10 backdrop-blur-md text-white text-xs font-bold px-3 py-1.5 rounded-xl border border-white/20 shadow-lg">
                            <i class="fa-solid fa-graduation-cap text-purple-400 mr-1"></i> تخرج
                        </div>
                    </div>
                    <div class="p-8 relative">
                        <h3 class="text-2xl font-bold text-white mb-2 group-hover:text-purple-400 transition">باقة النجاح</h3>
                        <p class="text-slate-400 text-sm mb-6 line-clamp-2">دي جي محترف، إضاءة، كيكة تخرج، وتصوير فوري للضيوف.</p>
                        <div class="flex items-center justify-between border-t border-white/10 pt-4">
                            <div class="flex flex-col">
                                <span class="text-xs text-slate-500">تبدأ من</span>
                                <span class="text-2xl font-black text-white">250 <span class="text-xs font-normal text-slate-400">د.أ</span></span>
                            </div>
                            <a href="{{ route('front.packages.index') }}" 
                               class="w-12 h-12 rounded-xl bg-purple-600 hover:bg-purple-500 text-white flex items-center justify-center shadow-lg shadow-purple-900/30 transition hover:scale-110">
                                <i class="fa-solid fa-arrow-left"></i>
                            </a>
                        </div>
                    </div>
                </div>

                {{-- باقة 3: استقبال مولود --}}
                <div class="group relative bg-slate-900/60 backdrop-blur-md border border-white/5 rounded-[2.5rem] overflow-hidden hover:-translate-y-2 transition-all duration-500 hover:shadow-2xl hover:shadow-pink-900/20">
                    <div class="h-64 bg-cover bg-center relative group-hover:scale-105 transition duration-700" 
                         style="background-image: url('https://images.unsplash.com/photo-1519689680058-324335c77eba?q=80&w=2070');">
                        <div class="absolute inset-0 bg-gradient-to-t from-slate-900 via-slate-900/20 to-transparent"></div>
                        <div class="absolute top-4 right-4 bg-white/10 backdrop-blur-md text-white text-xs font-bold px-3 py-1.5 rounded-xl border border-white/20 shadow-lg">
                            <i class="fa-solid fa-baby text-pink-400 mr-1"></i> ولادة
                        </div>
                    </div>
                    <div class="p-8 relative">
                        <h3 class="text-2xl font-bold text-white mb-2 group-hover:text-pink-400 transition">استقبال مولود</h3>
                        <p class="text-slate-400 text-sm mb-6 line-clamp-2">تزيين غرفة المستشفى، ضيافة شوكولاتة فاخرة، وتوزيعات هدايا.</p>
                        <div class="flex items-center justify-between border-t border-white/10 pt-4">
                            <div class="flex flex-col">
                                <span class="text-xs text-slate-500">سعر خاص</span>
                                <span class="text-2xl font-black text-white">180 <span class="text-xs font-normal text-slate-400">د.أ</span></span>
                            </div>
                            <a href="{{ route('front.packages.index') }}" 
                               class="w-12 h-12 rounded-xl bg-pink-600 hover:bg-pink-500 text-white flex items-center justify-center shadow-lg shadow-pink-900/30 transition hover:scale-110">
                                <i class="fa-solid fa-arrow-left"></i>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- 5. لماذا نَسَق؟ (الميزات) --}}
    <section class="py-16 relative">
        <div class="bg-gradient-to-br from-blue-950/40 to-slate-900/40 rounded-[3rem] border border-white/5 p-8 md:p-16 text-center backdrop-blur-sm shadow-2xl relative overflow-hidden">
            <div class="absolute top-0 right-0 w-64 h-64 bg-blue-500/10 rounded-full blur-[80px] -z-10"></div>
            <div class="absolute bottom-0 left-0 w-64 h-64 bg-purple-500/10 rounded-full blur-[80px] -z-10"></div>

            <h2 class="text-3xl font-black text-white mb-12">
                لماذا تختار 
                <span class="text-blue-500 relative inline-block">
                    نَسَق
                    <svg class="absolute w-full h-2 bottom-0 left-0 text-blue-500 opacity-40" viewBox="0 0 100 10" preserveAspectRatio="none">
                        <path d="M0 5 Q 50 10 100 5" stroke="currentColor" stroke-width="2" fill="none" />
                    </svg>
                </span>؟
            </h2>

            <div class="grid grid-cols-1 md:grid-cols-4 gap-8 mb-16">
                <div class="p-4 group">
                    <div class="w-20 h-20 bg-slate-800 rounded-3xl flex items-center justify-center text-blue-400 text-3xl mb-6 border border-white/5 group-hover:scale-110 group-hover:bg-blue-600 group-hover:text-white transition duration-300 shadow-xl mx-auto rotate-3 group-hover:rotate-0">
                        <i class="fa-solid fa-calculator"></i>
                    </div>
                    <h3 class="text-lg font-bold text-white mb-2">حساب تلقائي</h3>
                    <p class="text-slate-400 text-sm">وداعاً للمفاجآت المالية، احسب تكلفة مناسبتك بدقة.</p>
                </div>

                <div class="p-4 group">
                    <div class="w-20 h-20 bg-slate-800 rounded-3xl flex items-center justify-center text-purple-400 text-3xl mb-6 border border-white/5 group-hover:scale-110 group-hover:bg-purple-600 group-hover:text-white transition duration-300 shadow-xl mx-auto -rotate-3 group-hover:rotate-0">
                        <i class="fa-solid fa-sliders"></i>
                    </div>
                    <h3 class="text-lg font-bold text-white mb-2">تخصيص كامل</h3>
                    <p class="text-slate-400 text-sm">باقات مرنة تناسب ذوقك وميزانيتك الخاصة.</p>
                </div>

                <div class="p-4 group">
                    <div class="w-20 h-20 bg-slate-800 rounded-3xl flex items-center justify-center text-pink-400 text-3xl mb-6 border border-white/5 group-hover:scale-110 group-hover:bg-pink-600 group-hover:text-white transition duration-300 shadow-xl mx-auto rotate-3 group-hover:rotate-0">
                        <i class="fa-solid fa-check-double"></i>
                    </div>
                    <h3 class="text-lg font-bold text-white mb-2">خيارات موثوقة</h3>
                    <p class="text-slate-400 text-sm">أفضل المزودين في المملكة تم التحقق منهم.</p>
                </div>

                <div class="p-4 group">
                    <div class="w-20 h-20 bg-slate-800 rounded-3xl flex items-center justify-center text-yellow-400 text-3xl mb-6 border border-white/5 group-hover:scale-110 group-hover:bg-yellow-500 group-hover:text-white transition duration-300 shadow-xl mx-auto -rotate-3 group-hover:rotate-0">
                        <i class="fa-solid fa-shield-halved"></i>
                    </div>
                    <h3 class="text-lg font-bold text-white mb-2">حجز آمن</h3>
                    <p class="text-slate-400 text-sm">نظام حجز وتتبع طلبات سهل وآمن.</p>
                </div>
            </div>
        </div>
    </section>

{{-- 6. آراء العملاء --}}
<section class="py-20 relative overflow-hidden" x-data="{ showRateModal: false }">
    <div class="absolute inset-0 bg-gradient-to-b from-transparent via-blue-900/5 to-transparent pointer-events-none"></div>

    <div class="container mx-auto px-4 mb-12 relative z-10">
        <div class="flex flex-col md:flex-row justify-between items-end gap-4 text-center md:text-right">
            <div>
                <h2 class="text-3xl md:text-4xl font-black text-white mb-2">ماذا يقول عملاؤنا؟ 💬</h2>
                <p class="text-slate-400">قصص نجاح ومناسبات لا تُنسى مع نَسَق.</p>
            </div>
            <div class="flex flex-wrap justify-center gap-3 mx-auto md:mx-0 mb-2">
            {{-- زر التقييم (يظهر فقط للمسجلين) --}}
            @auth
                <button @click="showRateModal = true" class="px-6 py-3 bg-blue-600 hover:bg-blue-500 text-white rounded-xl font-bold transition shadow-lg flex items-center gap-2 mx-auto md:mx-0">
                    <i class="fa-regular fa-star"></i> قيّم تجربتك معنا
                </button>
            @endauth

                        {{-- زر عرض الكل (الجديد) --}}
            <a href="{{ route('reviews.index') }}" class="px-6 py-3 bg-white/5 hover:bg-white/10 text-white border border-white/10 rounded-xl font-bold transition flex items-center gap-2">
                عرض كل التقييمات <i class="fa-solid fa-arrow-left"></i>
            </a>

            </div>
        </div>
    </div>

    {{-- الشريط المتحرك (نفس الكود السابق) --}}
    <div class="relative w-full overflow-hidden mask-linear-fade">
        <div class="flex gap-6 animate-marquee w-max hover:[animation-play-state:paused]">
            @for ($i = 0; $i < 2; $i++) 
                @foreach($reviews as $review)
                    <div class="w-[350px] md:w-[400px] bg-slate-900/60 backdrop-blur-xl p-8 rounded-[2rem] border border-white/5 hover:border-blue-500/30 transition-all duration-300 group select-none">
                        <div class="flex gap-1 mb-4 text-xs">
                            @for ($j = 1; $j <= 5; $j++)
                                <i class="fa-solid fa-star {{ $j <= $review->rating ? 'text-yellow-400' : 'text-slate-700' }}"></i>
                            @endfor
                        </div>
                        <p class="text-slate-300 text-sm leading-relaxed mb-6 italic min-h-[60px]">"{{ $review->comment }}"</p>
                        <div class="flex items-center gap-4 border-t border-white/5 pt-4">
                            <div class="w-12 h-12 rounded-full bg-gradient-to-br from-blue-500/20 to-purple-500/20 flex items-center justify-center font-bold text-lg border border-white/10 text-white shadow-inner">
                                {{ mb_substr($review->user->name, 0, 1) }}
                            </div>
                            <div>
                                <h4 class="text-white font-bold text-sm">{{ $review->user->name }}</h4>
                                <span class="text-xs text-blue-400 bg-blue-500/10 px-2 py-0.5 rounded-full border border-blue-500/10">{{ $review->occasion_type ?? 'عميل مميز' }}</span>
                            </div>
                            <div class="mr-auto text-slate-700 group-hover:text-blue-500/50 transition"><i class="fa-solid fa-quote-left text-2xl"></i></div>
                        </div>
                    </div>
                @endforeach
            @endfor
        </div>
    </div>

    {{-- ======================== --}}
    {{-- مودال التقييم (Popup) --}}
    {{-- ======================== --}}
    <template x-teleport="body">
        <div x-show="showRateModal" x-transition.opacity style="display: none;" class="fixed inset-0 z-[9999] flex items-center justify-center bg-black/90 backdrop-blur-sm p-4">
            
            <div @click.away="showRateModal = false" class="bg-slate-900 border border-white/10 rounded-3xl w-full max-w-lg p-8 shadow-2xl relative animate-scale-up">
                
                <button @click="showRateModal = false" class="absolute top-4 left-4 text-slate-400 hover:text-white transition"><i class="fa-solid fa-xmark text-xl"></i></button>

                <div class="text-center mb-8">
                    <div class="w-16 h-16 bg-blue-600/20 text-blue-500 rounded-full flex items-center justify-center mx-auto mb-4 text-2xl border border-blue-500/30">
                        <i class="fa-solid fa-heart"></i>
                    </div>
                    <h3 class="text-2xl font-black text-white">شاركنا رأيك</h3>
                    <p class="text-slate-400 text-sm mt-2">رأيك يهمنا ويساعدنا على تقديم الأفضل.</p>
                </div>

                <form action="{{ route('reviews.store') }}" method="POST" x-data="{ rating: 0, hoverRating: 0 }">
                    @csrf
                    
                    {{-- نجوم التقييم التفاعلية --}}
                    <div class="flex justify-center gap-2 mb-6" @mouseleave="hoverRating = 0">
                        <template x-for="star in 5">
                            <i class="fa-solid fa-star text-2xl cursor-pointer transition-transform hover:scale-110"
                               :class="(star <= (hoverRating || rating)) ? 'text-yellow-400' : 'text-slate-700'"
                               @mouseenter="hoverRating = star"
                               @click="rating = star">
                            </i>
                        </template>
                        {{-- حقل مخفي لتخزين القيمة وإرسالها للباك إند --}}
                        <input type="hidden" name="rating" :value="rating">
                    </div>

                    <div class="space-y-4">
                        <div>
                            <label class="text-xs font-bold text-slate-400 uppercase mb-2 block">نوع المناسبة (اختياري)</label>
                            <select name="occasion_type" class="w-full bg-slate-950 border border-slate-700 rounded-xl px-4 py-3 text-white focus:border-blue-500 outline-none">
                                <option value="">اختر نوع المناسبة...</option>
                                <option value="حفل زفاف">حفل زفاف</option>
                                <option value="حفل تخرج">حفل تخرج</option>
                                <option value="عيد ميلاد">عيد ميلاد</option>
                                <option value="خدمة عامة">خدمة عامة</option>
                            </select>
                        </div>

                        <div>
                            <label class="text-xs font-bold text-slate-400 uppercase mb-2 block">تعليقك</label>
                            <textarea name="comment" rows="3" required placeholder="اكتب تجربتك هنا..." class="w-full bg-slate-950 border border-slate-700 rounded-xl px-4 py-3 text-white focus:border-blue-500 outline-none resize-none"></textarea>
                        </div>

                        <button type="submit" :disabled="rating === 0" :class="rating === 0 ? 'opacity-50 cursor-not-allowed' : 'hover:bg-blue-500'" class="w-full bg-blue-600 text-white font-bold py-3 rounded-xl transition shadow-lg mt-2">
                            إرسال التقييم
                        </button>
                    </div>
                </form>

            </div>
        </div>
    </template>

</section>

{{-- ستايل الحركة (CSS) --}}
<style>
    @keyframes marquee {
        0% { transform: translateX(0); }
        100% { transform: translateX(50%); } 
    }
    .animate-marquee { animation: marquee 60s linear infinite; }
    .mask-linear-fade { mask-image: linear-gradient(to right, transparent, black 10%, black 90%, transparent); -webkit-mask-image: linear-gradient(to right, transparent, black 10%, black 90%, transparent); }
</style>
@endsection