@extends('components.layout')

@section('title', 'خطط لمناسبتك')

@section('content')
    <div class="container mx-auto px-4 py-12">
        {{-- العنوان الرئيسي --}}
        <div class="text-center mb-16 fade-in">
            <h1 class="text-4xl md:text-5xl font-black text-white mb-4">
                ما هي مناسبتك القادمة؟ 🎉
            </h1>
            <p class="text-slate-400 text-lg max-w-2xl mx-auto">
                اختر نوع المناسبة، وسنقوم بتجهيز كل ما تحتاجه في مكان واحد. 
                <br>
                <span class="text-blue-500 font-bold">بدون تشتت، وبأفضل الأسعار.</span>
            </p>
        </div>

        {{-- شبكة أنواع المناسبات --}}
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            @foreach($occasions as $occasion)
                <a href="{{ route('front.planner.show', $occasion->slug) }}" 
                   class="group relative block h-[400px] rounded-3xl overflow-hidden shadow-2xl transition-transform hover:-translate-y-2">

                    <div class="absolute inset-0">
                        @if($occasion->image)
                            <img src="{{ asset('storage/' . $occasion->image) }}" 
                                 class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-110">
                        @else
                            <div class="w-full h-full bg-gradient-to-br from-slate-800 to-slate-900"></div>
                        @endif

                        <div class="absolute inset-0 bg-gradient-to-t from-slate-950 via-slate-950/60 to-transparent opacity-90 group-hover:opacity-80 transition-opacity"></div>
                    </div>

                    <div class="absolute bottom-0 left-0 w-full p-8 translate-y-4 group-hover:translate-y-0 transition-transform duration-300">
                        <div class="flex items-center gap-4 mb-3">
                            <div class="w-12 h-12 rounded-full bg-blue-600 text-white flex items-center justify-center text-xl shadow-lg shadow-blue-600/30">
                                @if(Str::contains($occasion->slug, 'wedding')) 💍
                                @elseif(Str::contains($occasion->slug, 'grad')) 🎓
                                @elseif(Str::contains($occasion->slug, 'baby')) 👶
                                @else ✨
                                @endif
                            </div>
                            <h2 class="text-3xl font-black text-white">{{ $occasion->name_ar }}</h2>
                        </div>

                        <p class="text-slate-300 text-sm mb-6 line-clamp-2 opacity-0 group-hover:opacity-100 transition-opacity duration-300 delay-100">
                            {{ $occasion->description ?? 'خطط لهذه المناسبة بالكامل بخطوات بسيطة وسهلة.' }}
                        </p>

                        <div class="flex items-center gap-4 text-xs text-slate-400 border-t border-white/10 pt-4 opacity-0 group-hover:opacity-100 transition-opacity duration-300 delay-200">
                            <span class="flex items-center gap-1">
                                <i class="fa-solid fa-layer-group text-blue-400"></i>
                                يشمل {{ $occasion->categories_count }} خدمات أساسية
                            </span>
                            <span class="flex items-center gap-1">
                                <i class="fa-solid fa-wand-magic-sparkles text-purple-400"></i>
                                تخطيط ذكي
                            </span>
                        </div>

                        <div class="mt-4 flex items-center gap-2 text-white font-bold group-hover:text-blue-400 transition">
                            <span>ابدأ التخطيط الآن</span>
                            <i class="fa-solid fa-arrow-left group-hover:-translate-x-2 transition-transform"></i>
                        </div>
                    </div>
                </a>
            @endforeach
        </div>
    </div>
@endsection