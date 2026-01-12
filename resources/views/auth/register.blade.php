@extends('components.layout')

@section('title', 'إنشاء حساب جديد - نَسَق')

@section('content')
    {{-- خلفية متحركة مع تأثيرات جمالية --}}
    <div class="fixed inset-0 z-0 pointer-events-none overflow-hidden">
        <div class="absolute inset-0 bg-[url('https://images.unsplash.com/photo-1519167758481-83f550bb49b3?q=80&w=2098&auto=format&fit=crop')] bg-cover bg-center opacity-95 mix-blend-overlay"></div>
        <div class="absolute inset-0 bg-gradient-to-br from-slate-950 via-indigo-950/90 to-slate-900"></div>
        <div class="absolute top-0 -left-4 w-72 h-72 bg-purple-500 rounded-full mix-blend-multiply filter blur-3xl opacity-20 animate-blob"></div>
        <div class="absolute bottom-0 -right-4 w-72 h-72 bg-blue-500 rounded-full mix-blend-multiply filter blur-3xl opacity-20 animate-blob animation-delay-2000"></div>
    </div>

    {{-- نموذج التسجيل في المنتصف --}}
    <div class="relative z-10 min-h-screen flex items-center justify-center px-4 py-12">
        <div class="relative w-full max-w-2xl fade-in-up">
            <div class="absolute -inset-1 bg-gradient-to-r from-blue-600 to-indigo-600 rounded-[2.5rem] blur opacity-30"></div>

            <div class="relative bg-slate-900/80 backdrop-blur-xl border border-white/10 rounded-[2.5rem] p-6 md:p-10 shadow-2xl">
                {{-- اللوغو والترحيب --}}
                <div class="text-center mb-8">
                    <div class="inline-flex items-center justify-center w-16 h-16 bg-gradient-to-r from-blue-600 to-indigo-600 hover:from-blue-500 hover:to-indigo-500 rounded-2xl mb-3 shadow-lg group hover:scale-105 transition">
                        <img src="{{ asset('images/logo-white.png') }}" alt="نسق" class="w-10 h-10 object-contain drop-shadow-md">
                    </div>
                    <h1 class="text-2xl font-black text-white tracking-tight">انضم لعائلة نَسَق</h1>
                    <p class="text-slate-400 text-sm font-medium mt-1">أنشئ حسابك وابدأ بتنظيم مناسبتك اليوم</p>
                </div>

                {{-- نموذج التسجيل --}}
                <form method="POST" action="{{ route('register') }}" class="space-y-5">
                    @csrf

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                        {{-- الاسم الكامل (عرض كامل) --}}
                        <div class="space-y-2 md:col-span-2">
                            <label class="block text-blue-400 text-xs font-bold mr-1 uppercase tracking-wider">الاسم الكامل</label>
                            <div class="relative group">
                                <div class="absolute inset-y-0 right-0 pr-4 flex items-center pointer-events-none">
                                    <i class="fas fa-user text-slate-500 group-focus-within:text-blue-500 transition-colors"></i>
                                </div>
                                <input 
                                    type="text" 
                                    name="name" 
                                    required 
                                    value="{{ old('name') }}" 
                                    placeholder="مثلاً: دانيا الخطايبة"
                                    class="w-full pl-4 pr-11 py-3.5 bg-slate-950/50 border border-slate-700 rounded-2xl text-white placeholder:text-slate-600 focus:outline-none focus:border-blue-500 focus:ring-1 focus:ring-blue-500 transition-all"
                                >
                            </div>
                            @error('name')
                                <p class="text-red-400 text-xs font-bold mt-1 mr-1">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- رقم الهاتف --}}
                        <div class="space-y-2">
                            <label class="block text-blue-400 text-xs font-bold mr-1 uppercase tracking-wider">رقم الهاتف</label>
                            <div class="relative group">
                                <div class="absolute inset-y-0 right-0 pr-4 flex items-center pointer-events-none">
                                    <i class="fas fa-phone text-slate-500 group-focus-within:text-blue-500 transition-colors"></i>
                                </div>
                                <input 
                                    type="tel" 
                                    name="MobileNumber" 
                                    required 
                                    value="{{ old('MobileNumber') }}" 
                                    placeholder="07XXXXXXXX"
                                    class="w-full pl-4 pr-11 py-3.5 bg-slate-950/50 border border-slate-700 rounded-2xl text-white placeholder:text-slate-600 focus:outline-none focus:border-blue-500 focus:ring-1 focus:ring-blue-500 transition-all text-right"
                                    style="direction: ltr; text-align: right;"
                                >
                            </div>
                            @error('MobileNumber')
                                <p class="text-red-400 text-xs font-bold mt-1 mr-1">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- البريد الإلكتروني --}}
                        <div class="space-y-2">
                            <label class="block text-blue-400 text-xs font-bold mr-1 uppercase tracking-wider">البريد الإلكتروني</label>
                            <div class="relative group">
                                <div class="absolute inset-y-0 right-0 pr-4 flex items-center pointer-events-none">
                                    <i class="fas fa-envelope text-slate-500 group-focus-within:text-blue-500 transition-colors"></i>
                                </div>
                                <input 
                                    type="email" 
                                    name="email" 
                                    required 
                                    value="{{ old('email') }}" 
                                    placeholder="name@example.com"
                                    class="w-full pl-4 pr-11 py-3.5 bg-slate-950/50 border border-slate-700 rounded-2xl text-white placeholder:text-slate-600 focus:outline-none focus:border-blue-500 focus:ring-1 focus:ring-blue-500 transition-all"
                                >
                            </div>
                            @error('email')
                                <p class="text-red-400 text-xs font-bold mt-1 mr-1">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- كلمة المرور --}}
                        <div class="space-y-2">
                            <label class="block text-blue-400 text-xs font-bold mr-1 uppercase tracking-wider">كلمة المرور</label>
                            <div class="relative group">
                                <div class="absolute inset-y-0 right-0 pr-4 flex items-center pointer-events-none">
                                    <i class="fas fa-lock text-slate-500 group-focus-within:text-blue-500 transition-colors"></i>
                                </div>
                                <input 
                                    type="password" 
                                    name="password" 
                                    required 
                                    placeholder="••••••••"
                                    class="w-full pl-4 pr-11 py-3.5 bg-slate-950/50 border border-slate-700 rounded-2xl text-white placeholder:text-slate-600 focus:outline-none focus:border-blue-500 focus:ring-1 focus:ring-blue-500 transition-all"
                                >
                            </div>
                            @error('password')
                                <p class="text-red-400 text-xs font-bold mt-1 mr-1">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- تأكيد كلمة المرور --}}
                        <div class="space-y-2">
                            <label class="block text-blue-400 text-xs font-bold mr-1 uppercase tracking-wider">تأكيد كلمة المرور</label>
                            <div class="relative group">
                                <div class="absolute inset-y-0 right-0 pr-4 flex items-center pointer-events-none">
                                    <i class="fas fa-check-double text-slate-500 group-focus-within:text-blue-500 transition-colors"></i>
                                </div>
                                <input 
                                    type="password" 
                                    name="password_confirmation" 
                                    required 
                                    placeholder="••••••••"
                                    class="w-full pl-4 pr-11 py-3.5 bg-slate-950/50 border border-slate-700 rounded-2xl text-white placeholder:text-slate-600 focus:outline-none focus:border-blue-500 focus:ring-1 focus:ring-blue-500 transition-all"
                                >
                            </div>
                        </div>
                    </div>

                    {{-- زر إنشاء الحساب --}}
                    <button 
                        type="submit"
                        class="w-full bg-gradient-to-r from-blue-600 to-indigo-600 hover:from-blue-500 hover:to-indigo-500 text-white py-4 rounded-2xl font-bold text-lg shadow-lg shadow-blue-900/40 hover:shadow-blue-600/40 hover:-translate-y-1 transition-all duration-300 flex items-center justify-center gap-2 group mt-6"
                    >
                        <span>إنشاء الحساب</span>
                        <i class="fas fa-user-plus text-sm mt-1 group-hover:-translate-x-1 transition-transform"></i>
                    </button>

                    {{-- رابط تسجيل الدخول --}}
                    <div class="text-center pt-6 border-t border-white/5 mt-6">
                        <p class="text-slate-400 text-sm">
                            لديك حساب بالفعل؟ 
                            <a href="{{ route('login') }}" class="text-blue-400 font-bold hover:text-white hover:underline transition">
                                تسجيل الدخول
                            </a>
                        </p>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection