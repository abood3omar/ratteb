@props(['routeName', 'formName'])

<div class="bg-slate-900/50 border border-white/5 rounded-2xl p-6 mb-8">
    <div class="flex items-center gap-2 mb-6 border-b border-white/5 pb-4">
        <div class="w-8 h-8 rounded-lg bg-blue-500/10 flex items-center justify-center text-blue-400">
            <i class="fa-solid fa-plus"></i>
        </div>
        <h3 class="text-lg font-bold text-white">إضافة {{ $formName }} جديد</h3>
    </div>

    <form action="{{ route('databank.'.$routeName.'.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        
        <div class="grid grid-cols-1 gap-6">
            {{ $slot }}
        </div>

        <div class="mt-8 flex justify-end border-t border-white/5 pt-6">
            <button type="submit" class="bg-blue-600 hover:bg-blue-500 text-white font-bold py-3 px-8 rounded-xl shadow-lg shadow-blue-900/20 transition-all hover:-translate-y-1 active:scale-95 flex items-center gap-2">
                <i class="fa-solid fa-check"></i> حفظ البيانات
            </button>
        </div>
    </form>
</div>