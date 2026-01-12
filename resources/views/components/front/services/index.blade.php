@extends('components.layout')

@section('title', 'تصفح الخدمات')

@section('content')
    <div class="container mx-auto px-4 py-8" x-data="{ showMobileFilters: false }">
        {{-- العنوان الرئيسي --}}
        <div class="flex flex-col md:flex-row justify-between items-center mb-8 gap-4 fade-in">
            <div>
                <h1 class="text-3xl font-black text-white">الخدمات المتاحة ✨</h1>
                <p class="text-slate-400 mt-1">اختر الأنسب لمناسبتك من بين مئات الخيارات المميزة.</p>
            </div>
            <button @click="showMobileFilters = !showMobileFilters" 
                    class="lg:hidden bg-slate-800 text-white px-4 py-2 rounded-xl flex items-center gap-2 border border-white/10">
                <i class="fa-solid fa-filter"></i> تصفية
            </button>
        </div>

        <div class="flex flex-col lg:flex-row gap-8 items-start">
            {{-- Sidebar الفلاتر (مخفي على الموبايل افتراضيًا) --}}
            <aside :class="showMobileFilters ? 'block' : 'hidden'" 
                   class="lg:block w-full lg:w-1/4 bg-slate-900/80 backdrop-blur border border-white/5 rounded-2xl p-6 sticky top-24 z-10 transition-all">
                <form action="{{ route('front.services.index') }}" method="GET" class="space-y-6">
                    {{-- البحث السريع --}}
                    <div class="space-y-2">
                        <label class="text-xs font-bold text-slate-400 uppercase">بحث سريع</label>
                        <div class="relative">
                            <input type="text" 
                                   name="search" 
                                   value="{{ request('search') }}" 
                                   placeholder="اسم القاعة، المصور..."
                                   class="w-full bg-slate-950 border border-slate-700 rounded-xl py-2 px-4 text-white focus:border-blue-500 outline-none placeholder-slate-600">
                            <i class="fa-solid fa-magnifying-glass absolute left-3 top-3 text-slate-500"></i>
                        </div>
                    </div>

                    {{-- فلتر التصنيف --}}
                    <div class="space-y-2">
                        <label class="text-xs font-bold text-slate-400 uppercase">التصنيف</label>
                        <div class="space-y-2 max-h-48 overflow-y-auto custom-scrollbar pr-1">
                            <label class="flex items-center gap-2 cursor-pointer group">
                                <input type="radio" 
                                       name="category" 
                                       value="" 
                                       {{ !request('category') ? 'checked' : '' }} 
                                       class="w-4 h-4 bg-slate-900 border-slate-600 text-blue-600 focus:ring-blue-500">
                                <span class="text-sm text-slate-300 group-hover:text-white transition">الكل</span>
                            </label>
                            @foreach($categories as $category)
                                <label class="flex items-center gap-2 cursor-pointer group">
                                    <input type="radio" 
                                           name="category" 
                                           value="{{ $category->id }}" 
                                           {{ request('category') == $category->id ? 'checked' : '' }} 
                                           class="w-4 h-4 bg-slate-900 border-slate-600 text-blue-600 focus:ring-blue-500">
                                    <span class="text-sm text-slate-300 group-hover:text-white transition">{{ $category->name_ar }}</span>
                                </label>
                            @endforeach
                        </div>
                    </div>

                    {{-- فلتر المدينة --}}
                    <div class="space-y-2">
                        <label class="text-xs font-bold text-slate-400 uppercase">المدينة</label>
                        <select name="city" class="w-full bg-slate-950 border border-slate-700 rounded-xl py-2 px-4 text-white outline-none focus:border-blue-500">
                            <option value="">جميع المدن</option>
                            @foreach($cities as $city)
                                <option value="{{ $city }}" {{ request('city') == $city ? 'selected' : '' }}>{{ $city }}</option>
                            @endforeach
                        </select>
                    </div>

                    {{-- زر تطبيق الفلتر --}}
                    <button type="submit" 
                            class="w-full bg-blue-600 hover:bg-blue-500 text-white font-bold py-3 rounded-xl transition shadow-lg shadow-blue-900/20">
                        تطبيق الفلتر
                    </button>

                    {{-- رابط إلغاء الفلاتر --}}
                    @if(request()->filled(['search', 'category', 'city']))
                        <a href="{{ route('front.services.index') }}" 
                           class="block text-center text-xs text-red-400 hover:text-red-300 transition">
                            إلغاء الفلاتر
                        </a>
                    @endif
                </form>
            </aside>

            {{-- المحتوى الرئيسي: كروت الخدمات --}}
            <main class="w-full lg:w-3/4">
                <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-6">
                    @foreach($services as $service)
                        <div class="group bg-slate-900 border border-white/5 rounded-2xl overflow-hidden hover:shadow-2xl hover:border-blue-500/30 transition-all duration-300 hover:-translate-y-1 relative flex flex-col h-full"
                             x-data="{ showDetails: false }">
                            
                            {{-- صورة الخدمة --}}
                            <div class="h-52 relative overflow-hidden bg-slate-950">
                                @if($service->image)
                                    <img src="{{ asset('storage/' . $service->image) }}" 
                                         class="w-full h-full object-cover group-hover:scale-110 transition duration-700">
                                @else
                                    <div class="w-full h-full flex items-center justify-center text-slate-700">
                                        <i class="fa-regular fa-image text-4xl"></i>
                                    </div>
                                @endif
                                <div class="absolute top-3 right-3 bg-slate-900/80 backdrop-blur px-2 py-1 rounded-lg text-[10px] text-white font-bold border border-white/10">
                                    {{ $service->provider->category->name_ar ?? 'خدمة' }}
                                </div>
                            </div>

                            {{-- محتوى الكرت --}}
                            <div class="p-5 flex flex-col flex-grow">
                                <div class="flex justify-between items-start mb-2">
                                    <h3 class="text-lg font-bold text-white group-hover:text-blue-400 transition line-clamp-1">
                                        {{ $service->name_ar }}
                                    </h3>
                                </div>
                                <div class="flex items-center gap-1 mb-3 text-xs text-slate-400">
                                    <i class="fa-solid fa-store text-blue-500"></i> 
                                    <span>{{ $service->provider->name_ar }}</span>
                                </div>

                                <div class="mt-auto border-t border-white/5 pt-4 flex items-center justify-between">
                                    <div>
                                        <span class="block text-xl font-black text-white">{{ (int)$service->price }}</span>
                                        <span class="text-[10px] text-slate-500 font-bold">د.أ</span>
                                    </div>
                                    <button @click="showDetails = true" 
                                            class="bg-white/5 hover:bg-blue-600 hover:text-white text-slate-300 px-4 py-2 rounded-xl text-sm font-bold transition border border-white/5 flex items-center gap-2">
                                        <span>التفاصيل</span> 
                                        <i class="fa-solid fa-eye"></i>
                                    </button>
                                </div>
                            </div>

                            {{-- مودال تفاصيل الخدمة --}}
                            <template x-teleport="body">
                                <div x-show="showDetails" 
                                     x-transition.opacity 
                                     style="display: none;" 
                                     class="fixed inset-0 z-[9999] flex items-center justify-center bg-black/90 backdrop-blur-sm p-4">
                                    <div @click.away="showDetails = false" 
                                         class="bg-slate-900 border border-white/10 rounded-3xl w-full max-w-4xl max-h-[90vh] overflow-y-auto shadow-2xl flex flex-col md:flex-row relative animate-scale-up">
                                        <button @click="showDetails = false" 
                                                class="absolute top-4 left-4 z-10 w-8 h-8 bg-black/50 rounded-full text-white flex items-center justify-center hover:bg-red-500 transition">
                                            <i class="fa-solid fa-xmark"></i>
                                        </button>

                                        {{-- صورة الخدمة في المودال --}}
                                        <div class="w-full md:w-1/2 h-64 md:h-auto relative bg-slate-950">
                                            @if($service->image)
                                                <img src="{{ asset('storage/' . $service->image) }}" class="w-full h-full object-cover">
                                            @endif
                                            <div class="absolute inset-0 bg-gradient-to-t from-slate-900 via-transparent to-transparent md:bg-gradient-to-r"></div>
                                        </div>

                                        {{-- تفاصيل الخدمة --}}
                                        <div class="w-full md:w-1/2 p-8 flex flex-col">
                                            <h2 class="text-3xl font-black text-white mb-4">{{ $service->name_ar }}</h2>
                                            <div class="flex items-center gap-3 mb-6 p-3 bg-white/5 rounded-xl border border-white/5">
                                                <div class="w-10 h-10 rounded-full bg-slate-800 flex items-center justify-center text-slate-400">
                                                    <i class="fa-solid fa-store"></i>
                                                </div>
                                                <div>
                                                    <p class="text-xs text-slate-400">مقدم الخدمة</p>
                                                    <p class="text-sm font-bold text-white">{{ $service->provider->name_ar }}</p>
                                                </div>
                                            </div>

                                            <h4 class="text-sm font-bold text-white mb-2">وصف الخدمة:</h4>
                                            <p class="text-slate-400 text-sm leading-relaxed mb-6">{{ $service->description }}</p>

                                            @if($service->capacity)
                                                <div class="flex items-center gap-2 text-sm text-slate-300 mb-6">
                                                    <i class="fa-solid fa-users text-blue-500"></i>
                                                    <span>السعة: <span class="font-bold text-white">{{ $service->capacity }}</span> شخص</span>
                                                </div>
                                            @endif

                                            <div class="mt-auto pt-6 border-t border-white/10">
                                                <div class="flex justify-between items-end mb-4">
                                                    <div>
                                                        <p class="text-xs text-slate-400 mb-1">السعر</p>
                                                        <span class="text-3xl font-black text-white">{{ (int)$service->price }}</span> 
                                                        <span class="text-sm text-blue-400">د.أ</span>
                                                    </div>
                                                </div>
                                                <a href="{{ route('front.services.book', $service->id) }}" 
                                                   class="w-full bg-blue-600 hover:bg-blue-500 text-white font-bold py-3 rounded-xl shadow-lg transition flex items-center justify-center gap-2">
                                                    <span>حجز الآن</span> 
                                                    <i class="fa-solid fa-arrow-left"></i>
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </template>
                        </div>
                    @endforeach
                </div>

                {{-- الترقيم الصفحات --}}
                <div class="mt-10">{{ $services->links() }}</div>
            </main>
        </div>
    </div>
@endsection