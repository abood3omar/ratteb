@props(['formName', 'searchPlaceholder' => 'بحث...', 'routeName'])

<div class="lg:col-span-2 h-full">
    <div class="bg-slate-900/60 backdrop-blur-xl border border-white/10 rounded-[2rem] p-6 shadow-xl h-full flex flex-col">
        <div class="flex flex-col md:flex-row justify-between items-center mb-6 gap-4">
            <h2 class="text-xl font-black text-white flex items-center gap-2">
                <i class="fa-solid fa-list text-purple-500"></i> قائمة {{ $formName }}
            </h2>

            <form method="GET" action="{{ route('databank.'.$routeName.'.index') }}" class="relative w-full md:w-64 group">
                <input type="text" name="search" value="{{ request('search') }}" placeholder="{{ $searchPlaceholder }}" 
                    class="w-full bg-slate-950/50 border border-white/10 text-white text-sm rounded-xl pl-4 pr-10 py-2.5 focus:border-purple-500 focus:ring-1 focus:ring-purple-500 transition shadow-inner">
                <button type="submit" class="absolute left-3 top-1/2 -translate-y-1/2 text-slate-500 group-focus-within:text-purple-500 transition">
                    <i class="fa-solid fa-search"></i>
                </button>
            </form>
        </div>

        <div class="flex-grow">
            {{ $slot }}
        </div>
    </div>
</div>