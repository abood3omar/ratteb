@extends('components.layout')

@section('title', 'إدارة التصنيفات')

@section('content')

    <div class="flex flex-col md:flex-row justify-between items-center mb-8 fade-in">
        <div>
            <h1 class="text-3xl font-black text-white mb-2">إدارة التصنيفات 📂</h1>
            <p class="text-slate-400">إدارة الأقسام الرئيسية وترتيب ظهورها.</p>
        </div>
    </div>

    <x-databank.forms.section formName="تصنيف">
        
        <x-databank.forms.create routeName="categories" formName="Category">
            
            <x-databank.forms.input 
                label="اسم التصنيف (بالعربي)" 
                name="name_ar" 
                placeholder="مثلاً: قاعات أفراح" 
                required 
            />

            <x-databank.forms.input 
                label="اسم التصنيف (انجليزي)" 
                name="name_en" 
                placeholder="e.g. Wedding Halls" 
                class="text-left" 
                dir="ltr"
                required
            />

            <x-databank.forms.input 
                label="ترتيب الظهور" 
                name="display_order" 
                type="number"
                placeholder="1" 
                required 
            />

        </x-databank.forms.create>

    </div>
        <x-databank.forms.show formName="التصنيفات" routeName="categories" searchPlaceholder="ابحث بالاسم...">
       
            <x-databank.tables.table>
                <x-databank.tables.thead>
                    <tr>
                        <x-databank.tables.th>ID</x-databank.tables.th>
                        <x-databank.tables.th>الاسم</x-databank.tables.th>
                        <x-databank.tables.th>عدد المزودين</x-databank.tables.th>
                        <x-databank.tables.th>الترتيب</x-databank.tables.th>
                        <x-databank.tables.th>الإجراءات</x-databank.tables.th>
                    </tr>
                </x-databank.tables.thead>
                
                <x-databank.tables.tbody>
                    @forelse($categories as $category)
                        <x-databank.tables.tr>
                            
                            <x-databank.tables.td>
                                <span class="font-mono text-slate-400 text-xs">#{{ $category->id }}</span>
                            </x-databank.tables.td>
                            
                            <x-databank.tables.td>
                                <div class="flex flex-col">
                                    <span class="text-white font-bold text-sm">{{ $category->name_ar }}</span>
                                    <span class="text-slate-500 text-[10px]">{{ $category->name_en }}</span>
                                </div>
                            </x-databank.tables.td>

                            <x-databank.tables.td>
                                <span class="bg-blue-500/10 text-blue-400 px-3 py-1 rounded-lg border border-blue-500/20 font-mono text-xs font-bold">
                                    {{ $category->providers_count }}
                                </span>
                            </x-databank.tables.td>

                            <x-databank.tables.td>
                                <span class="bg-white/5 text-white px-3 py-1 rounded-lg border border-white/10 font-mono text-xs">
                                    {{ $category->display_order }}
                                </span>
                            </x-databank.tables.td>

                            <x-databank.tables.td>
                                <div class="flex items-center gap-2">
                                    
                                    <x-databank.edit-modal id="{{ $category->id }}" entityName="Category" :element="$category" routeName="categories">
                                        <div class="grid grid-cols-1 gap-4">
                                            <x-databank.forms.input label="الاسم بالعربي" name="name_ar" value="{{ $category->name_ar }}" />
                                            <x-databank.forms.input label="الاسم بالانجليزي" name="name_en" value="{{ $category->name_en }}" />
                                            <x-databank.forms.input label="الترتيب" name="display_order" type="number" value="{{ $category->display_order }}" />
                                        </div>
                                    </x-databank.edit-modal>

                                    <x-databank.delete-modal id="{{ $category->id }}" :element="$category" routeName="categories" entityName="التصنيف" />
                                </div>
                            </x-databank.tables.td>

                        </x-databank.tables.tr>
                    @empty
                        <tr>
                            <td colspan="5" class="py-12 text-center text-slate-500">
                                <p>لا يوجد تصنيفات مضافة حتى الآن</p>
                            </td>
                        </tr>
                    @endforelse
                </x-databank.tables.tbody>
            </x-databank.tables.table>

         <div class="mt-6 pt-4 border-t border-white/5 flex justify-center">
    {{-- {{ $categories->links() }}  --}}
</div>

        </x-databank.forms.show>

    </x-databank.forms.section>

@endsection