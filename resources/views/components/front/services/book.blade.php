@extends('components.layout')

@section('title', 'إتمام الحجز')

@section('content')
    {{-- ستايل لضمان لون النص والخلفية عند التعبئة التلقائية --}}
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
            -webkit-box-shadow: 0 0 0 30px #020617 inset !important; /* slate-950 */
            transition: background-color 5000s ease-in-out 0s;
        }
    </style>

    <div class="container mx-auto px-4 py-12 fade-in" x-data="{ deliveryType: 'pickup' }">
        <div class="max-w-5xl mx-auto bg-slate-900 border border-slate-800 rounded-3xl overflow-hidden shadow-2xl flex flex-col md:flex-row">
            
            {{-- القسم الأيمن: ملخص الخدمة --}}
            <div class="w-full md:w-1/3 bg-slate-950 p-8 flex flex-col relative border-b md:border-b-0 md:border-l border-slate-800">
                <div class="absolute top-0 left-0 w-full h-1 bg-gradient-to-r from-blue-500 to-purple-500"></div>

                <h2 class="text-2xl font-black text-white mb-2">{{ $service->name_ar }}</h2>
                <p class="text-slate-400 text-sm mb-4">
                    <i class="fa-solid fa-store ml-1"></i> {{ $service->provider->name_ar }}
                </p>

                {{-- صورة الخدمة --}}
                <div class="aspect-video rounded-xl overflow-hidden mb-6 border border-slate-800">
                    @if($service->image)
                        <img src="{{ asset('storage/' . $service->image) }}" class="w-full h-full object-cover">
                    @else
                        <div class="w-full h-full bg-slate-900 flex items-center justify-center text-slate-700">
                            <i class="fa-solid fa-image text-3xl"></i>
                        </div>
                    @endif
                </div>

                {{-- ملخص السعر --}}
                <div class="bg-slate-900 rounded-xl p-4 border border-slate-800 mb-4">
                    <div class="flex justify-between items-center mb-2">
                        <span class="text-slate-400 text-sm">سعر الوحدة</span>
                        <span class="text-lg font-bold text-blue-400">{{ (int)$service->price }} د.أ</span>
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
                    <span class="w-2 h-6 bg-blue-500 rounded-full"></span> تفاصيل الحجز
                </h3>

                <form action="{{ route('front.services.store', $service->id) }}" method="POST" class="space-y-6">
                    @csrf

                    {{-- التاريخ والكمية (إذا لم تكن ثابتة) --}}
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-slate-400 text-xs font-bold mb-2 uppercase">تاريخ المناسبة *</label>
                            {{-- إضافة style="color-scheme: dark;" للأيقونة --}}
                            <input type="date" 
                                   name="date" 
                                   required 
                                   min="{{ date('Y-m-d') }}"
                                   style="color-scheme: dark;"
                                   class="w-full bg-slate-950 border border-slate-700 rounded-xl px-4 py-3 text-white focus:border-blue-500 focus:outline-none transition placeholder-slate-500">
                        </div>

                        @if($service->price_unit != 'fixed')
                            <div>
                                <label class="block text-slate-400 text-xs font-bold mb-2 uppercase">
                                    {{ $service->price_unit == 'per_hour' ? 'عدد الساعات' : 'عدد الأشخاص' }} *
                                </label>
                                <input type="number" 
                                       name="quantity" 
                                       value="1" 
                                       min="1" 
                                       required
                                       class="w-full bg-slate-950 border border-slate-700 rounded-xl px-4 py-3 text-white focus:border-blue-500 focus:outline-none transition placeholder-slate-500">
                            </div>
                        @endif
                    </div>

                    {{-- عدد المعازيم --}}
                    <div>
                        <label class="block text-slate-400 text-xs font-bold mb-2 uppercase">عدد المعازيم المتوقع</label>
                        <input type="number" 
                               name="guest_count" 
                               placeholder="مثلاً: 50"
                               class="w-full bg-slate-950 border border-slate-700 rounded-xl px-4 py-3 text-white focus:border-blue-500 focus:outline-none transition placeholder-slate-500">
                    </div>

                    {{-- طريقة الاستلام --}}
                    <div>
                        <label class="block text-slate-400 text-xs font-bold mb-2 uppercase">طريقة الاستلام</label>
                        <div class="grid grid-cols-2 gap-4">
                            <label class="cursor-pointer">
                                <input type="radio" name="delivery_type" value="pickup" x-model="deliveryType" class="peer sr-only">
                                <div class="bg-slate-950 border border-slate-700 peer-checked:border-blue-500 peer-checked:bg-blue-500/10 rounded-xl p-3 text-center transition hover:border-slate-500">
                                    <i class="fa-solid fa-store block mb-1 text-lg text-slate-400 peer-checked:text-blue-500"></i>
                                    <span class="text-sm font-bold text-white">استلام من المحل</span>
                                </div>
                            </label>
                            <label class="cursor-pointer">
                                <input type="radio" name="delivery_type" value="delivery" x-model="deliveryType" class="peer sr-only">
                                <div class="bg-slate-950 border border-slate-700 peer-checked:border-blue-500 peer-checked:bg-blue-500/10 rounded-xl p-3 text-center transition hover:border-slate-500">
                                    <i class="fa-solid fa-truck block mb-1 text-lg text-slate-400 peer-checked:text-blue-500"></i>
                                    <span class="text-sm font-bold text-white">توصيل للموقع</span>
                                </div>
                            </label>
                        </div>
                    </div>

                    {{-- العنوان عند التوصيل --}}
                    <div x-show="deliveryType === 'delivery'" x-transition class="space-y-2 bg-slate-950/50 p-4 rounded-xl border border-white/5">
                        <label class="block text-slate-400 text-xs font-bold uppercase">عنوان التوصيل *</label>
                        <textarea name="address" rows="2" placeholder="المدينة، اسم الشارع، معلم قريب..."
                                  class="w-full bg-slate-950 border border-slate-700 rounded-xl px-4 py-3 text-white focus:border-blue-500 focus:outline-none transition resize-none placeholder-slate-500"></textarea>
                    </div>

                    {{-- نوع الورد / تفاصيل إضافية --}}
                    <div>
                        <label class="block text-slate-400 text-xs font-bold mb-2 uppercase">تفاصيل إضافية (مثل نوع الورد، الألوان المفضلة)</label>
                        <input type="text" 
                               name="flower_type" 
                               placeholder="مثلاً: ورد جوري أحمر، أو تغليف أسود وذهبي"
                               class="w-full bg-slate-950 border border-slate-700 rounded-xl px-4 py-3 text-white focus:border-blue-500 focus:outline-none transition placeholder-slate-500">
                    </div>

                    {{-- ملاحظات عامة --}}
                    <div>
                        <label class="block text-slate-400 text-xs font-bold mb-2 uppercase">ملاحظات عامة</label>
                        <textarea name="notes" rows="2" placeholder="أي شيء آخر تود إخبارنا به..."
                                  class="w-full bg-slate-950 border border-slate-700 rounded-xl px-4 py-3 text-white focus:border-blue-500 focus:outline-none transition resize-none placeholder-slate-500"></textarea>
                    </div>

                    {{-- أزرار الإلغاء والتأكيد --}}
                    <div class="pt-4 border-t border-slate-800 flex items-center justify-between">
                        <a href="{{ route('front.services.index') }}" 
                           class="text-slate-500 hover:text-white text-sm transition font-bold">
                            إلغاء
                        </a>
                        <button type="submit" 
                                class="bg-blue-600 hover:bg-blue-500 text-white font-bold py-3 px-8 rounded-xl shadow-lg transition transform active:scale-95 flex items-center gap-2">
                            <span>إتمام الحجز</span>
                            <i class="fa-solid fa-check"></i>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection