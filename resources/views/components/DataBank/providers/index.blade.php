@extends('components.layout')

@section('title', 'إدارة المزودين')

@section('content')

    <div class="flex flex-col md:flex-row justify-between items-center mb-8 fade-in">
        <div>
            <h1 class="text-3xl font-black text-white mb-2">إدارة المزودين 🤝</h1>
            <p class="text-slate-400">الشركات والأفراد مقدمي الخدمات (قاعات، مصورين، شيفات...).</p>
        </div>
    </div>

    <x-databank.forms.section formName="مزود">
        
        <x-databank.forms.create routeName="providers" formName="Provider">
            
            <div class="space-y-2">
                <label class="block text-slate-400 text-xs font-bold uppercase tracking-wider">التصنيف التابع له <span class="text-red-500">*</span></label>
                <div class="relative">
                    <select name="category_id" required class="block w-full bg-slate-950/50 border border-slate-700 rounded-xl px-4 py-3 text-white focus:border-blue-500 appearance-none outline-none">
                        <option value="" disabled selected>اختر التصنيف...</option>
                        @foreach($categories as $category)
                            <option value="{{ $category->id }}">{{ $category->name_ar }}</option>
                        @endforeach
                    </select>
                    <div class="absolute left-4 top-1/2 -translate-y-1/2 pointer-events-none text-slate-500"><i class="fa-solid fa-chevron-down text-xs"></i></div>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <x-databank.forms.input label="الاسم (عربي)" name="name_ar" placeholder="مثلاً: فندق الرويال" required />
                <x-databank.forms.input label="الاسم (انجليزي)" name="name_en" placeholder="e.g. Royal Hotel" class="text-left" dir="ltr" required />
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <x-databank.forms.input label="رقم الهاتف" name="phone" placeholder="079xxxxxxx" class="text-left" dir="ltr" required />
                <x-databank.forms.input label="البريد الإلكتروني" name="email" type="email" placeholder="info@example.com" class="text-left" dir="ltr" />
            </div>

            <hr class="border-white/5 my-2">

            <div x-data="{ isFreelance: true }" class="space-y-4">
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div class="space-y-2">
                        <label class="block text-slate-400 text-xs font-bold uppercase tracking-wider">المدينة <span class="text-red-500">*</span></label>
                        <div class="relative">
                            <select name="city" required class="block w-full bg-slate-950/50 border border-slate-700 rounded-xl px-4 py-3 text-white focus:border-blue-500 appearance-none outline-none">
                                <option value="" disabled selected>اختر المدينة...</option>
                                <option value="عمان">عمان</option>
                                <option value="الزرقاء">الزرقاء</option>
                                <option value="إربد">إربد</option>
                                <option value="العقبة">العقبة</option>
                                <option value="السلط">السلط</option>
                                <option value="مادبا">مادبا</option>
                                <option value="الكرك">الكرك</option>
                                <option value="جرش">جرش</option>
                                <option value="عجلون">عجلون</option>
                                <option value="المفرق">المفرق</option>
                                <option value="الطفيلة">الطفيلة</option>
                                <option value="معان">معان</option>
                            </select>
                            <div class="absolute left-4 top-1/2 -translate-y-1/2 pointer-events-none text-slate-500"><i class="fa-solid fa-chevron-down text-xs"></i></div>
                        </div>
                    </div>

                    <div class="flex items-center h-full pt-6">
                        <label class="flex items-center gap-3 cursor-pointer group">
                            <input type="checkbox" name="is_freelance" value="1" x-model="isFreelance" class="w-6 h-6 rounded-lg bg-slate-900 border-slate-600 text-blue-600 focus:ring-blue-500 cursor-pointer">
                            <span class="text-white text-sm group-hover:text-blue-400 transition">يغطي كافة المناطق (Freelance/Online)</span>
                        </label>
                    </div>
                </div>

                <div x-show="!isFreelance" x-transition class="space-y-2">
                    <x-databank.forms.input label="رابط الموقع (Google Maps)" name="location_link" placeholder="https://maps.google.com/..." class="text-left" dir="ltr" />
                </div>
            </div>

        </x-databank.forms.create>
    </div>

        <x-databank.forms.show formName="المزودين" routeName="providers" searchPlaceholder="ابحث بالاسم أو الهاتف...">
       
            <x-databank.tables.table>
                <x-databank.tables.thead>
                    <tr>
                        <x-databank.tables.th>ID</x-databank.tables.th>
                        <x-databank.tables.th>الاسم</x-databank.tables.th>
                        <x-databank.tables.th>التصنيف</x-databank.tables.th>
                        <x-databank.tables.th>التواصل</x-databank.tables.th>
                        <x-databank.tables.th>الموقع</x-databank.tables.th>
                        <x-databank.tables.th>الإجراءات</x-databank.tables.th>
                    </tr>
                </x-databank.tables.thead>
                
                <x-databank.tables.tbody>
                    @forelse($providers as $provider)
                        <x-databank.tables.tr>
                            
                            <x-databank.tables.td>
                                <span class="font-mono text-slate-400 text-xs">#{{ $provider->id }}</span>
                            </x-databank.tables.td>
                            
                            <x-databank.tables.td>
                                <div class="flex flex-col">
                                    <span class="text-white font-bold text-sm">{{ $provider->name_ar }}</span>
                                    <span class="text-slate-500 text-[10px]">{{ $provider->name_en }}</span>
                                </div>
                            </x-databank.tables.td>

                            <x-databank.tables.td>
                                <span class="bg-slate-800 text-slate-300 px-3 py-1 rounded-lg border border-white/5 text-xs">
                                    {{ $provider->category->name_ar ?? 'غير محدد' }}
                                </span>
                            </x-databank.tables.td>

                            <x-databank.tables.td>
                                <div class="flex items-center gap-2">
                                    <a href="https://wa.me/{{ $provider->phone }}" target="_blank" class="w-8 h-8 rounded-lg bg-green-500/10 text-green-500 hover:bg-green-500 hover:text-white border border-green-500/20 flex items-center justify-center transition" title="WhatsApp">
                                        <i class="fa-brands fa-whatsapp"></i>
                                    </a>
                                    
                                    @if($provider->email)
                                        <a href="mailto:{{ $provider->email }}" class="w-8 h-8 rounded-lg bg-blue-500/10 text-blue-500 hover:bg-blue-500 hover:text-white border border-blue-500/20 flex items-center justify-center transition" title="Email">
                                            <i class="fa-regular fa-envelope"></i>
                                        </a>
                                    @endif
                                </div>
                            </x-databank.tables.td>

                            <x-databank.tables.td>
                                <div class="flex flex-col gap-1">
                                    <span class="text-white text-xs font-bold">{{ $provider->city }}</span>
                                    @if($provider->is_freelance)
                                        <span class="text-[10px] text-purple-400 bg-purple-500/10 px-2 py-0.5 rounded w-fit">عمل حر / كل المناطق</span>
                                    @elseif($provider->location_link)
                                        <a href="{{ $provider->location_link }}" target="_blank" class="text-[10px] text-blue-400 hover:text-white underline flex items-center gap-1">
                                            <i class="fa-solid fa-location-dot"></i> الموقع عالخريطة
                                        </a>
                                    @endif
                                </div>
                            </x-databank.tables.td>

                            <x-databank.tables.td>
                                <div class="flex items-center gap-2">
                                    
                                    <x-databank.edit-modal id="{{ $provider->id }}" entityName="Provider" :element="$provider" routeName="providers">
                                        <div class="space-y-4">
                                            <label class="block text-slate-400 text-xs font-bold">التصنيف</label>
                                            <select name="category_id" class="block w-full bg-slate-950/50 border border-slate-700 rounded-xl px-4 py-3 text-white">
                                                @foreach($categories as $category)
                                                    <option value="{{ $category->id }}" {{ $provider->category_id == $category->id ? 'selected' : '' }}>{{ $category->name_ar }}</option>
                                                @endforeach
                                            </select>
                                            
                                            <x-databank.forms.input label="الاسم عربي" name="name_ar" value="{{ $provider->name_ar }}" />
                                            <x-databank.forms.input label="الاسم انجليزي" name="name_en" value="{{ $provider->name_en }}" dir="ltr" />
                                            <x-databank.forms.input label="الهاتف" name="phone" value="{{ $provider->phone }}" dir="ltr" />
                                            <x-databank.forms.input label="الإيميل" name="email" value="{{ $provider->email }}" dir="ltr" />
                                            
                                            <label class="block text-slate-400 text-xs font-bold">المدينة</label>
                                            <select name="city" class="block w-full bg-slate-950/50 border border-slate-700 rounded-xl px-4 py-3 text-white">
                                                <option value="{{ $provider->city }}" selected>{{ $provider->city }}</option>
                                                <option value="عمان">عمان</option>
                                                </select>

                                            <div class="flex items-center gap-2 pt-2">
                                                <input type="checkbox" name="is_freelance" value="1" {{ $provider->is_freelance ? 'checked' : '' }} class="w-5 h-5 bg-slate-900 border-slate-600 rounded">
                                                <span class="text-white text-sm">عمل حر / كل المناطق</span>
                                            </div>

                                            <x-databank.forms.input label="رابط الموقع" name="location_link" value="{{ $provider->location_link }}" dir="ltr" />
                                        </div>
                                    </x-databank.edit-modal>

                                    <x-databank.delete-modal id="{{ $provider->id }}" :element="$provider" routeName="providers" entityName="المزود" />
                                </div>
                            </x-databank.tables.td>

                        </x-databank.tables.tr>
                    @empty
                        <tr>
                            <td colspan="6" class="py-12 text-center text-slate-500">
                                <p>لا يوجد مزودين مضافين حتى الآن</p>
                            </td>
                        </tr>
                    @endforelse
                </x-databank.tables.tbody>
            </x-databank.tables.table>

        </x-databank.forms.show>

    </x-databank.forms.section>

@endsection