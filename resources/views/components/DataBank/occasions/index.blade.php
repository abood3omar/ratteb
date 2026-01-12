@extends('components.layout')

@section('title', 'أنواع المناسبات')

@section('content')

    <div class="flex justify-between items-center mb-8 fade-in">
        <div>
            <h1 class="text-3xl font-black text-white mb-2">أنواع المناسبات 🎉</h1>
            <p class="text-slate-400">عرف المناسبات (زفاف، تخرج..) وحدد الخدمات اللي بتلزمها.</p>
        </div>
    </div>

    <x-databank.forms.section formName="مناسبة">
        
        <x-databank.forms.create routeName="occasions" formName="Occasion">
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <x-databank.forms.input label="اسم المناسبة (عربي)" name="name_ar" placeholder="حفل زفاف" required />
                <x-databank.forms.input label="اسم المناسبة (انجليزي)" name="name_en" placeholder="Wedding" dir="ltr" required />
            </div>

            <div class="space-y-2">
                <label class="block text-slate-400 text-xs font-bold uppercase">الوصف (يظهر للمستخدم)</label>
                <textarea name="description" rows="2" class="block w-full bg-slate-950/50 border border-slate-700 rounded-xl px-4 py-3 text-white focus:outline-none focus:border-blue-500"></textarea>
            </div>

            <div class="space-y-2">
                <label class="block text-slate-400 text-xs font-bold uppercase">صورة الكارد</label>
                <input type="file" name="image" class="block w-full text-sm text-slate-400 border border-slate-700 rounded-xl bg-slate-950/50 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:bg-blue-500/10 file:text-blue-400">
            </div>

            <div class="space-y-3 mt-4">
                <label class="block text-slate-400 text-xs font-bold uppercase">الخدمات المطلوبة لهذه المناسبة <span class="text-red-500">*</span></label>
                <div class="grid grid-cols-2 md:grid-cols-3 gap-3 bg-slate-950/50 p-4 rounded-xl border border-slate-700 max-h-40 overflow-y-auto custom-scrollbar">
                    @foreach($categories as $category)
                        <label class="flex items-center gap-2 cursor-pointer group hover:bg-white/5 p-2 rounded-lg transition">
                            <input type="checkbox" name="categories[]" value="{{ $category->id }}" class="w-4 h-4 rounded bg-slate-900 border-slate-600 text-blue-600 focus:ring-blue-500 cursor-pointer">
                            <span class="text-xs text-slate-300 group-hover:text-white select-none">{{ $category->name_ar }}</span>
                        </label>
                    @endforeach
                </div>
            </div>

        </x-databank.forms.create>
    </div>
        <x-databank.forms.show formName="المناسبات" routeName="occasions" searchPlaceholder="ابحث...">
            <x-databank.tables.table>
                <x-databank.tables.thead>
                    <tr>
                        <x-databank.tables.th>ID</x-databank.tables.th>
                        <x-databank.tables.th>المناسبة</x-databank.tables.th>
                        <x-databank.tables.th>الخدمات المربوطة</x-databank.tables.th>
                        <x-databank.tables.th>الإجراءات</x-databank.tables.th>
                    </tr>
                </x-databank.tables.thead>
                <x-databank.tables.tbody>
                    @forelse($occasions as $occasion)
                        <x-databank.tables.tr>
                            <x-databank.tables.td>#{{ $occasion->id }}</x-databank.tables.td>
                            <x-databank.tables.td>
                                <div class="flex items-center gap-3">
                                    @if($occasion->image)
                                        <img src="{{ asset('storage/' . $occasion->image) }}" class="w-10 h-10 rounded-lg object-cover border border-white/10">
                                    @else
                                        <div class="w-10 h-10 rounded-lg bg-slate-800 flex items-center justify-center"><i class="fa-solid fa-calendar text-slate-500"></i></div>
                                    @endif
                                    <div>
                                        <div class="text-white font-bold text-sm">{{ $occasion->name_ar }}</div>
                                        <div class="text-slate-500 text-[10px]">{{ $occasion->name_en }}</div>
                                    </div>
                                </div>
                            </x-databank.tables.td>
                            <x-databank.tables.td>
                                <div class="flex flex-wrap gap-1">
                                    @foreach($occasion->categories as $cat)
                                        <span class="bg-blue-500/10 text-blue-400 border border-blue-500/20 px-2 py-0.5 rounded text-[10px]">{{ $cat->name_ar }}</span>
                                    @endforeach
                                </div>
                            </x-databank.tables.td>
                            <x-databank.tables.td>
                                <div class="flex items-center gap-2">
                                    <x-databank.edit-modal id="{{ $occasion->id }}" entityName="Occasion" :element="$occasion" routeName="occasions">
                                        <div class="space-y-4">
                                            <x-databank.forms.input label="عربي" name="name_ar" value="{{ $occasion->name_ar }}" />
                                            <x-databank.forms.input label="انجليزي" name="name_en" value="{{ $occasion->name_en }}" dir="ltr" />
                                            <textarea name="description" rows="2" class="block w-full bg-slate-950/50 border border-slate-700 rounded-xl px-4 py-3 text-white">{{ $occasion->description }}</textarea>
                                            
                                            <input type="file" name="image" class="block w-full text-sm text-slate-400 border border-slate-700 rounded-xl bg-slate-950/50">

                                            <div class="space-y-2">
                                                <label class="text-xs font-bold text-slate-400">تعديل الخدمات</label>
                                                <div class="grid grid-cols-2 gap-2 bg-slate-950/50 p-3 rounded-xl border border-slate-700 max-h-40 overflow-y-auto">
                                                    @foreach($categories as $category)
                                                        <label class="flex items-center gap-2 cursor-pointer">
                                                            <input type="checkbox" name="categories[]" value="{{ $category->id }}" 
                                                                   {{ $occasion->categories->contains($category->id) ? 'checked' : '' }}
                                                                   class="w-4 h-4 rounded bg-slate-900 border-slate-600 text-blue-600">
                                                            <span class="text-xs text-slate-300">{{ $category->name_ar }}</span>
                                                        </label>
                                                    @endforeach
                                                </div>
                                            </div>
                                        </div>
                                    </x-databank.edit-modal>

                                    <x-databank.delete-modal id="{{ $occasion->id }}" :element="$occasion" routeName="occasions" entityName="المناسبة" />
                                </div>
                            </x-databank.tables.td>
                        </x-databank.tables.tr>
                    @empty
                        <tr><td colspan="4" class="text-center py-8 text-slate-500">لا يوجد مناسبات</td></tr>
                    @endforelse
                </x-databank.tables.tbody>
            </x-databank.tables.table>
        </x-databank.forms.show>
    </x-databank.forms.section>
@endsection