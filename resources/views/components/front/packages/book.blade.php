@extends('components.layout')

@section('title', 'تأكيد حجز الباقة')

@section('content')

    <style>
        input:-webkit-autofill,
        input:-webkit-autofill:hover, 
        input:-webkit-autofill:focus, 
        input:-webkit-autofill:active,
        textarea:-webkit-autofill,
        textarea:-webkit-autofill:hover,
        textarea:-webkit-autofill:focus,
        textarea:-webkit-autofill:active {
            -webkit-text-fill-color: white !important;
            -webkit-box-shadow: 0 0 0 30px #020617 inset !important;
            transition: background-color 5000s ease-in-out 0s;
        }
    </style>

    <div class="container mx-auto px-4 py-12 fade-in" 
         x-data="{ 
             deliveryType: 'pickup', 
             showServiceDetails: false, 
             activeService: {} 
         }">

        {{-- الكارت الرئيسي: ملخص الباقة + فورم الحجز --}}
        <div class="max-w-5xl mx-auto bg-slate-900 border border-slate-800 rounded-3xl overflow-hidden shadow-2xl flex flex-col md:flex-row">
            
            {{-- القسم الأيمن: ملخص الباقة ومحتوياتها --}}
            <div class="w-full md:w-1/3 bg-slate-950 p-8 flex flex-col relative border-b md:border-b-0 md:border-l border-slate-800">
                <div class="absolute top-0 left-0 w-full h-1 bg-gradient-to-r from-blue-500 to-purple-500"></div>

                <h2 class="text-2xl font-black text-white mb-2">{{ $package->name_ar }}</h2>
                <p class="text-slate-400 text-sm mb-4">باقة متكاملة تشمل {{ $package->services->count() }} خدمات</p>

                {{-- صورة الباقة --}}
                <div class="aspect-video rounded-xl overflow-hidden mb-6 border border-slate-800 bg-slate-900">
                    @if($package->image)
                        <img src="{{ asset('storage/' . $package->image) }}" class="w-full h-full object-cover">
                    @else
                        <div class="w-full h-full flex items-center justify-center text-slate-700">
                            <i class="fa-solid fa-gift text-3xl"></i>
                        </div>
                    @endif
                </div>

                {{-- قائمة الخدمات (قابلة للنقر لعرض تفاصيل) --}}
                <div class="flex-1 overflow-y-auto max-h-60 custom-scrollbar pr-2 mb-4">
                    <p class="text-xs font-bold text-blue-400 uppercase mb-3 sticky top-0 bg-slate-950 pb-2 z-10 flex justify-between items-center">
                        <span>تشمل الخدمات التالية:</span>
                        <span class="text-[9px] text-slate-600 font-normal">(اضغط للتفاصيل)</span>
                    </p>

                    <div class="space-y-3">
                        @foreach($package->services as $service)
                            <div @click="activeService = { 
                                    name: '{{ $service->name_ar }}', 
                                    provider: '{{ $service->provider->name_ar }}',
                                    description: '{{ addslashes($service->description) }}',
                                    image: '{{ $service->image ? asset('storage/'.$service->image) : null }}',
                                    price: '{{ (int)$service->price }}',
                                    capacity: '{{ $service->capacity }}'
                                 }; showServiceDetails = true"
                                 class="flex items-center gap-3 bg-slate-900 p-2 rounded-lg border border-slate-800 cursor-pointer hover:bg-slate-800 hover:border-blue-500/30 transition group">

                                <div class="w-10 h-10 rounded bg-slate-800 flex-shrink-0 overflow-hidden relative">
                                    @if($service->image)
                                        <img src="{{ asset('storage/' . $service->image) }}" class="w-full h-full object-cover">
                                    @else
                                        <div class="w-full h-full flex items-center justify-center text-slate-600 text-xs">
                                            <i class="fa-solid fa-check"></i>
                                        </div>
                                    @endif
                                    <div class="absolute inset-0 bg-black/50 flex items-center justify-center opacity-0 group-hover:opacity-100 transition">
                                        <i class="fa-solid fa-eye text-white text-[10px]"></i>
                                    </div>
                                </div>

                                <div class="flex-grow">
                                    <span class="text-slate-300 text-xs font-bold block group-hover:text-white transition">
                                        {{ $service->name_ar }}
                                    </span>
                                    <span class="text-[10px] text-slate-500">{{ $service->provider->name_ar ?? '' }}</span>
                                </div>

                                <i class="fa-solid fa-chevron-left text-slate-600 text-[10px] group-hover:-translate-x-1 transition"></i>
                            </div>
                        @endforeach
                    </div>
                </div>

                {{-- ملخص السعر --}}
                <div class="bg-slate-900 rounded-xl p-4 border border-slate-800 mt-auto">
                    <div class="flex justify-between items-center mb-2">
                        <span class="text-slate-400 text-sm">سعر الباقة</span>
                        <span class="text-lg font-bold text-blue-400">{{ number_format($package->price, 0) }} د.أ</span>
                    </div>
                    <div class="flex justify-between items-center text-sm" 
                         x-show="deliveryType === 'delivery'" 
                         x-transition>
                        <span class="text-slate-400">رسوم التوصيل</span>
                        <span class="text-white font-bold">5 د.أ</span>
                    </div>
                </div>
            </div>

            {{-- القسم الأيسر: فورم الحجز --}}
            <div class="w-full md:w-2/3 p-8 bg-slate-900">
                <h3 class="text-xl font-bold text-white mb-6 flex items-center gap-2">
                    <span class="w-2 h-6 bg-blue-500 rounded-full"></span> تفاصيل المناسبة
                </h3>

                <form action="{{ route('front.packages.store', $package->id) }}" method="POST" class="space-y-6">
                    @csrf

                    {{-- تاريخ المناسبة --}}
                    <div>
                        <label class="block text-slate-400 text-xs font-bold mb-2 uppercase">تاريخ المناسبة *</label>
                        {{-- إضافة style="color-scheme: dark;" --}}
                        <input 
                            type="date" 
                            name="date" 
                            required 
                            min="{{ date('Y-m-d') }}"
                            style="color-scheme: dark;"
                            class="w-full bg-slate-950 border border-slate-700 rounded-xl px-4 py-3 text-white focus:border-blue-500 focus:outline-none transition placeholder-slate-500"
                        >
                    </div>

                    {{-- عدد المعازيم --}}
                    <div>
                        <label class="block text-slate-400 text-xs font-bold mb-2 uppercase">عدد المعازيم المتوقع</label>
                        <input 
                            type="number" 
                            name="guest_count" 
                            placeholder="مثلاً: 150"
                            class="w-full bg-slate-950 border border-slate-700 rounded-xl px-4 py-3 text-white focus:border-blue-500 focus:outline-none transition placeholder-slate-500"
                        >
                    </div>

                    {{-- طريقة التنفيذ / الاستلام --}}
                    <div>
                        <label class="block text-slate-400 text-xs font-bold mb-2 uppercase">طريقة التنفيذ / الاستلام</label>
                        <div class="grid grid-cols-2 gap-4">
                            <label class="cursor-pointer">
                                <input type="radio" name="delivery_type" value="pickup" x-model="deliveryType" class="peer sr-only">
                                <div class="bg-slate-950 border border-slate-700 peer-checked:border-blue-500 peer-checked:bg-blue-500/10 rounded-xl p-3 text-center transition hover:border-slate-500">
                                    <i class="fa-solid fa-shop block mb-1 text-lg text-slate-400 peer-checked:text-blue-500"></i>
                                    <span class="text-sm font-bold text-white">في القاعة / استلام</span>
                                </div>
                            </label>
                            <label class="cursor-pointer">
                                <input type="radio" name="delivery_type" value="delivery" x-model="deliveryType" class="peer sr-only">
                                <div class="bg-slate-950 border border-slate-700 peer-checked:border-blue-500 peer-checked:bg-blue-500/10 rounded-xl p-3 text-center transition hover:border-slate-500">
                                    <i class="fa-solid fa-truck block mb-1 text-lg text-slate-400 peer-checked:text-blue-500"></i>
                                    <span class="text-sm font-bold text-white">توصيل لموقع خارجي</span>
                                </div>
                            </label>
                        </div>
                    </div>

                    {{-- العنوان (يظهر فقط عند اختيار التوصيل) --}}
                    <div x-show="deliveryType === 'delivery'" 
                         x-transition 
                         class="space-y-2 bg-slate-950/50 p-4 rounded-xl border border-white/5">
                        <label class="block text-slate-400 text-xs font-bold uppercase">عنوان الموقع *</label>
                        <textarea 
                            name="address" 
                            rows="2" 
                            placeholder="المدينة، اسم الشارع، تفاصيل الموقع..."
                            class="w-full bg-slate-950 border border-slate-700 rounded-xl px-4 py-3 text-white focus:border-blue-500 focus:outline-none transition resize-none placeholder-slate-500"
                        ></textarea>
                    </div>

                    {{-- تفاصيل إضافية --}}
                    <div>
                        <label class="block text-slate-400 text-xs font-bold mb-2 uppercase">تفاصيل إضافية (ألوان، نوع ورد، الخ)</label>
                        <input 
                            type="text" 
                            name="extra_details" 
                            placeholder="مثلاً: ثيم ذهبي وأبيض، ورد جوري..."
                            class="w-full bg-slate-950 border border-slate-700 rounded-xl px-4 py-3 text-white focus:border-blue-500 focus:outline-none transition placeholder-slate-500"
                        >
                    </div>

                    {{-- ملاحظات عامة --}}
                    <div>
                        <label class="block text-slate-400 text-xs font-bold mb-2 uppercase">ملاحظات عامة</label>
                        <textarea 
                            name="notes" 
                            rows="2" 
                            placeholder="أي شيء آخر..."
                            class="w-full bg-slate-950 border border-slate-700 rounded-xl px-4 py-3 text-white focus:border-blue-500 focus:outline-none transition resize-none placeholder-slate-500"
                        ></textarea>
                    </div>

                    {{-- أزرار الإلغاء والتأكيد --}}
                    <div class="pt-4 border-t border-slate-800 flex items-center justify-between">
                        <a href="{{ route('front.packages.index') }}" 
                           class="text-slate-500 hover:text-white text-sm transition font-bold">
                            إلغاء
                        </a>
                        <button 
                            type="submit"
                            class="bg-blue-600 hover:bg-blue-500 text-white font-bold py-3 px-8 rounded-xl shadow-lg transition transform active:scale-95 flex items-center gap-2"
                        >
                            <span>تأكيد وحجز الباقة</span>
                            <i class="fa-solid fa-check"></i>
                        </button>
                    </div>
                </form>
            </div>
        </div>

        {{-- مودال تفاصيل الخدمة الفرعي --}}
        <template x-teleport="body">
            <div x-show="showServiceDetails" 
                 x-transition.opacity 
                 style="display: none;" 
                 class="fixed inset-0 z-[9999] flex items-center justify-center bg-black/95 backdrop-blur-md p-4">
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
                            <span class="text-xs text-slate-400 block mb-1">الوصف</span>
                            <p class="text-slate-300 text-sm leading-relaxed" 
                               x-text="activeService.description || 'لا يوجد وصف إضافي.'"></p>
                        </div>

                        <div class="grid grid-cols-2 gap-3">
                            <div class="bg-slate-950 p-3 rounded-xl text-center border border-white/5">
                                <span class="text-slate-500 text-[10px] block">السعر (ضمن الباقة)</span>
                                <span class="text-white font-bold" x-text="activeService.price + ' د.أ'"></span>
                            </div>
                            <div class="bg-slate-950 p-3 rounded-xl text-center border border-white/5" x-show="activeService.capacity">
                                <span class="text-slate-500 text-[10px] block">السعة</span>
                                <span class="text-white font-bold" x-text="activeService.capacity + ' شخص'"></span>
                            </div>
                        </div>

                        <button @click="showServiceDetails = false" 
                                class="w-full mt-6 py-3 bg-slate-800 hover:bg-slate-700 text-white rounded-xl font-bold transition">
                            إغلاق
                        </button>
                    </div>
                </div>
            </div>
        </template>
    </div>
@endsection