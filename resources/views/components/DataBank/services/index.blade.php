@extends('components.layout')

@section('title', 'إدارة الخدمات')

@section('content')

    <div class="flex flex-col md:flex-row justify-between items-center mb-8 fade-in">
        <div>
            <h1 class="text-3xl font-black text-white mb-2">الخدمات والمنتجات 🛍️</h1>
            <p class="text-slate-400">إدارة القاعات، البوفيهات، وباقات التصوير.</p>
        </div>
    </div>

    <x-databank.forms.section formName="خدمة">
        
<x-databank.forms.create routeName="services" formName="Service">
    
    <div x-data="{ 
        selectedCategory: '', 
        providers: {{ $providers->map(fn($p) => ['id' => $p->id, 'name' => $p->name_ar, 'category_id' => $p->category_id]) }} 
    }">

        <div class="space-y-2 mb-4">
            <label class="block text-slate-400 text-xs font-bold uppercase tracking-wider">أولاً: اختر التصنيف</label>
            <div class="relative">
                <select x-model="selectedCategory" class="block w-full bg-slate-950/50 border border-slate-700 rounded-xl px-4 py-3 text-white focus:border-blue-500 appearance-none outline-none">
                    <option value="" disabled selected>-- اختر نوع الخدمة --</option>
                    {{-- بنجيب التصنيفات الفريدة من المزودين أو نمرر متغير categories من الكونترولر --}}
                    @foreach($providers->unique('category_id') as $p)
                        <option value="{{ $p->category_id }}">{{ $p->category->name_ar }}</option>
                    @endforeach
                </select>
                <div class="absolute left-4 top-1/2 -translate-y-1/2 pointer-events-none text-slate-500"><i class="fa-solid fa-filter"></i></div>
            </div>
        </div>

        <div class="space-y-2 mb-4">
            <label class="block text-slate-400 text-xs font-bold uppercase tracking-wider">المزود (صاحب الخدمة) <span class="text-red-500">*</span></label>
            <div class="relative">
                <select name="provider_id" required class="block w-full bg-slate-950/50 border border-slate-700 rounded-xl px-4 py-3 text-white focus:border-blue-500 appearance-none outline-none disabled:opacity-50" :disabled="!selectedCategory">
                    <option value="" selected>-- اختر المزود --</option>
                    
                    <template x-for="provider in providers.filter(p => p.category_id == selectedCategory)" :key="provider.id">
                        <option :value="provider.id" x-text="provider.name"></option>
                    </template>
                
                </select>
                <div class="absolute left-4 top-1/2 -translate-y-1/2 pointer-events-none text-slate-500"><i class="fa-solid fa-chevron-down text-xs"></i></div>
            </div>
            <p x-show="!selectedCategory" class="text-[10px] text-yellow-500 mt-1">
                <i class="fa-solid fa-circle-info"></i> يجب اختيار التصنيف أولاً لإظهار المزودين.
            </p>
        </div>

    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
        <x-databank.forms.input label="اسم الخدمة (عربي)" name="name_ar" placeholder="مثلاً: قاعة الأميرة" required />
        <x-databank.forms.input label="اسم الخدمة (انجليزي)" name="name_en" placeholder="e.g. Princess Hall" dir="ltr" required />
    </div>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
        <div class="md:col-span-2">
            <x-databank.forms.input label="السعر (د.أ)" name="price" type="number" placeholder="0.00" required />
        </div>
        <div class="space-y-2">
            <label class="block text-slate-400 text-xs font-bold uppercase tracking-wider">وحدة التسعير</label>
            <div class="relative">
                <select name="price_unit" class="block w-full bg-slate-950/50 border border-slate-700 rounded-xl px-4 py-3 text-white focus:border-blue-500 appearance-none outline-none">
                    <option value="fixed">مقطوع (ثابت)</option>
                    <option value="per_hour">في الساعة</option>
                    <option value="per_person">للشخص الواحد</option>
                </select>
                <div class="absolute left-4 top-1/2 -translate-y-1/2 pointer-events-none text-slate-500"><i class="fa-solid fa-tag"></i></div>
            </div>
        </div>
    </div>

    <div class="space-y-2">
        <x-databank.forms.input label="السعة / العدد الأقصى (اختياري للقاعات)" name="capacity" type="number" placeholder="مثلاً: 500" />
    </div>

    <div class="space-y-2">
        <label class="block text-slate-400 text-xs font-bold uppercase tracking-wider">تفاصيل الخدمة <span class="text-red-500">*</span></label>
        <textarea name="description" required rows="3" class="block w-full bg-slate-950/50 border border-slate-700 rounded-xl px-4 py-3 text-white focus:outline-none focus:border-blue-500 transition resize-none"></textarea>
    </div>

    <div class="space-y-2">
        <label class="block text-slate-400 text-xs font-bold uppercase tracking-wider">صورة الخدمة <span class="text-red-500">*</span></label>
        <input type="file" name="image" required class="block w-full text-sm text-slate-400 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-bold file:bg-blue-500/10 file:text-blue-400 hover:file:bg-blue-500/20 transition cursor-pointer border border-slate-700 rounded-xl bg-slate-950/50">
    </div>

