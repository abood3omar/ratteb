@props(['id', 'element', 'routeName', 'entityName'])

<div x-data="{ open: false }" class="inline-block">
    <button @click="open = true" type="button" class="w-8 h-8 rounded-lg bg-red-500/10 text-red-400 hover:bg-red-500 hover:text-white transition flex items-center justify-center">
        <i class="fa-regular fa-trash-can"></i>
    </button>

    <template x-teleport="body">
        <div x-show="open" 
             x-transition.opacity
             style="display: none;"
             class="fixed inset-0 z-[9999] flex items-center justify-center bg-slate-950/90 backdrop-blur-sm p-4">
            
            <div @click.away="open = false" 
                 class="bg-slate-900 border border-red-500/30 rounded-2xl w-full max-w-md shadow-[0_0_50px_rgba(239,68,68,0.1)] overflow-hidden text-center p-8 relative">
                
                <div class="w-16 h-16 bg-red-500/10 rounded-full flex items-center justify-center mx-auto mb-6 text-red-500 text-3xl">
                    <i class="fa-solid fa-triangle-exclamation"></i>
                </div>

                <h3 class="text-xl font-bold text-white mb-2">هل أنت متأكد؟</h3>
                <p class="text-slate-400 text-sm mb-8">
                    أنت على وشك حذف {{ $entityName }}: <br>
                    <span class="text-white font-bold">"{{ $element->name_ar ?? $element->name ?? 'العنصر' }}"</span>. <br>
                    هذا الإجراء لا يمكن التراجع عنه.
                </p>

                <form action="{{ route('databank.'.$routeName.'.destroy', $id) }}" method="POST" class="flex justify-center gap-4">
                    @csrf
                    @method('DELETE')
                    
                    <button @click="open = false" type="button" class="px-6 py-3 rounded-xl text-sm font-bold text-slate-300 bg-white/5 hover:bg-white/10 transition">
                        إلغاء الأمر
                    </button>
                    
                    <button type="submit" class="px-6 py-3 rounded-xl text-sm font-bold bg-red-600 hover:bg-red-500 text-white shadow-lg shadow-red-900/30 transition flex items-center gap-2">
                        <i class="fa-solid fa-trash"></i> نعم، حذف
                    </button>
                </form>
            </div>
        </div>
    </template>
</div>