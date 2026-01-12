@props(['formName'])
<div class="grid grid-cols-1 lg:grid-cols-3 gap-8 fade-in">
    <div class="lg:col-span-1 h-fit bg-slate-900/60 backdrop-blur-xl border border-white/10 rounded-[2rem] p-6 shadow-xl sticky top-24">
        <h2 class="text-xl font-black text-white mb-6 flex items-center gap-2 border-b border-white/5 pb-4">
            <i class="fa-solid fa-plus-circle text-blue-500"></i>
            {{ $formName }} جديد
        </h2>
        {{ $slot }}
    </div>
</div>