</x-databank.forms.create>
        </div>
        <x-databank.forms.show formName="الخدمات" routeName="services" searchPlaceholder="ابحث عن خدمة...">
       
            @if($services->count() > 0)
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    @foreach($services as $service)
                        <div class="group bg-slate-950 border border-white/5 rounded-3xl overflow-hidden hover:border-blue-500/30 transition-all duration-300 hover:shadow-2xl hover:-translate-y-1">
                            
                            <div class="h-48 relative overflow-hidden bg-slate-900">
                                @if($service->image)
                                    <img src="{{ asset('storage/' . $service->image) }}" class="w-full h-full object-cover group-hover:scale-110 transition duration-700">
                                @else
                                    <div class="w-full h-full flex items-center justify-center text-slate-600"><i class="fa-solid fa-image text-4xl"></i></div>
                                @endif
                                
                                @if($service->capacity)
                                    <div class="absolute top-4 right-4 bg-slate-900/80 backdrop-blur border border-white/10 px-3 py-1 rounded-full text-[10px] text-white font-bold flex items-center gap-1">
                                        <i class="fa-solid fa-users text-blue-400"></i> {{ $service->capacity }}
                                    </div>
                                @endif
                            </div>

                            <div class="p-6">
                                <div class="flex justify-between items-start mb-2">
                                    <h3 class="text-lg font-bold text-white line-clamp-1" title="{{ $service->name_ar }}">{{ $service->name_ar }}</h3>
                                    <div class="flex items-center gap-2">
                                        <x-databank.edit-modal id="{{ $service->id }}" entityName="Service" :element="$service" routeName="services">
                                            <div class="space-y-4">
                                                <select name="provider_id" class="block w-full bg-slate-950/50 border border-slate-700 rounded-xl px-4 py-3 text-white">
                                                    @foreach($providers as $provider)
                                                        <option value="{{ $provider->id }}" {{ $service->provider_id == $provider->id ? 'selected' : '' }}>{{ $provider->name_ar }}</option>
                                                    @endforeach
                                                </select>
                                                <x-databank.forms.input label="الاسم" name="name_ar" value="{{ $service->name_ar }}" />
                                                <x-databank.forms.input label="الاسم انجليزي" name="name_en" value="{{ $service->name_en }}" dir="ltr" />
                                                <div class="flex gap-2">
                                                    <x-databank.forms.input label="السعر" name="price" value="{{ $service->price }}" />
                                                    <div class="w-1/2">
                                                        <label class="block text-slate-400 text-xs font-bold mb-2">الوحدة</label>
                                                        <select name="price_unit" class="block w-full bg-slate-950/50 border border-slate-700 rounded-xl px-4 py-3 text-white">
                                                            <option value="fixed" {{ $service->price_unit == 'fixed' ? 'selected' : '' }}>ثابت</option>
                                                            <option value="per_hour" {{ $service->price_unit == 'per_hour' ? 'selected' : '' }}>ساعة</option>
                                                            <option value="per_person" {{ $service->price_unit == 'per_person' ? 'selected' : '' }}>شخص</option>
                                                        </select>
                                                    </div>
                                                </div>
                                                <textarea name="description" class="block w-full bg-slate-950/50 border border-slate-700 rounded-xl px-4 py-3 text-white">{{ $service->description }}</textarea>
                                                <input type="file" name="image" class="block w-full text-sm text-slate-400 border border-slate-700 rounded-xl bg-slate-950/50">
                                            </div>
                                        </x-databank.edit-modal>

                                        <x-databank.delete-modal id="{{ $service->id }}" :element="$service" routeName="services" entityName="الخدمة" />
                                    </div>
                                </div>

                                <p class="text-xs text-slate-400 mb-4 line-clamp-2">{{ $service->description }}</p>

                                <div class="flex items-center justify-between pt-4 border-t border-white/5">
                                    <div class="flex items-center gap-2">
                                        <div class="w-6 h-6 rounded-full bg-slate-800 flex items-center justify-center text-xs text-slate-400">
                                            <i class="fa-solid fa-store"></i>
                                        </div>
                                        <span class="text-xs text-slate-300 font-bold">{{ $service->provider->name_ar ?? 'غير معروف' }}</span>
                                    </div>
                                    <div class="text-right">
                                        <span class="block text-lg font-black text-blue-400">{{ $service->price }}</span>
                                        <span class="text-[10px] text-slate-500 uppercase font-bold">
                                            @if($service->price_unit == 'fixed') سعر ثابت
                                            @elseif($service->price_unit == 'per_hour') لكل ساعة
                                            @else للشخص
                                            @endif
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="py-16 text-center text-slate-500 flex flex-col items-center gap-4">
                    <div class="w-20 h-20 bg-slate-800/50 rounded-full flex items-center justify-center text-3xl opacity-50">
                        <i class="fa-solid fa-box-open"></i>
                    </div>
                    <p>لم يتم إضافة أي خدمات حتى الآن</p>
                </div>
            @endif

        </x-databank.forms.show>

    </x-databank.forms.section>

@endsection