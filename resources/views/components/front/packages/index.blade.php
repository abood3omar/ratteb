@extends('components.layout')

@section('title', 'باقات نسق لي')

@section('content')
    <div class="container mx-auto px-4 py-8 fade-in">
        {{-- العنوان الرئيسي --}}
        <div class="text-center mb-12">
            <h1 class="text-4xl font-black text-white mb-4">باقاتنا المميزة 🎁</h1>
            <p class="text-slate-400 max-w-2xl mx-auto">اخترنا لك أفضل الخدمات وجمعناها في باقات متكاملة لتناسب مناسبتك.</p>
        </div>

        {{-- شبكة الباقات --}}
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            @forelse($packages as $package)
                <div 
                    class="bg-slate-900 border border-slate-800 rounded-3xl overflow-hidden hover:border-blue-500/50 hover:shadow-2xl transition-all duration-300 group flex flex-col h-full"
                    x-data="{ 
                        showPackageDetails: false, 
                        showServiceDetails: false, 
                        activeService: {} 
                    }"
                >
                    {{-- صورة الباقة والسعر --}}
                    <div class="h-56 overflow-hidden relative">
                        @if($package->image)
                            <img src="{{ asset('storage/' . $package->image) }}" class="w-full h-full object-cover group-hover:scale-110 transition duration-700">
                        @else
                            <div class="w-full h-full bg-slate-800 flex items-center justify-center">
                                <i class="fa-solid fa-gift text-5xl text-slate-700"></i>
                            </div>
                        @endif
                        <div class="absolute top-4 right-4 bg-blue-600 text-white text-sm font-bold px-3 py-1 rounded-full shadow-lg">
                            {{ number_format($package->price, 0) }} د.أ
                        </div>
                    </div>

                    {{-- محتوى الكرت --}}
                    <div class="p-6 flex-1 flex flex-col">
                        <h3 class="text-2xl font-bold text-white mb-2">{{ $package->name_ar }}</h3>
                        <p class="text-slate-400 text-sm mb-6 line-clamp-2">{{ $package->description }}</p>

                        {{-- أبرز المحتويات (مختصرة) --}}
                        <div class="mb-6 bg-slate-950/50 rounded-xl p-4 border border-slate-800">
                            <span class="text-xs font-bold text-blue-400 block mb-2">أبرز المحتويات:</span>
                            <ul class="space-y-2">
                                @foreach($package->services->take(3) as $service)
                                    <li class="flex items-center gap-2 text-slate-300 text-sm">
                                        <i class="fa-solid fa-check-circle text-emerald-500 text-xs"></i>
                                        {{ $service->name_ar }}
                                    </li>
                                @endforeach
                                @if($package->services->count() > 3)
                                    <li class="text-xs text-slate-500 pr-5">+ {{ $package->services->count() - 3 }} خدمات أخرى</li>
                                @endif
                            </ul>
                        </div>

                        {{-- أزرار الحجز والتفاصيل --}}
                        <div class="mt-auto flex gap-3">
                            <a href="{{ route('front.packages.book', $package->id) }}" 
                               class="flex-1 text-center bg-blue-600 hover:bg-blue-500 text-white font-bold py-3 rounded-xl transition shadow-lg">
                                حجز <i class="fa-solid fa-arrow-left mr-1"></i>
                            </a>
                            <button @click="showPackageDetails = true" 
                                    class="px-4 py-3 bg-white/5 hover:bg-white/10 text-slate-300 rounded-xl font-bold transition border border-white/5">
                                <i class="fa-solid fa-eye"></i>
                            </button>
                        </div>
                    </div>

                    {{-- مودال تفاصيل الباقة (الرئيسي) --}}
                    <template x-teleport="body">
                        <div x-show="showPackageDetails" 
                             x-transition.opacity 
                             style="display: none;" 
                             class="fixed inset-0 z-[100] flex items-center justify-center bg-black/90 backdrop-blur-sm p-4">
                            <div @click.away="showPackageDetails = false" 
                                 class="bg-slate-900 border border-white/10 rounded-3xl w-full max-w-lg p-0 shadow-2xl relative overflow-hidden flex flex-col max-h-[90vh]">

                                {{-- صورة الباقة في المودال --}}
                                <div class="relative h-48 bg-slate-950 flex-shrink-0">
                                    @if($package->image)
                                        <img src="{{ asset('storage/' . $package->image) }}" class="w-full h-full object-cover">
                                    @endif
                                    <div class="absolute inset-0 bg-gradient-to-t from-slate-900 via-transparent to-transparent"></div>
                                    <button @click="showPackageDetails = false" 
                                            class="absolute top-4 right-4 w-8 h-8 bg-black/50 rounded-full text-white flex items-center justify-center hover:bg-red-500 transition">
                                        <i class="fa-solid fa-xmark"></i>
                                    </button>
                                    <div class="absolute bottom-4 right-4 text-2xl font-black text-white drop-shadow-md">
                                        {{ number_format($package->price, 0) }} د.أ
                                    </div>
                                </div>

                                {{-- محتويات الباقة --}}
                                <div class="p-6 overflow-y-auto custom-scrollbar">
                                    <h2 class="text-2xl font-black text-white mb-2">{{ $package->name_ar }}</h2>
                                    <p class="text-slate-400 text-sm leading-relaxed mb-6">{{ $package->description }}</p>

                                    <div class="bg-white/5 rounded-2xl p-5 border border-white/5">
                                        <h4 class="text-sm font-bold text-blue-400 mb-4 uppercase tracking-wider flex items-center gap-2">
                                            <i class="fa-solid fa-layer-group"></i> اضغط على الخدمة للتفاصيل
                                        </h4>

                                        <ul class="space-y-3">
                                            @foreach($package->services as $service)
                                                <li @click="activeService = { 
                                                        name: '{{ $service->name_ar }}', 
                                                        provider: '{{ $service->provider->name_ar }}',
                                                        description: '{{ addslashes($service->description) }}',
                                                        image: '{{ $service->image ? asset('storage/'.$service->image) : null }}',
                                                        price: '{{ (int)$service->price }}',
                                                        capacity: '{{ $service->capacity }}'
                                                    }; showServiceDetails = true" 
                                                    class="flex items-center gap-4 bg-slate-950/50 hover:bg-blue-600/10 hover:border-blue-500/30 p-3 rounded-xl border border-white/5 cursor-pointer transition group/item">

                                                    <div class="w-12 h-12 rounded-lg bg-slate-800 overflow-hidden shrink-0 border border-white/10 relative">
                                                        @if($service->image)
                                                            <img src="{{ asset('storage/' . $service->image) }}" class="w-full h-full object-cover">
                                                        @else
                                                            <div class="w-full h-full flex items-center justify-center text-slate-600">
                                                                <i class="fa-solid fa-cube"></i>
                                                            </div>
                                                        @endif
                                                        <div class="absolute inset-0 bg-black/50 flex items-center justify-center opacity-0 group-hover/item:opacity-100 transition">
                                                            <i class="fa-solid fa-magnifying-glass text-white text-xs"></i>
                                                        </div>
                                                    </div>

                                                    <div class="flex-grow">
                                                        <span class="text-slate-200 text-sm font-bold block group-hover/item:text-blue-400 transition">
                                                            {{ $service->name_ar }}
                                                        </span>
                                                        <div class="flex items-center gap-1 text-[10px] text-slate-500 mt-1">
                                                            <i class="fa-solid fa-store"></i> {{ $service->provider->name_ar }}
                                                        </div>
                                                    </div>

                                                    <i class="fa-solid fa-chevron-left text-slate-600 text-xs"></i>
                                                </li>
                                            @endforeach
                                        </ul>
                                    </div>
                                </div>

                                {{-- زر الحجز في أسفل المودال --}}
                                <div class="p-4 border-t border-white/10 bg-slate-950">
                                    <a href="{{ route('front.packages.book', $package->id) }}" 
                                       class="block w-full py-3 bg-blue-600 hover:bg-blue-500 text-white rounded-xl font-bold transition text-center shadow-lg">
                                        احجز هذه الباقة الآن
                                    </a>
                                </div>
                            </div>
                        </div>
                    </template>

                    {{-- مودال تفاصيل الخدمة الفرعي --}}
                    <template x-teleport="body">
                        <div x-show="showServiceDetails" 
                             x-transition.opacity 
                             style="display: none;" 
                             class="fixed inset-0 z-[200] flex items-center justify-center bg-black/95 backdrop-blur-md p-4">
                            <div @click.away="showServiceDetails = false" 
                                 class="bg-slate-900 border border-blue-500/30 rounded-3xl w-full max-w-md p-0 shadow-2xl relative overflow-hidden animate-scale-up">

                                <button @click="showServiceDetails = false" 
                                        class="absolute top-4 right-4 z-10 w-8 h-8 bg-black/60 backdrop-blur rounded-full text-white flex items-center justify-center hover:bg-white hover:text-black transition">
                                    <i class="fa-solid fa-xmark"></i>
                                </button>

                                <div class="h-40 bg-slate-950 relative">
                                    <img x-show="activeService.image" :src="activeService.image" class="w-full h-full object-cover">
                                    <div x-show="!activeService.image" class="w-full h-full flex items-center justify-center text-slate-700">
                                        <i class="fa-solid fa-image text-4xl"></i>
                                    </div>
                                    <div class="absolute inset-0 bg-gradient-to-t from-slate-900 to-transparent"></div>
                                    <div class="absolute bottom-4 right-6">
                                        <span class="bg-blue-600 text-white text-[10px] font-bold px-2 py-1 rounded" x-text="activeService.provider"></span>
                                    </div>
                                </div>

                                <div class="p-6">
                                    <h3 class="text-xl font-black text-white mb-3" x-text="activeService.name"></h3>

                                    <div class="bg-white/5 rounded-xl p-4 mb-4 border border-white/5">
                                        <p class="text-slate-300 text-sm leading-relaxed" 
                                           x-text="activeService.description || 'لا يوجد وصف إضافي.'"></p>
                                    </div>

                                    <div class="grid grid-cols-2 gap-3">
                                        <div class="bg-slate-950 p-3 rounded-xl text-center border border-white/5">
                                            <span class="text-slate-500 text-[10px] block">السعر الفردي</span>
                                            <span class="text-white font-bold" x-text="activeService.price + ' د.أ'"></span>
                                        </div>
                                        <div class="bg-slate-950 p-3 rounded-xl text-center border border-white/5" x-show="activeService.capacity">
                                            <span class="text-slate-500 text-[10px] block">السعة</span>
                                            <span class="text-white font-bold" x-text="activeService.capacity + ' شخص'"></span>
                                        </div>
                                    </div>

                                    <button @click="showServiceDetails = false" 
                                            class="w-full mt-6 py-3 bg-slate-800 hover:bg-slate-700 text-white rounded-xl font-bold transition">
                                        عودة لتفاصيل الباقة
                                    </button>
                                </div>
                            </div>
                        </div>
                    </template>
                </div>
            @empty
                <div class="col-span-full text-center py-20">
                    <p class="text-slate-500">لا يوجد باقات متاحة حالياً.</p>
                </div>
            @endforelse
        </div>
    </div>
@endsection