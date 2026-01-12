@extends('components.layout')

@section('title', 'إدارة الأدوار والصلاحيات')

@section('content')

    <div class="flex flex-col md:flex-row justify-between items-center mb-8 fade-in relative z-10" x-data="{ showAddRoleModal: false }">
        <div>
            <h1 class="text-3xl font-black text-white mb-2">إدارة الأدوار والصلاحيات 🛡️</h1>
            <p class="text-slate-400">تحكم في صلاحيات الوصول والأدوار في النظام.</p>
        </div>
        
        <button @click="showAddRoleModal = true" class="mt-4 md:mt-0 bg-blue-600 hover:bg-blue-500 text-white px-6 py-3 rounded-2xl font-bold shadow-lg shadow-blue-900/20 transition-all flex items-center gap-2 hover:-translate-y-1">
            <i class="fa-solid fa-plus"></i> إضافة دور جديد
        </button>

        {{-- ============================ --}}
        {{-- مودال الإضافة (مع Teleport) --}}
        {{-- ============================ --}}
        <template x-teleport="body">
            <div x-show="showAddRoleModal" x-transition.opacity style="display: none;" class="fixed inset-0 z-[9999] flex items-center justify-center bg-slate-950/80 backdrop-blur-sm p-4">
                <div @click.away="showAddRoleModal = false" class="bg-slate-900 border border-white/10 rounded-[2rem] w-full max-w-lg shadow-2xl relative overflow-hidden transform transition-all animate-scale-up">
                    <div class="absolute top-0 w-full h-1 bg-gradient-to-r from-blue-500 to-indigo-500"></div>
                    <div class="p-8">
                        <h3 class="text-xl font-bold text-white mb-6">إضافة دور جديد</h3>
                        <form action="{{ url('/role-rights/add') }}" method="POST">
                            @csrf
                            <div class="mb-6">
                                <label class="block text-slate-400 text-xs font-bold mb-2">اسم الدور</label>
                                <input type="text" name="name" class="w-full bg-slate-950/50 border border-slate-700 rounded-xl px-4 py-3 text-white focus:border-blue-500 transition" required>
                            </div>
                            <div class="flex justify-end gap-3">
                                <button type="button" @click="showAddRoleModal = false" class="px-5 py-2.5 rounded-xl text-slate-300 hover:bg-white/5 transition font-bold">إلغاء</button>
                                <button type="submit" class="px-6 py-2.5 rounded-xl bg-blue-600 hover:bg-blue-500 text-white font-bold transition shadow-lg">حفظ</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </template>
    </div>

    @if(session('success'))
        <div class="bg-green-500/10 border border-green-500/20 text-green-400 p-4 rounded-2xl mb-6 flex items-center gap-3 animate-fade-in font-bold"><i class="fa-solid fa-circle-check text-lg"></i> {{ session('success') }}</div>
    @endif
    @if(session('error'))
        <div class="bg-red-500/10 border border-red-500/20 text-red-400 p-4 rounded-2xl mb-6 flex items-center gap-3 animate-fade-in font-bold"><i class="fa-solid fa-circle-exclamation text-lg"></i> {{ session('error') }}</div>
    @endif

    <div class="bg-slate-900/60 backdrop-blur-xl border border-white/10 rounded-[2rem] overflow-hidden shadow-2xl fade-in relative z-0" style="animation-delay: 0.1s;">
        <div class="overflow-x-auto">
            <table class="w-full text-right">
                <thead class="bg-white/5 text-blue-400 uppercase tracking-wider text-xs font-bold border-b border-white/5">
                    <tr>
                        <th class="px-6 py-5">اسم الدور</th>
                        <th class="px-6 py-5">عدد الصلاحيات</th>
                        <th class="px-6 py-5 text-center">الإجراءات</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-white/5 text-slate-300 text-sm font-medium">
                    @foreach($roles as $role)
                        <tr class="hover:bg-white/5 transition-colors duration-200" x-data="{ showEditModal: false, showPermissionsModal: false, showDeleteModal: false }">
                            <td class="px-6 py-4 font-bold text-white">{{ $role->RoleName }}</td>
                            <td class="px-6 py-4">
                                <span class="bg-blue-900/30 text-blue-300 px-3 py-1 rounded-lg border border-blue-500/20 font-mono">{{ $role->permissions->count() }}</span>
                            </td>
                            <td class="px-6 py-4">
                                <div class="flex items-center justify-center gap-2">
                                    <button @click="showPermissionsModal = true" class="px-3 py-1.5 rounded-lg bg-slate-800 hover:bg-slate-700 text-white border border-white/10 transition text-xs font-bold">عرض</button>
                                    <button @click="showEditModal = true" class="px-3 py-1.5 rounded-lg bg-yellow-600/20 hover:bg-yellow-600/40 text-yellow-400 border border-yellow-600/20 transition text-xs font-bold">تعديل</button>
                                    <button @click="showDeleteModal = true" class="px-3 py-1.5 rounded-lg bg-red-600/20 hover:bg-red-600/40 text-red-400 border border-red-600/20 transition text-xs font-bold">حذف</button>
                                </div>

                                {{-- ============================ --}}
                                {{-- مودال التعديل (مع Teleport) --}}
                                {{-- ============================ --}}
                                <template x-teleport="body">
                                    <div x-show="showEditModal" x-transition.opacity style="display: none;" class="fixed inset-0 z-[9999] flex items-center justify-center bg-slate-950/80 backdrop-blur-sm p-4">
                                        <div @click.away="showEditModal = false" class="bg-slate-900 border border-white/10 rounded-[2rem] w-full max-w-6xl shadow-2xl relative flex flex-col max-h-[90vh]">
                                            <div class="p-6 border-b border-white/5 bg-slate-900 flex justify-between items-center rounded-t-[2rem]">
                                                <h3 class="text-xl font-bold text-white">تعديل صلاحيات: <span class="text-yellow-500">{{ $role->RoleName }}</span></h3>
                                                <button @click="showEditModal = false" class="text-slate-400 hover:text-white"><i class="fa-solid fa-xmark text-xl"></i></button>
                                            </div>
                                            <div class="p-6 overflow-y-auto custom-scrollbar flex-grow">
                                                <form action="{{ url('/role-rights/edit/' . $role->RoleID) }}" method="POST">
                                                    @csrf
                                                    <div class="mb-8">
                                                        <label class="block text-slate-400 text-xs font-bold mb-2">اسم الدور</label>
                                                        <input type="text" name="name" value="{{ $role->RoleName }}" class="w-full bg-slate-950/50 border border-slate-700 rounded-xl px-4 py-3 text-white focus:border-yellow-500 transition font-bold">
                                                    </div>
                                                    <div class="space-y-8">
                                                        @foreach($pageModules as $module)
                                                            <div class="bg-white/5 rounded-2xl border border-white/5 overflow-hidden">
                                                                <div class="bg-white/5 px-6 py-3 border-b border-white/5 flex items-center gap-2">
                                                                    <i class="fa-solid fa-layer-group text-blue-400"></i>
                                                                    <h3 class="text-white font-bold text-sm">{{ $module->ModuleName }}</h3>
                                                                </div>
                                                                <div class="overflow-x-auto">
                                                                    <table class="w-full text-right">
                                                                        <thead>
                                                                            <tr class="bg-slate-950/30 text-slate-400 text-xs border-b border-white/5">
                                                                                <th class="px-6 py-3 w-1/4">الكيان</th>
                                                                                @foreach($pageActions as $action)
                                                                                    <th class="px-4 py-3 text-center">{{ $action->ActionName }}</th>
                                                                                @endforeach
                                                                            </tr>
                                                                        </thead>
                                                                        <tbody class="divide-y divide-white/5 text-sm text-slate-300">
                                                                            @foreach($module->entities as $entity)
                                                                                <tr class="hover:bg-white/5 transition">
                                                                                    <td class="px-6 py-3 font-medium text-white">{{ $entity->EntityName }}</td>
                                                                                    @foreach($pageActions as $action)
                                                                                        <td class="px-4 py-3 text-center">
                                                                                            @if($entity->actions->contains('ActionID', $action->ActionID))
                                                                                                <div class="flex justify-center">
                                                                                                    <label class="relative flex items-center justify-center cursor-pointer p-2">
                                                                                                        <input type="checkbox" name="permissions[{{ $entity->EntityID }}][]" value="{{ $action->ActionID }}" 
                                                                                                            {{ $role->permissions()->where('entity_id', $entity->EntityID)->where('action_id', $action->ActionID)->exists() ? 'checked' : '' }}
                                                                                                            class="peer sr-only">
                                                                                                        <div class="w-5 h-5 border-2 border-slate-600 rounded-md peer-checked:bg-yellow-500 peer-checked:border-yellow-500 transition-all"></div>
                                                                                                        <i class="fa-solid fa-check text-slate-900 absolute opacity-0 peer-checked:opacity-100 text-xs transition-opacity pointer-events-none"></i>
                                                                                                    </label>
                                                                                                </div>
                                                                                            @else
                                                                                                <span class="block w-4 h-1 bg-white/5 rounded-full mx-auto"></span>
                                                                                            @endif
                                                                                        </td>
                                                                                    @endforeach
                                                                                </tr>
                                                                            @endforeach
                                                                        </tbody>
                                                                    </table>
                                                                </div>
                                                            </div>
                                                        @endforeach
                                                    </div>
                                                    <div class="flex justify-end gap-3 mt-8 pt-6 border-t border-white/10 sticky bottom-0 bg-slate-900 pb-2 z-20">
                                                        <button type="button" @click="showEditModal = false" class="px-6 py-2.5 rounded-xl text-slate-300 hover:bg-white/5 font-bold transition">إلغاء</button>
                                                        <button type="submit" class="px-8 py-2.5 rounded-xl bg-yellow-500 hover:bg-yellow-600 text-slate-900 font-bold transition shadow-lg">حفظ التعديلات</button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </template>

                                {{-- ============================ --}}
                                {{-- مودال العرض (مع Teleport) --}}
                                {{-- ============================ --}}
                                <template x-teleport="body">
                                    <div x-show="showPermissionsModal" x-transition.opacity style="display: none;" class="fixed inset-0 z-[9999] flex items-center justify-center bg-slate-950/80 backdrop-blur-sm p-4">
                                        <div @click.away="showPermissionsModal = false" class="bg-slate-900 border border-white/10 rounded-[2rem] w-full max-w-5xl shadow-2xl relative flex flex-col max-h-[90vh]">
                                            <div class="p-6 border-b border-white/5 bg-slate-900 flex justify-between items-center rounded-t-[2rem]">
                                                <h3 class="text-xl font-bold text-white">عرض صلاحيات: <span class="text-purple-400">{{ $role->RoleName }}</span></h3>
                                                <button @click="showPermissionsModal = false" class="text-slate-400 hover:text-white"><i class="fa-solid fa-xmark text-xl"></i></button>
                                            </div>
                                            <div class="p-6 overflow-y-auto custom-scrollbar flex-grow">
                                                <div class="space-y-8">
                                                    @foreach($pageModules as $module)
                                                        @php $hasPermissions = $role->permissions->whereIn('EntityID', $module->entities->pluck('EntityID'))->isNotEmpty(); @endphp
                                                        @if($hasPermissions)
                                                            <div class="bg-white/5 rounded-2xl border border-white/5 overflow-hidden">
                                                                <div class="bg-white/5 px-6 py-3 border-b border-white/5">
                                                                    <h3 class="text-blue-400 font-bold text-sm">{{ $module->ModuleName }}</h3>
                                                                </div>
                                                                <div class="overflow-x-auto">
                                                                    <table class="w-full text-right">
                                                                        <thead>
                                                                            <tr class="bg-slate-950/30 text-slate-400 text-xs border-b border-white/5">
                                                                                <th class="px-6 py-3 w-1/4">الكيان</th>
                                                                                <th class="px-6 py-3">الصلاحيات الممنوحة</th>
                                                                            </tr>
                                                                        </thead>
                                                                        <tbody class="divide-y divide-white/5 text-sm text-slate-300">
                                                                            @foreach($module->entities as $entity)
                                                                                @if($role->permissions->contains('EntityID', $entity->EntityID))
                                                                                    <tr>
                                                                                        <td class="px-6 py-3 font-medium text-white">{{ $entity->EntityName }}</td>
                                                                                        <td class="px-6 py-3">
                                                                                            <div class="flex flex-wrap gap-2">
                                                                                                @foreach($pageActions as $action)
                                                                                                    @if($role->permissions()->where('entity_id', $entity->EntityID)->where('action_id', $action->ActionID)->exists())
                                                                                                        <span class="inline-flex items-center gap-1 bg-green-500/10 text-green-400 border border-green-500/20 px-2 py-1 rounded text-xs font-bold">
                                                                                                            <i class="fa-solid fa-check"></i> {{ $action->ActionName }}
                                                                                                        </span>
                                                                                                    @endif
                                                                                                @endforeach
                                                                                            </div>
                                                                                        </td>
                                                                                    </tr>
                                                                                @endif
                                                                            @endforeach
                                                                        </tbody>
                                                                    </table>
                                                                </div>
                                                            </div>
                                                        @endif
                                                    @endforeach
                                                    @if($role->permissions->isEmpty())
                                                        <div class="text-center py-10 text-slate-500">لا توجد صلاحيات مسندة لهذا الدور</div>
                                                    @endif
                                                </div>
                                            </div>
                                            <div class="p-4 border-t border-white/10 bg-slate-900 rounded-b-[2rem] flex justify-end">
                                                <button @click="showPermissionsModal = false" class="px-6 py-2.5 rounded-xl bg-white/10 hover:bg-white/20 text-white font-bold transition">إغلاق</button>
                                            </div>
                                        </div>
                                    </div>
                                </template>

                                {{-- ============================ --}}
                                {{-- مودال الحذف (مع Teleport) --}}
                                {{-- ============================ --}}
                                <template x-teleport="body">
                                    <div x-show="showDeleteModal" x-transition.opacity style="display: none;" class="fixed inset-0 z-[9999] flex items-center justify-center bg-slate-950/80 backdrop-blur-sm p-4">
                                        <div @click.away="showDeleteModal = false" class="relative w-full max-w-md bg-slate-900 border border-white/10 rounded-[2rem] shadow-2xl p-8 text-center animate-scale-up">
                                            <div class="w-16 h-16 bg-red-500/10 text-red-500 rounded-full flex items-center justify-center text-3xl mx-auto mb-4 border border-red-500/20"><i class="fa-solid fa-trash-can"></i></div>
                                            <h3 class="text-xl font-bold text-white mb-2">تأكيد الحذف</h3>
                                            <p class="text-slate-400 mb-6 text-sm">هل أنت متأكد من حذف الدور <span class="text-white font-bold">"{{ $role->RoleName }}"</span>؟</p>
                                            <form action="{{ url('/role-rights/delete/' . $role->RoleID) }}" method="POST" class="flex justify-center gap-3">
                                                @csrf @method('DELETE')
                                                <button type="button" @click="showDeleteModal = false" class="px-5 py-2.5 rounded-xl text-slate-300 hover:bg-white/5 border border-white/5 font-bold transition">إلغاء</button>
                                                <button type="submit" class="px-6 py-2.5 rounded-xl bg-red-600 hover:bg-red-500 text-white font-bold shadow-lg shadow-red-900/20 transition">نعم، احذف</button>
                                            </form>
                                        </div>
                                    </div>
                                </template>

                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

@endsection