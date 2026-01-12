@extends('components.layout')

@section('title', 'الجلسات النشطة')

@section('content')

    <div class="flex flex-col md:flex-row justify-between items-center mb-8 fade-in">
        <div>
            <h1 class="text-3xl font-black text-white mb-2">الجلسات النشطة 🟢</h1>
            <p class="text-slate-400">مراقبة المستخدمين المتصلين بالنظام حالياً.</p>
        </div>
        
        <form method="GET" action="{{ route('sessions.index') }}" class="mt-4 md:mt-0 relative group w-full md:w-auto">
            <input type="text" name="search" value="{{ request('search') }}" placeholder="بحث عن مستخدم..." 
                class="w-full md:w-72 bg-slate-900/50 border border-white/10 text-white rounded-xl pl-4 pr-10 py-3 focus:outline-none focus:border-blue-500 transition">
            <button type="submit" class="absolute left-3 top-1/2 -translate-y-1/2 text-slate-500 hover:text-blue-500 transition">
                <i class="fa-solid fa-search"></i>
            </button>
        </form>
    </div>

    <div class="bg-slate-900/60 backdrop-blur-xl border border-white/10 rounded-[2rem] overflow-hidden shadow-2xl fade-in" style="animation-delay: 0.1s;">
        <div class="overflow-x-auto">
            <table class="w-full text-right">
                <thead class="bg-white/5 text-blue-400 uppercase tracking-wider text-xs font-bold border-b border-white/5">
                    <tr>
                        <th class="px-6 py-5">المستخدم</th>
                        <th class="px-6 py-5">IP Address</th>
                        <th class="px-6 py-5">الجهاز / المتصفح</th>
                        <th class="px-6 py-5">آخر نشاط</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-white/5 text-slate-300 text-sm">
                    @foreach($sessions as $session)
                        <tr class="hover:bg-white/5 transition-colors">
                            <td class="px-6 py-4">
                                <div class="flex items-center gap-3">
                                    <div class="w-8 h-8 rounded-full bg-green-500/10 text-green-400 flex items-center justify-center text-xs border border-green-500/20">
                                        <i class="fa-solid fa-circle"></i>
                                    </div>
                                    <span class="font-bold text-white">{{ $session->name ?? 'زائر غير مسجل' }}</span>
                                </div>
                            </td>
                            <td class="px-6 py-4 font-mono text-xs text-blue-300 bg-blue-900/10 px-2 py-1 rounded w-fit">
                                {{ $session->ip_address }}
                            </td>
                            <td class="px-6 py-4 text-xs max-w-xs truncate" title="{{ $session->user_agent }}">
                                {{ Str::limit($session->user_agent, 50) }}
                            </td>
                            <td class="px-6 py-4 text-slate-400">
                                <i class="fa-regular fa-clock ml-1"></i>
                                {{ \Carbon\Carbon::createFromTimestamp($session->last_activity)->diffForHumans() }}
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        
        <div class="p-6 border-t border-white/5 flex justify-between items-center text-xs text-slate-500">
            <div>عرض {{ $showing }} من أصل {{ $total }}</div>
            <div>{{ $sessions->links('pagination::tailwind') }}</div> </div>
    </div>

@endsection