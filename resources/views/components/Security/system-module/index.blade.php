@extends('components.layout')

@section('title', 'هيكلية النظام')

@section('content')

    {{-- ================= HEADER SECTION ================= --}}
    <div class="flex flex-col md:flex-row justify-between items-center mb-10 fade-in">
        <div>
            <h1 class="text-3xl font-black text-white mb-2">هيكلية النظام ⚙️</h1>
            <p class="text-slate-400">إدارة الوحدات، الكيانات، وربط الإجراءات بها.</p>
        </div>
    </div>

    {{-- ================= MAIN GRID SECTION ================= --}}
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8 fade-in" style="animation-delay: 0.1s;">
        
        {{-- 1. Modules Column --}}
        <div class="bg-slate-900/60 backdrop-blur-xl border border-white/10 rounded-[2rem] p-6 shadow-xl flex flex-col h-[700px]">
            <div class="flex justify-between items-center mb-6 pb-4 border-b border-white/5">
                <h2 class="text-xl font-bold text-blue-400 flex items-center gap-2">
                    <i class="fa-solid fa-cubes"></i> الوحدات
                </h2>
                {{-- لاحظ استخدام onclick بدلاً من data-modal-toggle --}}
                <button onclick="openModal('addModuleModal')" class="w-8 h-8 rounded-lg bg-blue-600 hover:bg-blue-500 text-white flex items-center justify-center transition shadow-lg shadow-blue-900/20">
                    <i class="fa-solid fa-plus"></i>
                </button>
            </div>
            <div class="flex-grow overflow-y-auto custom-scrollbar pr-1">
                @foreach($pageModules as $module)
                    <div class="bg-slate-950/50 p-4 rounded-xl border border-white/5 hover:border-blue-500/30 transition flex justify-between items-center group mb-3">
                        <span class="text-white font-medium text-sm">{{ $module->ModuleName }}</span>
                        <div class="flex gap-2 opacity-0 group-hover:opacity-100 transition duration-200">
                            <button onclick="openModal('editModuleModal_{{ $module->ModuleID }}')" class="text-yellow-400 hover:text-yellow-300"><i class="fa-solid fa-pen"></i></button>
                            <button onclick="openModal('deleteModuleModal_{{ $module->ModuleID }}')" class="text-red-400 hover:text-red-300"><i class="fa-solid fa-trash"></i></button>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>

        {{-- 2. Entities Column --}}
        <div class="bg-slate-900/60 backdrop-blur-xl border border-white/10 rounded-[2rem] p-6 shadow-xl flex flex-col h-[700px]">
            <div class="flex justify-between items-center mb-6 pb-4 border-b border-white/5">
                <h2 class="text-xl font-bold text-purple-400 flex items-center gap-2">
                    <i class="fa-solid fa-layer-group"></i> الكيانات
                </h2>
                <button onclick="openModal('addEntityModal')" class="w-8 h-8 rounded-lg bg-purple-600 hover:bg-purple-500 text-white flex items-center justify-center transition shadow-lg shadow-purple-900/20">
                    <i class="fa-solid fa-plus"></i>
                </button>
            </div>
            <div class="flex-grow overflow-y-auto custom-scrollbar pr-1">
                @foreach($pageEntities as $entity)
                    <div class="bg-slate-950/50 p-4 rounded-xl border border-white/5 hover:border-purple-500/30 transition group mb-3 relative">
                        <div class="flex justify-between items-center mb-1">
                            <span class="text-white font-medium text-sm">{{ $entity->EntityName }}</span>
                            
                            <div class="flex gap-2 opacity-0 group-hover:opacity-100 transition duration-200 bg-slate-900/80 rounded-lg px-2">
                                <button onclick="openModal('entityActionsModal_{{ $entity->EntityID }}')" class="text-green-400 hover:text-green-300" title="ربط الإجراءات">
                                    <i class="fa-solid fa-bolt"></i>
                                </button>
                                <div class="w-px h-4 bg-white/20 my-auto"></div>
                                <button onclick="openModal('editEntityModal_{{ $entity->EntityID }}')" class="text-yellow-400 hover:text-yellow-300" title="تعديل">
                                    <i class="fa-solid fa-pen"></i>
                                </button>
                                <button onclick="openModal('deleteEntityModal_{{ $entity->EntityID }}')" class="text-red-400 hover:text-red-300" title="حذف">
                                    <i class="fa-solid fa-trash"></i>
                                </button>
                            </div>
                        </div>
                        <div class="flex justify-between items-end">
                            <p class="text-[10px] text-slate-500">{{ $entity->module->ModuleName }}</p>
                            <span class="text-[10px] bg-purple-500/10 text-purple-300 px-2 py-0.5 rounded border border-purple-500/20">
                                {{ $entity->actions->count() }} إجراءات
                            </span>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>

        {{-- 3. Actions Column --}}
        <div class="bg-slate-900/60 backdrop-blur-xl border border-white/10 rounded-[2rem] p-6 shadow-xl flex flex-col h-[700px]">
            <div class="flex justify-between items-center mb-6 pb-4 border-b border-white/5">
                <h2 class="text-xl font-bold text-pink-400 flex items-center gap-2">
                    <i class="fa-solid fa-bolt"></i> الإجراءات
                </h2>
                <button onclick="openModal('addActionModal')" class="w-8 h-8 rounded-lg bg-pink-600 hover:bg-pink-500 text-white flex items-center justify-center transition shadow-lg shadow-pink-900/20">
                    <i class="fa-solid fa-plus"></i>
                </button>
            </div>
            <div class="flex-grow overflow-y-auto custom-scrollbar pr-1">
                @foreach($pageActions as $action)
                    <div class="bg-slate-950/50 p-4 rounded-xl border border-white/5 hover:border-pink-500/30 transition flex justify-between items-center group mb-3">
                        <span class="text-white font-medium text-sm">{{ $action->ActionName }}</span>
                        <div class="flex gap-2 opacity-0 group-hover:opacity-100 transition duration-200">
                            <button onclick="openModal('editActionModal_{{ $action->ActionID }}')" class="text-yellow-400 hover:text-yellow-300"><i class="fa-solid fa-pen"></i></button>
                            <button onclick="openModal('deleteActionModal_{{ $action->ActionID }}')" class="text-red-400 hover:text-red-300"><i class="fa-solid fa-trash"></i></button>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>

    {{-- ================= MODALS SECTION (THE FIX) ================= --}}
    {{-- 
        تم تعديل جميع المودالات لتستخدم:
        1. id فريد
        2. class="relative z-[100000] hidden"
        3. طبقة خلفية تغلق المودال عند الضغط عليها
        4. حاوية سكرول داخلية
    --}}

    <div id="addModuleModal" class="relative z-[100000] hidden" aria-labelledby="modal-title" role="dialog" aria-modal="true">
        <div class="fixed inset-0 bg-gray-900/90 backdrop-blur-md transition-opacity" onclick="closeModal('addModuleModal')"></div>
        <div class="fixed inset-0 z-10 w-screen overflow-y-auto">
            <div class="flex min-h-full items-end justify-center p-4 text-center sm:items-center sm:p-0">
                <div class="relative transform overflow-hidden rounded-[2rem] bg-slate-900 border border-white/10 text-left shadow-2xl transition-all sm:my-8 sm:w-full sm:max-w-sm p-8">
                    <h3 class="text-lg font-bold text-white mb-6 text-center">إضافة وحدة جديدة</h3>
                    <form action="{{ url('/system-module/add') }}" method="POST">
                        @csrf
                        <input type="text" name="name" class="w-full bg-slate-950/50 border border-slate-700 rounded-xl px-4 py-3 text-white focus:border-blue-500 transition mb-6" placeholder="اسم الوحدة" required>
                        <div class="flex justify-end gap-3">
                            <button type="button" onclick="closeModal('addModuleModal')" class="px-4 py-2 rounded-xl text-slate-300 hover:bg-white/5">إلغاء</button>
                            <button type="submit" class="px-5 py-2 rounded-xl bg-blue-600 hover:bg-blue-500 text-white font-bold">حفظ</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div id="addEntityModal" class="relative z-[100000] hidden" aria-labelledby="modal-title" role="dialog" aria-modal="true">
        <div class="fixed inset-0 bg-gray-900/90 backdrop-blur-md transition-opacity" onclick="closeModal('addEntityModal')"></div>
        <div class="fixed inset-0 z-10 w-screen overflow-y-auto">
            <div class="flex min-h-full items-end justify-center p-4 text-center sm:items-center sm:p-0">
                <div class="relative transform overflow-hidden rounded-[2rem] bg-slate-900 border border-white/10 text-left shadow-2xl transition-all sm:my-8 sm:w-full sm:max-w-sm p-8">
                    <h3 class="text-lg font-bold text-white mb-6 text-center">إضافة كيان جديد</h3>
                    <form action="{{ url('/system-module/entity/add') }}" method="POST">
                        @csrf
                        <input type="text" name="name" class="w-full bg-slate-950/50 border border-slate-700 rounded-xl px-4 py-3 text-white focus:border-purple-500 transition mb-4" placeholder="اسم الكيان" required>
                        <select name="module_id" class="w-full bg-slate-950/50 border border-slate-700 rounded-xl px-4 py-3 text-white focus:border-purple-500 transition mb-6">
                            <option value="" disabled selected>اختر الوحدة</option>
                            @foreach($pageModules as $module)
                                <option value="{{ $module->ModuleID }}">{{ $module->ModuleName }}</option>
                            @endforeach
                        </select>
                        <div class="flex justify-end gap-3">
                            <button type="button" onclick="closeModal('addEntityModal')" class="px-4 py-2 rounded-xl text-slate-300 hover:bg-white/5">إلغاء</button>
                            <button type="submit" class="px-5 py-2 rounded-xl bg-purple-600 hover:bg-purple-500 text-white font-bold">حفظ</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div id="addActionModal" class="relative z-[100000] hidden" aria-labelledby="modal-title" role="dialog" aria-modal="true">
        <div class="fixed inset-0 bg-gray-900/90 backdrop-blur-md transition-opacity" onclick="closeModal('addActionModal')"></div>
        <div class="fixed inset-0 z-10 w-screen overflow-y-auto">
            <div class="flex min-h-full items-end justify-center p-4 text-center sm:items-center sm:p-0">
                <div class="relative transform overflow-hidden rounded-[2rem] bg-slate-900 border border-white/10 text-left shadow-2xl transition-all sm:my-8 sm:w-full sm:max-w-sm p-8">
                    <h3 class="text-lg font-bold text-white mb-6 text-center">إضافة إجراء جديد</h3>
                    <form action="{{ url('/system-module/action/add') }}" method="POST">
                        @csrf
                        <input type="text" name="name" class="w-full bg-slate-950/50 border border-slate-700 rounded-xl px-4 py-3 text-white focus:border-pink-500 transition mb-6" placeholder="اسم الإجراء" required>
                        <div class="flex justify-end gap-3">
                            <button type="button" onclick="closeModal('addActionModal')" class="px-4 py-2 rounded-xl text-slate-300 hover:bg-white/5">إلغاء</button>
                            <button type="submit" class="px-5 py-2 rounded-xl bg-pink-600 hover:bg-pink-500 text-white font-bold">حفظ</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    {{-- LOOPS FOR EDIT/DELETE MODALS --}}

    @foreach($pageModules as $module)
        <div id="editModuleModal_{{ $module->ModuleID }}" class="relative z-[100000] hidden" role="dialog" aria-modal="true">
            <div class="fixed inset-0 bg-gray-900/90 backdrop-blur-md transition-opacity" onclick="closeModal('editModuleModal_{{ $module->ModuleID }}')"></div>
            <div class="fixed inset-0 z-10 w-screen overflow-y-auto">
                <div class="flex min-h-full items-end justify-center p-4 text-center sm:items-center sm:p-0">
                    <div class="relative transform overflow-hidden rounded-[2rem] bg-slate-900 border border-white/10 text-left shadow-2xl transition-all sm:my-8 sm:w-full sm:max-w-sm p-8">
                        <h3 class="text-lg font-bold text-white mb-6">تعديل الوحدة</h3>
                        <form action="{{ url('/system-module/edit/' . $module->ModuleID) }}" method="POST">
                            @csrf
                            <input type="text" name="name" value="{{ $module->ModuleName }}" class="w-full bg-slate-950/50 border border-slate-700 rounded-xl px-4 py-3 text-white focus:border-yellow-500 transition mb-6" required>
                            <div class="flex justify-end gap-3">
                                <button type="button" onclick="closeModal('editModuleModal_{{ $module->ModuleID }}')" class="px-4 py-2 rounded-xl text-slate-300 hover:bg-white/5">إلغاء</button>
                                <button type="submit" class="px-5 py-2 rounded-xl bg-yellow-500 hover:bg-yellow-600 text-slate-900 font-bold">حفظ</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <div id="deleteModuleModal_{{ $module->ModuleID }}" class="relative z-[100000] hidden" role="dialog" aria-modal="true">
            <div class="fixed inset-0 bg-gray-900/90 backdrop-blur-md transition-opacity" onclick="closeModal('deleteModuleModal_{{ $module->ModuleID }}')"></div>
            <div class="fixed inset-0 z-10 w-screen overflow-y-auto">
                <div class="flex min-h-full items-end justify-center p-4 text-center sm:items-center sm:p-0">
                    <div class="relative transform overflow-hidden rounded-[2rem] bg-slate-900 border border-white/10 shadow-2xl transition-all sm:my-8 sm:w-full sm:max-w-sm p-8 text-center">
                        <h3 class="text-lg font-bold text-white mb-2">حذف الوحدة؟</h3>
                        <p class="text-slate-400 text-sm mb-6">هل أنت متأكد من حذف "{{ $module->ModuleName }}"؟</p>
                        <form action="{{ url('/system-module/delete/' . $module->ModuleID) }}" method="POST" class="flex justify-center gap-3">
                            @csrf @method('DELETE')
                            <button type="button" onclick="closeModal('deleteModuleModal_{{ $module->ModuleID }}')" class="px-4 py-2 rounded-xl text-slate-300 hover:bg-white/5">إلغاء</button>
                            <button type="submit" class="px-5 py-2 rounded-xl bg-red-600 hover:bg-red-500 text-white font-bold">حذف</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    @endforeach

    @foreach($pageEntities as $entity)
        {{-- Entity Actions Modal (Big One) --}}
        <div id="entityActionsModal_{{ $entity->EntityID }}" class="relative z-[100000] hidden" role="dialog" aria-modal="true">
            <div class="fixed inset-0 bg-gray-900/90 backdrop-blur-md transition-opacity" onclick="closeModal('entityActionsModal_{{ $entity->EntityID }}')"></div>
            <div class="fixed inset-0 z-10 w-screen overflow-y-auto">
                <div class="flex min-h-full items-end justify-center p-4 text-center sm:items-center sm:p-0">
                    <div class="relative transform overflow-hidden rounded-[2rem] bg-slate-900 border border-white/10 text-left shadow-2xl transition-all sm:my-8 sm:w-full sm:max-w-lg p-8">
                        <div class="absolute top-0 w-full h-1 bg-gradient-to-r from-green-500 to-teal-500"></div>
                        <div class="flex justify-between items-center mb-6">
                            <h3 class="text-xl font-bold text-white flex items-center gap-2">
                                <i class="fa-solid fa-bolt text-green-500"></i> إجراءات: <span class="text-green-400">{{ $entity->EntityName }}</span>
                            </h3>
                            <button onclick="closeModal('entityActionsModal_{{ $entity->EntityID }}')" class="text-slate-400 hover:text-white"><i class="fa-solid fa-xmark"></i></button>
                        </div>
                        
                        <form action="{{ url('/system-module/entity/actions/' . $entity->EntityID) }}" method="POST">
                            @csrf
                            <div class="grid grid-cols-2 gap-3 mb-8 max-h-[50vh] overflow-y-auto custom-scrollbar pr-2">
                                @foreach($pageActions as $action)
                                    <label class="group relative flex items-center gap-3 cursor-pointer bg-slate-950 px-4 py-3 rounded-xl border border-white/10 hover:border-green-500/50 transition select-none">
                                        <input type="checkbox" name="actions[]" value="{{ $action->ActionID }}" 
                                            {{ $entity->actions->contains('ActionID', $action->ActionID) ? 'checked' : '' }}
                                            class="peer sr-only">
                                        
                                        <div class="w-5 h-5 border-2 border-slate-600 rounded flex items-center justify-center peer-checked:bg-green-500 peer-checked:border-green-500 transition-all">
                                            <i class="fa-solid fa-check text-slate-900 text-xs opacity-0 peer-checked:opacity-100"></i>
                                        </div>
                                        <span class="text-slate-300 text-sm font-medium group-hover:text-white transition">{{ $action->ActionName }}</span>
                                    </label>
                                @endforeach
                            </div>

                            <div class="flex justify-end gap-3 pt-4 border-t border-white/10">
                                <button type="button" onclick="closeModal('entityActionsModal_{{ $entity->EntityID }}')" class="px-5 py-2.5 rounded-xl text-slate-300 hover:bg-white/5 font-bold">إلغاء</button>
                                <button type="submit" class="px-6 py-2.5 rounded-xl bg-green-500 hover:bg-green-600 text-slate-900 font-bold shadow-lg">حفظ التغييرات</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <div id="editEntityModal_{{ $entity->EntityID }}" class="relative z-[100000] hidden" role="dialog" aria-modal="true">
            <div class="fixed inset-0 bg-gray-900/90 backdrop-blur-md transition-opacity" onclick="closeModal('editEntityModal_{{ $entity->EntityID }}')"></div>
            <div class="fixed inset-0 z-10 w-screen overflow-y-auto">
                <div class="flex min-h-full items-end justify-center p-4 text-center sm:items-center sm:p-0">
                    <div class="relative transform overflow-hidden rounded-[2rem] bg-slate-900 border border-white/10 text-left shadow-2xl transition-all sm:my-8 sm:w-full sm:max-w-sm p-8">
                        <h3 class="text-lg font-bold text-white mb-6">تعديل الكيان</h3>
                        <form action="{{ url('/system-module/entity/edit/' . $entity->EntityID) }}" method="POST">
                            @csrf
                            <input type="text" name="name" value="{{ $entity->EntityName }}" class="w-full bg-slate-950/50 border border-slate-700 rounded-xl px-4 py-3 text-white focus:border-yellow-500 transition mb-4" required>
                            <select name="module_id" class="w-full bg-slate-950/50 border border-slate-700 rounded-xl px-4 py-3 text-white focus:border-yellow-500 transition mb-6">
                                @foreach($pageModules as $module)
                                    <option value="{{ $module->ModuleID }}" {{ $module->ModuleID == $entity->ModuleID ? 'selected' : '' }}>{{ $module->ModuleName }}</option>
                                @endforeach
                            </select>
                            <div class="flex justify-end gap-3">
                                <button type="button" onclick="closeModal('editEntityModal_{{ $entity->EntityID }}')" class="px-4 py-2 rounded-xl text-slate-300 hover:bg-white/5">إلغاء</button>
                                <button type="submit" class="px-5 py-2 rounded-xl bg-yellow-500 hover:bg-yellow-600 text-slate-900 font-bold">حفظ</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <div id="deleteEntityModal_{{ $entity->EntityID }}" class="relative z-[100000] hidden" role="dialog" aria-modal="true">
            <div class="fixed inset-0 bg-gray-900/90 backdrop-blur-md transition-opacity" onclick="closeModal('deleteEntityModal_{{ $entity->EntityID }}')"></div>
            <div class="fixed inset-0 z-10 w-screen overflow-y-auto">
                <div class="flex min-h-full items-end justify-center p-4 text-center sm:items-center sm:p-0">
                    <div class="relative transform overflow-hidden rounded-[2rem] bg-slate-900 border border-white/10 shadow-2xl transition-all sm:my-8 sm:w-full sm:max-w-sm p-8 text-center">
                        <h3 class="text-lg font-bold text-white mb-2">حذف الكيان؟</h3>
                        <p class="text-slate-400 text-sm mb-6">هل أنت متأكد من حذف "{{ $entity->EntityName }}"؟</p>
                        <form action="{{ url('/system-module/entity/delete/' . $entity->EntityID) }}" method="POST" class="flex justify-center gap-3">
                            @csrf @method('DELETE')
                            <button type="button" onclick="closeModal('deleteEntityModal_{{ $entity->EntityID }}')" class="px-4 py-2 rounded-xl text-slate-300 hover:bg-white/5">إلغاء</button>
                            <button type="submit" class="px-5 py-2 rounded-xl bg-red-600 hover:bg-red-500 text-white font-bold">حذف</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    @endforeach

    @foreach($pageActions as $action)
        <div id="editActionModal_{{ $action->ActionID }}" class="relative z-[100000] hidden" role="dialog" aria-modal="true">
            <div class="fixed inset-0 bg-gray-900/90 backdrop-blur-md transition-opacity" onclick="closeModal('editActionModal_{{ $action->ActionID }}')"></div>
            <div class="fixed inset-0 z-10 w-screen overflow-y-auto">
                <div class="flex min-h-full items-end justify-center p-4 text-center sm:items-center sm:p-0">
                    <div class="relative transform overflow-hidden rounded-[2rem] bg-slate-900 border border-white/10 text-left shadow-2xl transition-all sm:my-8 sm:w-full sm:max-w-sm p-8">
                        <h3 class="text-lg font-bold text-white mb-6">تعديل الإجراء</h3>
                        <form action="{{ url('/system-module/action/edit/' . $action->ActionID) }}" method="POST">
                            @csrf
                            <input type="text" name="name" value="{{ $action->ActionName }}" class="w-full bg-slate-950/50 border border-slate-700 rounded-xl px-4 py-3 text-white focus:border-yellow-500 transition mb-6" required>
                            <div class="flex justify-end gap-3">
                                <button type="button" onclick="closeModal('editActionModal_{{ $action->ActionID }}')" class="px-4 py-2 rounded-xl text-slate-300 hover:bg-white/5">إلغاء</button>
                                <button type="submit" class="px-5 py-2 rounded-xl bg-yellow-500 hover:bg-yellow-600 text-slate-900 font-bold">حفظ</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <div id="deleteActionModal_{{ $action->ActionID }}" class="relative z-[100000] hidden" role="dialog" aria-modal="true">
            <div class="fixed inset-0 bg-gray-900/90 backdrop-blur-md transition-opacity" onclick="closeModal('deleteActionModal_{{ $action->ActionID }}')"></div>
            <div class="fixed inset-0 z-10 w-screen overflow-y-auto">
                <div class="flex min-h-full items-end justify-center p-4 text-center sm:items-center sm:p-0">
                    <div class="relative transform overflow-hidden rounded-[2rem] bg-slate-900 border border-white/10 shadow-2xl transition-all sm:my-8 sm:w-full sm:max-w-sm p-8 text-center">
                        <h3 class="text-lg font-bold text-white mb-2">حذف الإجراء؟</h3>
                        <p class="text-slate-400 text-sm mb-6">هل أنت متأكد من حذف "{{ $action->ActionName }}"؟</p>
                        <form action="{{ url('/system-module/action/delete/' . $action->ActionID) }}" method="POST" class="flex justify-center gap-3">
                            @csrf @method('DELETE')
                            <button type="button" onclick="closeModal('deleteActionModal_{{ $action->ActionID }}')" class="px-4 py-2 rounded-xl text-slate-300 hover:bg-white/5">إلغاء</button>
                            <button type="submit" class="px-5 py-2 rounded-xl bg-red-600 hover:bg-red-500 text-white font-bold">حذف</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    @endforeach

    {{-- ================= JAVASCRIPT SECTION ================= --}}
    <script>
        // دالة الفتح: تظهر المودال وتقفل سكرول الصفحة
        function openModal(modalId) {
            const modal = document.getElementById(modalId);
            if (modal) {
                modal.classList.remove('hidden');
                document.body.style.overflow = 'hidden'; // Stop background scrolling
            }
        }

        // دالة الإغلاق: تخفي المودال وترجع سكرول الصفحة
        function closeModal(modalId) {
            const modal = document.getElementById(modalId);
            if (modal) {
                modal.classList.add('hidden');
                document.body.style.overflow = ''; // Restore background scrolling
            }
        }

        // إغلاق المودال عند الضغط على زر Esc
        document.addEventListener('keydown', function(event) {
            if (event.key === "Escape") {
                const openModals = document.querySelectorAll('[role="dialog"]:not(.hidden)');
                openModals.forEach(modal => {
                    closeModal(modal.id);
                });
            }
        });
    </script>

@endsection