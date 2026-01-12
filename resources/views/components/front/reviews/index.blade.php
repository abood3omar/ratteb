@extends('components.layout')

@section('title', 'آراء العملاء')

@section('content')

<div class="container mx-auto px-4 py-12 fade-in">

    {{-- رأس الصفحة --}}
    <div class="text-center mb-16 relative">
        <div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-64 h-64 bg-blue-600/20 rounded-full blur-[80px] -z-10 pointer-events-none"></div>
        
        <h1 class="text-4xl md:text-5xl font-black text-white mb-6">جدار المحبة 💬</h1>
        <p class="text-slate-400 text-lg max-w-2xl mx-auto mb-8">
            شفافية مطلقة.. اقرأ تجارب عملائنا الحقيقية وكيف ساعدهم نَسَق في تنظيم مناسباتهم.
        </p>

        {{-- إحصائيات سريعة --}}
        <div class="inline-flex items-center gap-8 bg-slate-900/80 border border-white/10 px-8 py-4 rounded-2xl backdrop-blur-md">
            <div class="text-center">
                <span class="block text-2xl font-black text-white">{{ $totalReviews }}</span>
                <span class="text-xs text-slate-500 uppercase tracking-wider">تقييم كلي</span>
            </div>
            <div class="w-px h-10 bg-white/10"></div>
            <div class="text-center">
                <span class="block text-2xl font-black text-yellow-400 flex items-center gap-1">
                    {{ number_format($averageRating, 1) }} <i class="fa-solid fa-star text-sm"></i>
                </span>
                <span class="text-xs text-slate-500 uppercase tracking-wider">متوسط التقييم</span>
            </div>
        </div>
    </div>

    {{-- شبكة التقييمات --}}
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mb-12">
        @forelse($reviews as $review)
            <div class="bg-slate-900 border border-slate-800 rounded-3xl p-8 hover:border-blue-500/30 hover:-translate-y-1 transition-all duration-300 group flex flex-col h-full">
                
                {{-- النجوم والتاريخ --}}
                <div class="flex justify-between items-start mb-6">
                    <div class="flex gap-1 text-xs">
                        @for ($i = 1; $i <= 5; $i++)
                            <i class="fa-solid fa-star {{ $i <= $review->rating ? 'text-yellow-400' : 'text-slate-800' }}"></i>
                        @endfor
                    </div>
                    <span class="text-[10px] text-slate-600 font-mono">{{ $review->created_at->diffForHumans() }}</span>
                </div>

                {{-- نص التقييم --}}
                <div class="relative flex-grow">
                    <i class="fa-solid fa-quote-right text-4xl text-white/5 absolute -top-2 -right-2"></i>
                    <p class="text-slate-300 text-sm leading-relaxed relative z-10">
                        "{{ $review->comment }}"
                    </p>
                </div>

                {{-- معلومات المستخدم --}}
                <div class="flex items-center gap-4 border-t border-white/5 pt-6 mt-6">
                    <div class="w-10 h-10 rounded-full bg-gradient-to-br from-blue-600 to-purple-600 flex items-center justify-center font-bold text-white shadow-lg">
                        {{ mb_substr($review->user->name, 0, 1) }}
                    </div>
                    <div>
                        <h4 class="text-white font-bold text-sm">{{ $review->user->name }}</h4>
                        @if($review->occasion_type)
                            <span class="text-xs text-blue-400 bg-blue-500/10 px-2 py-0.5 rounded-md border border-blue-500/10">
                                {{ $review->occasion_type }}
                            </span>
                        @endif
                    </div>
                </div>
            </div>
        @empty
            <div class="col-span-full text-center py-20">
                <div class="w-20 h-20 bg-slate-900 rounded-full flex items-center justify-center mx-auto mb-4 text-slate-600 text-3xl">
                    <i class="fa-regular fa-comments"></i>
                </div>
                <p class="text-slate-500">لا يوجد تقييمات حتى الآن. كن أول من يقيمنا!</p>
            </div>
        @endforelse
    </div>

    {{-- الترقيم (Pagination) --}}
    <div class="flex justify-center">
        {{ $reviews->links('pagination::tailwind') }} 
    </div>

</div>

@endsection