@props(['id', 'entityName', 'element', 'routeName'])

<div x-data="{ open: false }" class="inline-block">
    <button @click="open = true" type="button" class="w-8 h-8 rounded-lg bg-blue-500/10 text-blue-400 hover:bg-blue-500 hover:text-white transition flex items-center justify-center">
        <i class="fa-regular fa-pen-to-square"></i>
    </button>

    <template x-teleport="body">
        <div x-show="open" 
             x-transition.opacity
             style="display: none;"
             class="fixed inset-0 z-[9999] flex items-center justify-center bg-slate-950/80 backdrop-blur-sm p-4"> <div @click.away="open = false" 
                 class="bg-slate-900 border border-white/10 rounded-2xl w-full max-w-lg shadow-2xl overflow-hidden transform transition-all relative">
                
                <div class="px-6 py-4 border-b border-white/5 flex justify-between items-center bg-slate-950/50">
                    <h3 class="text-lg font-bold text-white">
                        تعديل {{ $entityName }}
                    </h3>
                    <button @click="open = false" class="text-slate-400 hover:text-white transition">
                        <i class="fa-solid fa-xmark text-xl"></i>
                    </button>
                </div>

                <form action="{{ route('databank.'.$routeName.'.update', $id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    
                    <div class="p-6 space-y-4 max-h-[70vh] overflow-y-auto custom-scrollbar text-right" dir="rtl">
                        {{ $slot }}
                    </div>

                    <div class="px-6 py-4 bg-slate-950/50 border-t border-white/5 flex justify-end gap-3">
                        <button @click="open = false" type="button" class="px-4 py-2 rounded-xl text-sm font-bold text-slate-400 hover:bg-white/5 transition">
                            إلغاء
                        </button>
                        <button type="submit" class="px-6 py-2 rounded-xl text-sm font-bold bg-blue-600 hover:bg-blue-500 text-white shadow-lg shadow-blue-900/20 transition">
                            حفظ التعديلات
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </template>
</div>