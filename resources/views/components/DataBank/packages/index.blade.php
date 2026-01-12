@extends('components.layout')

@section('title', 'إدارة الباقات')

@section('content')

    {{-- Header Section --}}
    <div class="flex flex-col md:flex-row justify-between items-center mb-8 fade-in">
        <div>
            <h1 class="text-3xl font-black text-white mb-2">إدارة الباقات 🎁</h1>
            <p class="text-slate-400">تجهيز عروض متكاملة (قاعة + خدمات) بأسعار مخفضة.</p>
        </div>
    </div>

    {{-- Main Section --}}
    <x-databank.forms.section formName="باقة">
        
        {{-- 1. Create Form --}}
        <x-databank.forms.create routeName="packages" formName="Package">
            
            <x-databank.forms.input label="اسم الباقة (بالعربي)" name="name_ar" placeholder="مثلاً: الباقة الملكية" required />
            <x-databank.forms.input label="اسم الباقة (انجليزي)" name="name_en" placeholder="e.g. Royal Package" class="text-left" dir="ltr" />

            <div class="relative">
                <x-databank.forms.input label="سعر الباقة (د.أ)" name="price" type="number" placeholder="950" required />
                <div class="absolute left-4 top-9 text-xs text-slate-500 font-bold">JOD</div>
                <p class="text-[10px] text-slate-500 mt-1">يجب أن يكون السعر أقل من مجموع الخدمات الفردية.</p>
            </div>

            {{-- Services Checkbox List --}}
            <div class="space-y-2">
                <label class="block text-slate-400 text-xs font-bold uppercase tracking-wider mb-1">
                    اختر الخدمات المشمولة
                </label>
                
                <div class="h-48 overflow-y-auto custom-scrollbar bg-slate-950/50 border border-slate-700 rounded-xl p-3 space-y-2">
                    @foreach($services as $service)
                        <label class="flex items-start gap-3 p-2 rounded-lg hover:bg-white/5 transition cursor-pointer group border border-transparent hover:border-slate-700">
                            {{-- Checkbox Array --}}
                            <input type="checkbox" name="services[]" value="{{ $service->id }}" class="mt-1 w-4 h-4 rounded border-slate-600 text-blue-600 focus:ring-blue-500 bg-slate-800">
                            
                            <div class="flex flex-col">
                                <span class="text-sm font-bold text-slate-200 group-hover:text-white transition">{{ $service->name_ar }}</span>
                                <span class="text-[10px] text-slate-500">
                                    المزود: {{ $service->provider->name_ar ?? 'غير محدد' }} | الأصلي: {{ $service->price }} د.أ
                                </span>
                            </div>
                        </label>
                    @endforeach
                    
                    @if($services->isEmpty())
                        <div class="text-center py-4 text-slate-500 text-xs">
                            لا يوجد خدمات متاحة. قم بإضافة خدمات في بنك البيانات أولاً.
                        </div>
                    @endif
                </div>
            </div>

            <div class="space-y-2">
                <label class="block text-slate-400 text-xs font-bold uppercase tracking-wider">وصف الباقة</label>
                <textarea name="description" rows="3" class="block w-full bg-slate-950/50 border border-slate-700 rounded-xl px-4 py-3 text-white focus:outline-none focus:border-blue-500 focus:ring-1 focus:ring-blue-500 transition-all placeholder-slate-600 resize-none"></textarea>
            </div>

            <div class="space-y-2">
                <label class="block text-slate-400 text-xs font-bold uppercase tracking-wider">صورة الغلاف</label>
                <label class="flex flex-col items-center justify-center w-full h-32 border-2 border-slate-700 border-dashed rounded-xl cursor-pointer bg-slate-950/30 hover:bg-slate-900/50 hover:border-blue-500 transition-all group">
                    <div class="flex flex-col items-center justify-center pt-5 pb-6">
                        <i class="fa-solid fa-images text-2xl text-slate-500 group-hover:text-blue-500 mb-2 transition"></i>
                        <p class="text-xs text-slate-500 group-hover:text-slate-300">رفع صورة ترويجية</p>
                    </div>
                    <input type="file" name="image" class="hidden" />
                </label>
            </div>

        </x-databank.forms.create>

    </div>

    {{-- 2. Display Cards Section --}}
    <x-databank.forms.show formName="الباقات" routeName="packages" searchPlaceholder="ابحث عن باقة...">
            
        <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-6">
            @forelse($packages as $package)
                <div class="group relative bg-slate-900/50 border border-slate-800 hover:border-blue-500/50 rounded-2xl overflow-hidden transition-all duration-300 hover:shadow-2xl hover:shadow-blue-900/20">
                    
                    <div class="h-48 w-full relative overflow-hidden">
                        @if($package->image)
                            <img src="{{ asset('storage/' . $package->image) }}" class="w-full h-full object-cover group-hover:scale-105 transition duration-500">
                        @else
                            <div class="w-full h-full bg-slate-800 flex items-center justify-center">
                                <i class="fa-solid fa-gift text-4xl text-slate-700"></i>
                            </div>
                        @endif
                        
                        <div class="absolute top-3 left-3 bg-slate-950/90 backdrop-blur border border-yellow-500/30 text-yellow-400 px-3 py-1 rounded-lg text-sm font-bold shadow-lg">
                            {{ number_format($package->price, 0) }} د.أ
                        </div>
                    </div>

                    <div class="p-5">
                        <div class="flex justify-between items-start mb-3">
                            <div>
                                <h3 class="text-lg font-bold text-white mb-1">{{ $package->name_ar }}</h3>
                                <p class="text-xs text-slate-500 font-mono">{{ $package->name_en }}</p>
                            </div>
                        </div>

                        <div class="mb-4">
                            <p class="text-[10px] uppercase tracking-wider text-slate-400 font-bold mb-2">يشمل الخدمات:</p>
                            <div class="flex flex-wrap gap-1.5">
                                @forelse($package->services as $service)
                                    <span class="px-2 py-1 bg-blue-500/10 border border-blue-500/20 rounded-md text-[10px] text-blue-300">
                                        {{ $service->name_ar }}
                                    </span>
                                @empty
                                    <span class="text-[10px] text-slate-600">لا يوجد خدمات</span>
                                @endforelse
                            </div>
                        </div>

                        <div class="flex items-center gap-2 pt-4 border-t border-white/5">
                            
                            {{-- Edit Button & Modal --}}
                            <x-databank.edit-modal id="{{ $package->id }}" entityName="Package" :element="$package" routeName="packages">
                                <div class="grid grid-cols-1 gap-4">
                                    <x-databank.forms.input label="الاسم بالعربي" name="name_ar" value="{{ $package->name_ar }}" />
                                    <x-databank.forms.input label="السعر" name="price" value="{{ $package->price }}" type="number" />
                                    
                                    {{-- Edit Services Checkboxes --}}
                                    <div class="space-y-2">
                                        <label class="block text-slate-400 text-xs font-bold">تعديل الخدمات</label>
                                        <div class="h-32 overflow-y-auto bg-slate-950/50 border border-slate-700 rounded-xl p-3 space-y-2">
                                            @foreach($services as $service)
                                                <label class="flex items-start gap-3 p-1 hover:bg-white/5 cursor-pointer">
                                                    <input type="checkbox" name="services[]" value="{{ $service->id }}" 
                                                        {{ $package->services->contains($service->id) ? 'checked' : '' }}
                                                        class="mt-1 w-4 h-4 rounded border-slate-600 text-blue-600 bg-slate-800">
                                                    <span class="text-sm text-slate-300">{{ $service->name_ar }}</span>
                                                </label>
                                            @endforeach
                                        </div>
                                    </div>
                                </div>
                            </x-databank.edit-modal>

                            {{-- Delete Button & Modal --}}
                            <x-databank.delete-modal id="{{ $package->id }}" :element="$package" routeName="packages" entityName="الباقة" />
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-span-full py-12 flex flex-col items-center justify-center text-center opacity-50">
                    <div class="w-16 h-16 bg-slate-800 rounded-full flex items-center justify-center mb-4">
                        <i class="fa-solid fa-box-open text-2xl text-slate-400"></i>
                    </div>
                    <h3 class="text-slate-300 font-bold">لا يوجد باقات</h3>
                    <p class="text-sm text-slate-500 mt-1">قم بإضافة باقة جديدة من القائمة الجانبية.</p>
                </div>
            @endforelse
        </div>

        <div class="mt-6">
            {{ $packages->links('pagination::tailwind') }}
        </div>

    </x-databank.forms.show>

    </x-databank.forms.section>

@endsection