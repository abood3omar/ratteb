<!DOCTYPE html>
<html lang="ar" dir="rtl" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title') - نَسَق</title>
    
    <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        body { font-family: 'Cairo', sans-serif; }
        /* Smooth Fade In */
        .fade-in { animation: fadeIn 0.6s cubic-bezier(0.4, 0, 0.2, 1); }
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(10px); }
            to { opacity: 1; transform: translateY(0); }
        }
        /* Mobile Menu Transitions */
        .mobile-menu {
            transform: translateX(100%);
            transition: transform 0.4s cubic-bezier(0.16, 1, 0.3, 1);
        }
        .mobile-menu.open {
            transform: translateX(0);
        }
        /* Custom Scrollbar */
        ::-webkit-scrollbar { width: 8px; }
        ::-webkit-scrollbar-track { background: #0f172a; }
        ::-webkit-scrollbar-thumb { 
            background: linear-gradient(to bottom, #3b82f6, #4f46e5); 
            border-radius: 4px; 
            border: 2px solid #0f172a;
        }
        /* Animation for Popups */
        @keyframes scaleIn { 
            from { opacity: 0; transform: scale(0.95); } 
            to { opacity: 1; transform: scale(1); } 
        }
        .animate-scale-in { animation: scaleIn 0.2s ease-out forwards; }
        /* Ambient Background Animation */
        @keyframes blob {
            0% { transform: translate(0px, 0px) scale(1); }
            33% { transform: translate(30px, -50px) scale(1.1); }
            66% { transform: translate(-20px, 20px) scale(0.9); }
            100% { transform: translate(0px, 0px) scale(1); }
        }
        .animate-blob { animation: blob 7s infinite; }
        .animation-delay-2000 { animation-delay: 2s; }
        .animation-delay-4000 { animation-delay: 4s; }
    </style>
</head>

<body class="bg-slate-950 min-h-screen flex flex-col relative overflow-x-hidden text-right selection:bg-blue-500 selection:text-white">
    {{-- background --}}
    <div class="fixed inset-0 z-0 pointer-events-none">
        <div class="absolute inset-0 bg-[url('https://images.unsplash.com/photo-1519167758481-83f550bb49b3?q=80&w=2098&auto=format&fit=crop')] bg-cover bg-center opacity-40 mix-blend-overlay"></div>
        <div class="absolute inset-0 bg-gradient-to-br from-slate-950 via-indigo-950/80 to-slate-900"></div>
        <div class="absolute top-0 -left-4 w-72 h-72 bg-purple-500 rounded-full mix-blend-multiply filter blur-3xl opacity-20 animate-blob"></div>
        <div class="absolute top-0 -right-4 w-72 h-72 bg-blue-500 rounded-full mix-blend-multiply filter blur-3xl opacity-20 animate-blob animation-delay-2000"></div>
        <div class="absolute -bottom-8 left-20 w-72 h-72 bg-indigo-500 rounded-full mix-blend-multiply filter blur-3xl opacity-20 animate-blob animation-delay-4000"></div>
    </div>

    {{-- navbar --}}
    <nav class="sticky top-0 z-50 transition-all duration-300 border-b border-white/5 bg-slate-900/60 backdrop-blur-xl shadow-[0_4px_30px_rgba(0,0,0,0.1)]">
        <div class="container mx-auto px-4 md:px-6 py-3 flex justify-between items-center h-[4.5rem]">
            {{-- 1 - زر الموبايل + قائمة المستخدم --}}
            <div class="flex items-center gap-4">
                {{-- Mobile Button --}}
                <button id="mobile-menu-button" class="md:hidden w-11 h-11 flex items-center justify-center text-white bg-white/5 rounded-xl hover:bg-white/10 transition active:scale-95 border border-white/10 backdrop-blur-sm group">
                    <i class="fas fa-bars text-xl group-hover:text-blue-400 transition-colors"></i>
                </button>
                @guest
                    {{-- guest users --}}
                    <div class="hidden md:flex items-center gap-3">
                        <a href="{{ route('login') }}" class="text-slate-300 hover:text-white font-bold transition px-5 py-2 hover:bg-white/5 rounded-xl text-sm">تسجيل الدخول</a>
                        <a href="{{ route('register') }}" class="relative inline-flex group items-center justify-center px-6 py-2.5 font-bold text-white transition-all duration-200 bg-blue-600 rounded-xl hover:bg-blue-500 hover:-translate-y-0.5 shadow-lg shadow-blue-900/30 overflow-hidden">
                            <span class="relative flex items-center gap-2">إنشاء حساب <i class="fa-solid fa-user-plus text-xs"></i></span>
                        </a>
                    </div>
                @else
                    {{-- auth users --}}
                    <div class="relative">
                        {{-- user menu button --}}
                        <button id="user-menu-button" class="flex items-center gap-3 bg-white/5 hover:bg-white/10 border border-white/5 pl-4 pr-1.5 py-1.5 rounded-full transition-all group backdrop-blur-md">
                            <div class="w-9 h-9 rounded-full bg-gradient-to-br from-blue-500 to-indigo-600 flex items-center justify-center text-white font-bold shadow-lg ring-2 ring-white/10 group-hover:ring-blue-500/50 transition-all">
                                {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                            </div>
                            <div class="hidden md:block text-right">
                                <span class="block font-bold text-white text-xs group-hover:text-blue-200 transition">{{ auth()->user()->name }}</span>
                            </div>
                            <div class="w-6 h-6 flex items-center justify-center rounded-full bg-white/5 group-hover:bg-white/10 transition hidden md:flex">
                                <i class="fa-solid fa-chevron-down text-[10px] text-slate-400 group-hover:text-white"></i>
                            </div>
                        </button>

                        {{-- user menu dropdown --}}
                        <div id="user-menu" class="hidden absolute right-0 mt-4 w-64 bg-[#0f172a]/95 backdrop-blur-2xl border border-white/10 rounded-2xl shadow-[0_20px_50px_rgba(0,0,0,0.5)] py-2 text-slate-200 transform origin-top-right transition-all z-50 overflow-hidden ring-1 ring-white/5 animate-scale-in">
                            <div class="px-5 py-4 bg-gradient-to-r from-slate-800/50 to-slate-900/50 border-b border-white/5 mb-2">
                                <p class="text-[10px] text-blue-400 font-bold uppercase tracking-wider mb-1">الحساب النشط</p>
                                <p class="text-sm font-bold text-white truncate">{{ auth()->user()->email }}</p>
                            </div>
                            {{-- account --}}
                            <a href="/account" class="flex items-center px-5 py-3 hover:bg-blue-500/10 hover:text-blue-400 transition-all gap-3 text-sm font-medium group">
                                <span class="w-8 h-8 rounded-lg bg-white/5 flex items-center justify-center group-hover:bg-blue-500/20 transition-colors"><i class="fa-solid fa-user-gear"></i></span>
                                إعدادات الحساب
                            </a>
                             {{-- my bookings --}}
                            <a href="{{ route('components.front.bookings.index') }}" class="flex items-center px-5 py-3 hover:bg-blue-500/10 hover:text-blue-400 transition-all gap-3 text-sm font-medium group">
                                <span class="w-8 h-8 rounded-lg bg-white/5 flex items-center justify-center group-hover:bg-blue-500/20 transition-colors">
                                    <i class="fa-solid fa-receipt"></i>
                                </span> 
                                حجوزاتي    
                            </a>
                            <div class="border-t border-white/5 my-2"></div>
                            {{-- logout --}}
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" class="w-full text-right flex items-center px-5 py-3 text-red-400 hover:bg-red-500/10 hover:text-red-300 transition-all gap-3 text-sm font-bold group">
                                    <span class="w-8 h-8 rounded-lg bg-red-500/10 flex items-center justify-center group-hover:bg-red-500/20 transition-colors"><i class="fa-solid fa-right-from-bracket"></i></span>
                                    تسجيل خروج
                                </button>
                            </form>
                        </div>
                    </div>
                @endguest
@auth
  @if(Auth::user()->hasPermission($entities['security'], $actions['show']))
                <div class="relative group" x-data="{ open: false }">
    <button @click="open = !open" class="relative text-slate-300 hover:text-white transition">
        <i class="fa-solid fa-bell text-xl"></i>
        
        {{-- الدائرة الحمراء (العداد) --}}
        @if(auth()->user()->unreadNotifications->count() > 0)
            <span class="absolute -top-2 -right-2 bg-red-600 text-white text-[10px] font-bold px-1.5 py-0.5 rounded-full animate-pulse">
                {{ auth()->user()->unreadNotifications->count() }}
            </span>
        @endif
    </button>

    {{-- القائمة المنسدلة للإشعارات --}}
    <div x-show="open" @click.away="open = false" 
         class="absolute right-0 mt-2 w-72 bg-slate-900 border border-slate-700 rounded-xl shadow-2xl z-50 overflow-hidden" 
         style="display: none;">
        
        <div class="p-3 border-b border-slate-700 font-bold text-white text-sm">
            الإشعارات
        </div>

        <div class="max-h-64 overflow-y-auto">
            @forelse(auth()->user()->unreadNotifications as $notification)
              <a href="{{ $notification->data['link'] }}{{ str_contains($notification->data['link'], '?') ? '&' : '?' }}notify_id={{ $notification->id }}" class="block p-3 hover:bg-slate-800 transition border-b border-slate-800 last:border-0">
                    <p class="text-sm text-white mb-1">{{ $notification->data['message'] }}</p>
                    <span class="text-[10px] text-slate-400">{{ $notification->created_at->diffForHumans() }}</span>
                </a>
            @empty
                <div class="p-4 text-center text-slate-500 text-xs">لا توجد إشعارات جديدة</div>
            @endforelse
        </div>
        
        @if(auth()->user()->unreadNotifications->count() > 0)
            <a href="{{ route('notifications.readAll') }}" class="block p-2 text-center text-xs text-blue-400 hover:bg-slate-800 font-bold">
                تحديد الكل كمقروء
            </a>
        @endif
    </div>
  
</div>
@endif
@endauth
            </div>

            {{-- 2 - القائمة الرئيسية في الديسكتوب --}}
            <div class="hidden md:flex items-center gap-1 bg-white/5 p-1.5 rounded-2xl border border-white/10 absolute left-0 right-0 mx-auto w-fit shadow-2xl backdrop-blur-md">
                {{-- home --}}
                <a href="{{ route('home') }}" class="px-5 py-2.5 rounded-xl text-sm font-bold transition-all duration-300 relative overflow-hidden {{ Request::routeIs('home') ? 'text-white bg-blue-600 shadow-lg shadow-blue-900/20' : 'text-slate-400 hover:text-white hover:bg-white/5' }}">
                    <span class="relative z-10">الرئيسية</span>
                    @if(Request::routeIs('home')) 
                        <div class="absolute inset-0 bg-gradient-to-r from-blue-600 to-indigo-600"></div> 
                    @endif
                </a>
                  {{-- planner occasions --}}
                <a href="{{ route('front.planner.index') }}" class="px-5 py-2.5 rounded-xl text-sm font-bold transition-all duration-300 relative overflow-hidden {{ Request::routeIs('front.planner.index') ? 'text-white bg-blue-600 shadow-lg shadow-blue-900/20' : 'text-slate-400 hover:text-white hover:bg-white/5' }}">
                          <i class="fa-solid fa-wand-magic-sparkles {{ Request::routeIs('front.planner.index') ? 'text-yellow-300' : 'text-blue-400 group-hover:text-blue-300' }}"></i> 
                        خطط مناسبتك
                    @if(Request::routeIs('front.planner.index')) 
                        <div class="absolute inset-0 bg-gradient-to-r from-blue-600 to-indigo-600"></div> 
                    @endif
                </a>

                {{-- browse services --}}
                <a href="{{ route('front.services.index') }}" class="px-5 py-2.5 rounded-xl text-sm font-bold transition-all duration-300 relative overflow-hidden {{ Request::routeIs('front.services.index') ? 'text-white bg-blue-600 shadow-lg shadow-blue-900/20' : 'text-slate-400 hover:text-white hover:bg-white/5' }}">
                    <i class="fa-solid fa-store {{ Request::routeIs('front.services.index') ? 'text-yellow-300' : 'text-blue-400 group-hover:text-blue-300' }}"></i> 
                    <span class="relative z-10">تصفح الخدمات</span>
                </a>
                {{-- pakages --}}
                <a href="{{ route('front.packages.index') }}" class="flex items-center gap-2 px-4 py-2 rounded-xl transition-all {{ request()->routeIs('front.packages.index') ? 'bg-blue-600 text-white shadow-lg shadow-blue-900/20' : 'text-slate-400 hover:text-white hover:bg-white/5' }}">
                       <i class="fa-solid fa-gift {{ Request::routeIs('front.packages.index') ? 'text-yellow-300' : 'text-blue-400 group-hover:text-blue-300' }}"></i> 
                    <span class="font-bold">البكجات المميزة</span>
                </a>
               @auth     
                {{-- DataBank Menu --}}  
                @if(Auth::user()->hasPermission($entities['databank'], $actions['show']))
                 <div class="relative ml-2">
                    <button id="databank-menu-btn" onclick="toggleDataBankMenu(event)" class="px-5 py-2.5 rounded-xl text-sm font-bold text-cyan-400 hover:text-cyan-300 hover:bg-cyan-400/10 transition-all flex items-center gap-2 border border-transparent hover:border-cyan-400/20">
                        <i class="fa-solid fa-database"></i> بنك المعلومات
                        <i class="fa-solid fa-chevron-down text-[10px] transition-transform duration-200" id="databank-menu-arrow"></i>
                    </button>
                    {{-- DataBank DropDown --}}
                    <div id="databank-menu" class="hidden absolute top-full right-0 mt-4 w-56 bg-[#0f172a]/95 backdrop-blur-xl border border-white/10 rounded-2xl shadow-[0_10px_40px_rgba(0,0,0,0.5)] py-2 z-50 ring-1 ring-white/5 origin-top-right animate-scale-in">
                        <div class="absolute -top-2 right-6 w-4 h-4 bg-[#0f172a] border-t border-l border-white/10 transform rotate-45"></div>
                        <div class="relative z-10">
                            {{-- categoris --}}
                            <a href="{{ route('databank.categories.index') }}" class="block px-4 py-3 text-sm text-slate-300 hover:text-white hover:bg-white/5 transition font-medium border-b border-white/5">
                                <div class="flex items-center gap-3">
                                    <span class="w-8 h-8 rounded-lg bg-blue-500/10 text-blue-400 flex items-center justify-center"><i class="fa-solid fa-layer-group"></i></span>
                                    التصنيفات
                                </div>
                            </a>
                            {{-- providers --}}
                            <a href="{{ route('databank.providers.index') }}" class="block px-4 py-3 text-sm text-slate-300 hover:text-white hover:bg-white/5 transition font-medium border-b border-white/5">
                                <div class="flex items-center gap-3">
                                    <span class="w-8 h-8 rounded-lg bg-purple-500/10 text-purple-400 flex items-center justify-center"><i class="fa-solid fa-store"></i></span>
                                    المزودين
                                </div>
                            </a>
                            {{-- services --}}
                            <a href="{{ route('databank.services.index') }}" class="block px-4 py-3 text-sm text-slate-300 hover:text-white hover:bg-white/5 transition font-medium border-b border-white/5">
                                <div class="flex items-center gap-3">
                                    <span class="w-8 h-8 rounded-lg bg-pink-500/10 text-pink-400 flex items-center justify-center"><i class="fa-solid fa-box-open"></i></span>
                                    الخدمات
                                </div>
                            </a>
                            {{-- occasion types --}}
                            <a href="{{ route('databank.occasions.index') }}" class="block px-4 py-3 text-sm text-slate-300 hover:text-white hover:bg-white/5 transition font-medium border-b border-white/5">
                                <div class="flex items-center gap-3">
                                    <span class="w-8 h-8 rounded-lg bg-green-500/10 text-green-400 flex items-center justify-center"><i class="fa-solid fa-calendar-days"></i></span>
                                    أنواع المناسبات
                                </div>
                            </a>
                            {{-- packages --}}
                            <a href="{{ route('databank.packages.index') }}" class="block px-4 py-3 text-sm text-slate-300 hover:text-white hover:bg-white/5 transition font-medium">
                                <div class="flex items-center gap-3">
                                    <span class="w-8 h-8 rounded-lg bg-yellow-500/10 text-yellow-400 flex items-center justify-center"><i class="fa-solid fa-boxes-packing"></i></span>
                                    الباقات
                                </div>
                            </a>
                        </div>
                    </div>
                 </div>           
                @endif
                {{-- Security Menu --}}
                @if(Auth::user()->hasPermission($entities['security'], $actions['show']))
                    <div class="w-px h-6 bg-white/10 mx-1"></div>   
                    <div class="relative">
                            {{-- Admin Menu Button --}}
                        <button id="admin-menu-btn" onclick="toggleAdminMenu(event)" class="px-5 py-2.5 rounded-xl text-sm font-bold text-yellow-400 hover:text-yellow-300 hover:bg-yellow-400/10 transition-all flex items-center gap-2 border border-transparent hover:border-yellow-400/20">
                            <i class="fa-solid fa-shield-halved"></i> الإدارة
                            <i class="fa-solid fa-chevron-down text-[10px] transition-transform duration-200" id="admin-menu-arrow"></i>
                        </button>
                        {{-- Admin Menu DropDown --}}
                        <div id="admin-menu" class="hidden absolute top-full right-0 mt-4 w-60 bg-[#0f172a]/95 backdrop-blur-xl border border-white/10 rounded-2xl shadow-[0_10px_40px_rgba(0,0,0,0.5)] py-2 z-50 ring-1 ring-white/5 origin-top-right animate-scale-in">
                            <div class="absolute -top-2 right-6 w-4 h-4 bg-[#0f172a] border-t border-l border-white/10 transform rotate-45"></div>

                            <div class="relative z-10">
                                {{-- System Modules --}}
                              {{-- @if(Auth::user()->hasPermission($entities['system-module'], $actions['show']))              
                                <a href="{{ route('system-module.index') }}" class="block px-4 py-3 text-sm text-slate-300 hover:text-white hover:bg-white/5 transition font-medium border-b border-white/5">
                                    <div class="flex items-center gap-3">
                                        <span class="w-8 h-8 rounded-lg bg-pink-500/10 text-pink-400 flex items-center justify-center"><i class="fa-solid fa-cubes"></i></span>
                                        هيكلية النظام
                                    </div>
                                </a>  
                              @endif                                --}}
                                {{-- Roles & Rights --}}
                              @if(Auth::user()->hasPermission($entities['role-rights'], $actions['show']))  
                                <a href="{{ route('role-rights.index') }}" class="block px-4 py-3 text-sm text-slate-300 hover:text-white hover:bg-white/5 transition font-medium border-b border-white/5">
                                    <div class="flex items-center gap-3">
                                        <span class="w-8 h-8 rounded-lg bg-purple-500/10 text-purple-400 flex items-center justify-center"><i class="fa-solid fa-user-shield"></i></span>
                                        الأدوار والصلاحيات
                                    </div>
                                </a>
                               @endif 
                               @if(Auth::user()->hasPermission($entities['users'], $actions['show']))  
                                {{-- Users --}}
                                <a href="{{ route('users.index') }}" class="block px-4 py-3 text-sm text-slate-300 hover:text-white hover:bg-white/5 transition font-medium border-b border-white/5">
                                    <div class="flex items-center gap-3">
                                        <span class="w-8 h-8 rounded-lg bg-blue-500/10 text-blue-400 flex items-center justify-center"><i class="fa-solid fa-users"></i></span>
                                        المستخدمين
                                    </div>
                                </a>
                                @endif
                                {{-- Active Sessions --}}
                                @if(Auth::user()->hasPermission($entities['sessions'], $actions['show']))  
                                 <a href="{{ route('sessions.index') }}" class="block px-4 py-3 text-sm text-slate-300 hover:text-white hover:bg-white/5 transition font-medium">
                                    <div class="flex items-center gap-3">
                                        <span class="w-8 h-8 rounded-lg bg-green-500/10 text-green-400 flex items-center justify-center"><i class="fa-solid fa-clock-rotate-left"></i></span>
                                        الجلسات النشطة
                                    </div>
                                 </a>
                                @endif 
                                {{-- Admin Bookings --}}
                                @if(Auth::user()->hasPermission($entities['admin-bookings'], $actions['show']))  
                                 <a href="{{ route('admin.bookings.index') }}" class="block px-4 py-3 text-sm text-slate-300 hover:text-white hover:bg-white/5 transition font-medium">
                                     <div class="flex items-center gap-3">
                                         <span class="w-8 h-8 rounded-lg bg-blue-500/10 text-blue-400 flex items-center justify-center">
                                             <i class="fa-solid fa-calendar-check"></i>
                                         </span>
                                         إدارة الحجوزات
                                     </div>
                                 </a>
                                @endif 
                            </div>
                        </div>
                    </div>
                @endif
               @endauth
            </div>

            {{-- 3 - اللوغو --}}
            <a href="/home" class="flex items-center gap-3 group">
                <div class="hidden sm:flex flex-col items-end">
                    <span class="text-2xl font-black text-white tracking-tighter leading-none group-hover:text-blue-400 transition-colors drop-shadow-md">نَسَق</span>
                </div>
                <div class="relative w-12 h-12 bg-gradient-to-br from-white/10 to-white/5 rounded-xl p-2 transition-transform group-hover:scale-105 duration-300 border border-white/10 shadow-lg group-hover:shadow-blue-500/20">
                    <img src="{{ asset('images/logo-white.png') }}" alt="نسق" class="w-full h-full object-contain drop-shadow-md">
                </div>
            </a>
        </div>
    </nav>

    {{-- Mobile Menu Overlay --}}
    <div id="mobile-menu-overlay" class="fixed inset-0 bg-slate-950/80 backdrop-blur-sm z-[90] hidden fade-in transition-opacity duration-300" onclick="toggleMobileMenu()"></div>
    
    {{-- Mobile Menu --}}
    <div id="mobile-menu" class="mobile-menu fixed top-0 right-0 h-full w-[85%] max-w-sm bg-slate-900/95 backdrop-blur-2xl border-l border-white/10 shadow-[0_0_50px_rgba(0,0,0,0.5)] z-[100] flex flex-col">
          {{-- 1.logo --}}
        <div class="p-6 flex justify-between items-center bg-white/5 border-b border-white/5">
            <div class="flex items-center gap-3">
                <img src="{{ asset('images/logo.png') }}" alt="نسق" class="h-9 drop-shadow-lg">
                <span class="font-black text-2xl text-white tracking-tight">نَسَق</span>
            </div>
            <button onclick="toggleMobileMenu()" class="w-9 h-9 flex items-center justify-center bg-white/5 rounded-full text-slate-400 hover:bg-red-500/20 hover:text-red-400 transition border border-white/5">
                <i class="fas fa-times text-lg"></i>
            </button>
        </div>
           {{--  2 - القائمة الرئيسية في الموبايل --}}
        <div class="flex-grow overflow-y-auto p-5 space-y-2">
            <p class="px-2 text-[10px] font-bold text-blue-500 uppercase tracking-widest mb-3">التصفح</p>
            {{-- home --}}
            <a href="{{ route('home') }}" class="flex items-center gap-4 px-4 py-3.5 rounded-2xl font-bold transition-all border border-transparent {{ Request::routeIs('home') ? 'bg-blue-600 text-white' : 'text-slate-300 hover:bg-white/5 hover:text-white' }}">
                <div class="w-6 flex justify-center"><i class="fa-solid fa-house text-lg {{ Request::routeIs('home') ? 'text-yellow-300' : 'text-blue-300' }}"></i></div>
                الرئيسية
            </a>
             {{--occasions planner  --}}
            <a href="{{ route('front.planner.index') }}" class="flex items-center gap-4 px-4 py-3.5 rounded-2xl font-bold transition-all border border-transparent {{ Request::routeIs('front.planner.index') ? 'bg-blue-600 text-white' : 'text-slate-300 hover:bg-white/5 hover:text-white' }}">
                <div class="w-6 flex justify-center"><i class="fa-solid fa-wand-magic-sparkles text-lg {{ Request::routeIs('front.planner.index') ? 'text-yellow-300' : 'text-blue-300' }}"></i></div>
                خطط مناسبتك
            </a>          
            {{-- browse services --}}
            <a href="{{ route('front.services.index') }}" class="flex items-center gap-4 px-4 py-3.5 rounded-2xl font-bold transition-all border border-transparent {{ Request::routeIs('front.services.index') ? 'bg-blue-600 text-white' : 'text-slate-300 hover:bg-white/5 hover:text-white' }}">
                <div class="w-6 flex justify-center"><i class="fa-solid fa-store text-lg {{ Request::routeIs('front.services.index') ? 'text-yellow-300' : 'text-blue-300' }}"></i></div>
                تصفح الخدمات
            </a>              
            {{-- packages --}}
            <a href="{{ route('front.packages.index') }}" class="flex items-center gap-4 px-4 py-3.5 rounded-2xl font-bold transition-all border border-transparent {{ Request::routeIs('front.packages.index') ? 'bg-blue-600 text-white' : 'text-slate-300 hover:bg-white/5 hover:text-white' }}">
                <div class="w-6 flex justify-center"><i class="fa-solid fa-gift text-lg {{ Request::routeIs('front.packages.index') ? 'text-yellow-300' : 'text-blue-300' }}"></i></div>
               البكجات المميزة
            </a> 
        @auth
           {{-- DataBank --}}
          @if(Auth::user()->hasPermission($entities['databank'], $actions['show']))
            <div class="my-4 border-t border-white/5"></div>
            <p class="px-2 text-[10px] font-bold text-cyan-500 uppercase tracking-widest mb-3">بنك المعلومات</p>
            {{-- categories --}}
            <a href="{{ route('databank.categories.index') }}" class="flex items-center gap-4 px-4 py-3 rounded-2xl text-slate-300 hover:text-white hover:bg-white/5 transition font-bold {{ Request::routeIs('databank.categories.index') ? 'bg-white/5 text-cyan-400' : '' }}">
                <div class="w-6 flex justify-center"><i class="fa-solid fa-layer-group"></i></div> 
                التصنيفات
            </a>
            {{-- providers --}}
            <a href="{{ route('databank.providers.index') }}" class="flex items-center gap-4 px-4 py-3 rounded-2xl text-slate-300 hover:text-white hover:bg-white/5 transition font-bold {{ Request::routeIs('databank.providers.index') ? 'bg-white/5 text-cyan-400' : '' }}">
                <div class="w-6 flex justify-center"><i class="fa-solid fa-store"></i></div> 
                المزودين
            </a>
            {{-- services --}}
            <a href="{{ route('databank.services.index') }}" class="flex items-center gap-4 px-4 py-3 rounded-2xl text-slate-300 hover:text-white hover:bg-white/5 transition font-bold {{ Request::routeIs('databank.services.index') ? 'bg-white/5 text-cyan-400' : '' }}">
                <div class="w-6 flex justify-center"><i class="fa-solid fa-box-open"></i></div> 
                الخدمات
            </a>
            {{-- occasion types --}}
            <a href="{{ route('databank.occasions.index') }}" class="flex items-center gap-4 px-4 py-3 rounded-2xl text-slate-300 hover:text-white hover:bg-white/5 transition font-bold {{ Request::routeIs('databank.occasions.index') ? 'bg-white/5 text-cyan-400' : '' }}">
                <div class="w-6 flex justify-center"><i class="fa-solid fa-calendar-days"></i></div> 
                أنواع المناسبات
            </a>
            {{-- occasion types --}}
            <a href="{{ route('databank.packages.index') }}" class="flex items-center gap-4 px-4 py-3 rounded-2xl text-slate-300 hover:text-white hover:bg-white/5 transition font-bold {{ Request::routeIs('databank.packages.index') ? 'bg-white/5 text-cyan-400' : '' }}">
                <div class="w-6 flex justify-center"><i class="fa-solid fa-boxes-packing"></i></div> 
                الباقات
            </a>
          @endif
            {{-- Admin Area --}}
          @if(Auth::user()->hasPermission($entities['security'], $actions['show']))
            {{-- Admin Area --}}
                <div class="my-6 border-t border-white/5"></div>
                    {{-- Admin Area --}}
                <p class="px-2 text-[10px] font-bold text-yellow-500 uppercase tracking-widest mb-3">منطقة الإدارة</p>
                     {{--users  --}}
                <a href="{{ route('users.index') }}" class="flex items-center gap-4 px-4 py-3 rounded-2xl text-slate-300 hover:text-white hover:bg-white/5 transition font-bold">
                    <div class="w-6 flex justify-center"><i class="fa-solid fa-users"></i></div> 
                    المستخدمين
                </a>
                {{-- roles & rights --}}
                <a href="{{ route('role-rights.index') }}" class="flex items-center gap-4 px-4 py-3 rounded-2xl text-slate-300 hover:text-white hover:bg-white/5 transition font-bold">
                    <div class="w-6 flex justify-center"><i class="fa-solid fa-user-shield"></i></div> 
                    الأدوار والصلاحيات
                </a>
                {{-- system module --}}
                <a href="{{ route('system-module.index') }}" class="flex items-center gap-4 px-4 py-3 rounded-2xl text-slate-300 hover:text-white hover:bg-white/5 transition font-bold">
                    <div class="w-6 flex justify-center"><i class="fa-solid fa-cubes"></i></div> 
                    هيكلية النظام
                </a>
                {{-- sessions --}}
                <a href="{{ route('sessions.index') }}" class="flex items-center gap-4 px-4 py-3 rounded-2xl text-slate-300 hover:text-white hover:bg-white/5 transition font-bold">
                    <div class="w-6 flex justify-center"><i class="fa-solid fa-clock-rotate-left"></i></div> 
                    الجلسات النشطة
                </a>
                {{-- Admin Bookings Mobile --}}
                <a href="{{ route('admin.bookings.index') }}" class="flex items-center gap-4 px-4 py-3 rounded-2xl text-slate-300 hover:text-white hover:bg-white/5 transition font-bold">
                    <div class="w-6 flex justify-center text-blue-400">
                        <i class="fa-solid fa-calendar-check"></i>
                    </div> 
                    إدارة الحجوزات
                </a>
          @endif  
        @endauth     
    </div>

        {{-- 3 - user auth actions --}}
        <div class="p-5 bg-white/5 border-t border-white/5">
            {{-- guest --}}
            @guest
                <div class="grid grid-cols-2 gap-3">
                    <a href="{{ route('login') }}" class="text-center py-3.5 rounded-2xl bg-white/5 hover:bg-white/10 text-white font-bold transition border border-white/5">دخول</a>
                    <a href="{{ route('register') }}" class="text-center py-3.5 rounded-2xl bg-blue-600 hover:bg-blue-500 text-white font-bold shadow-lg shadow-blue-900/30 transition">حساب جديد</a>
                </div>
            {{-- auth --}}
            @else
                <div class="bg-slate-950/50 rounded-2xl p-4 border border-white/5 mb-3">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 rounded-xl bg-blue-600 flex items-center justify-center text-white font-bold shadow-lg">
                            {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                        </div>
                        <div class="overflow-hidden">
                            <p class="text-sm font-bold text-white truncate">{{ auth()->user()->name }}</p>
                            <p class="text-[10px] text-slate-400 truncate">{{ auth()->user()->email }}</p>
                        </div>
                    </div>
                </div>
                <form method="POST" action="{{ route('logout') }}" class="w-full">
                    @csrf
                    <button type="submit" class="w-full flex items-center justify-center gap-2 py-3 rounded-xl bg-red-500/10 hover:bg-red-500/20 text-red-400 text-xs font-bold transition">
                        <i class="fa-solid fa-right-from-bracket"></i> خروج
                    </button>
                </form>
            @endguest
        </div>
    </div>

    {{-- Main Content --}}
    <main class="relative {{ $noFlexGrow ?? false ? '' : 'flex-grow' }} container mx-auto px-4 md:px-6 py-12 fade-in z-10">
        @yield('content')
    </main>

    {{-- Footer --}}
    <footer class="relative rounded-t-3xl mt-auto bg-[#050b14]/80 backdrop-blur-xl border-t border-white/5 py-8 z-20 sticky top-[100vh]">
        <div class="absolute top-0 left-1/2 -translate-x-1/2 w-1/2 h-1 bg-gradient-to-r from-transparent via-blue-500/50 to-transparent"></div>
        <div class="container mx-auto px-6 relative z-10">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-12 text-center md:text-right">
                <div class="flex flex-col items-center md:items-start space-y-4">
                    <img src="{{ asset('images/logo-white.png') }}" alt="نسق" class="h-20 opacity-90 drop-shadow-[0_0_15px_rgba(255,255,255,0.1)]">
                    <p class="text-slate-400 text-sm leading-relaxed max-w-xs font-medium">
                        نَسَق.. منصتك الذكية لتنظيم المناسبات وحساب التكاليف بدقة وسهولة.
                    </p>
                </div>
                <div class="text-center">
                    <h4 class="text-white font-bold mb-6 text-lg relative inline-block">
                        فريق العمل
                        <span class="absolute -bottom-2 left-0 w-full h-1 bg-blue-600 rounded-full"></span>
                    </h4>
                    <div class="space-y-4 text-sm text-slate-300">
                        <div class="bg-white/5 p-3 rounded-xl border border-white/5 hover:bg-white/10 transition duration-300">
                            <p class="text-xs text-slate-400 mb-1">إعداد الطالبة</p>
                            <p class="font-bold text-blue-300 text-lg">دانيا حاتم خطايبة</p>
                            <p class="text-yellow-500/80 font-mono text-xs mt-1">ID: 1900902023</p>
                        </div>
                        <div class="bg-white/5 p-3 rounded-xl border border-white/5 hover:bg-white/10 transition duration-300">
                            <p class="text-xs text-slate-400 mb-1">إشراف الدكتور</p>
                            <p class="text-white font-bold text-lg">سيف الدين ربابعة</p>
                        </div>
                    </div>
                </div>
                <div class="text-center md:text-left flex flex-col items-center md:items-end">
                    <div class="bg-gradient-to-br from-white/5 to-white/[0.02] p-6 rounded-3xl border border-white/5 shadow-2xl relative group">
                        <p class="text-[10px] text-blue-400 mb-2 tracking-widest uppercase font-bold">المملكة الأردنية الهاشمية</p>
                        <h5 class="text-xl font-black text-white mb-2">جامعة آل البيت</h5>
                        <p class="text-xs text-slate-400 leading-relaxed max-w-[220px]">
                            كلية الأمير الحسين بن عبدالله الثاني لتكنولوجيا المعلومات
                        </p>
                    </div>
                </div>
            </div>
            <div class="border-t border-white/5 mt-12 pt-8 text-center">
                <p class="text-xs text-slate-600 font-medium tracking-wide">© {{ date('Y') }} جميع الحقوق محفوظة لمشروع نَسَق</p>
            </div>
        </div>
    </footer>

    <script>
        // دالة تبديل قائمة الإدارة
        function toggleAdminMenu(event) {
            event.stopPropagation();
            const menu = document.getElementById('admin-menu');
            const arrow = document.getElementById('admin-menu-arrow');
            const btn = document.getElementById('admin-menu-btn');
            
            document.getElementById('user-menu')?.classList.add('hidden');
            document.getElementById('databank-menu')?.classList.add('hidden');

            menu.classList.toggle('hidden');
            
            if (!menu.classList.contains('hidden')) {
                arrow.classList.add('rotate-180');
                btn.classList.add('bg-yellow-400/10', 'border-yellow-400/20');
            } else {
                arrow.classList.remove('rotate-180');
                btn.classList.remove('bg-yellow-400/10', 'border-yellow-400/20');
            }
        }

        // دالة تبديل قائمة بنك المعلومات
        function toggleDataBankMenu(event) {
            event.stopPropagation();
            const menu = document.getElementById('databank-menu');
            const arrow = document.getElementById('databank-menu-arrow');
            const btn = document.getElementById('databank-menu-btn');    
            document.getElementById('admin-menu')?.classList.add('hidden');
            document.getElementById('user-menu')?.classList.add('hidden');
            menu.classList.toggle('hidden');
            if (!menu.classList.contains('hidden')) {
                arrow.classList.add('rotate-180');
                btn.classList.add('bg-cyan-400/10', 'border-cyan-400/20');
            } else {
                arrow.classList.remove('rotate-180');
                btn.classList.remove('bg-cyan-400/10', 'border-cyan-400/20');
            }
        }
        // Mobile Menu
        const mobileMenu = document.getElementById('mobile-menu');
        const overlay = document.getElementById('mobile-menu-overlay');
        const userButton = document.getElementById('user-menu-button');
        const userMenu = document.getElementById('user-menu');

        function toggleMobileMenu() {
            const isOpen = mobileMenu.classList.contains('open');
            if (isOpen) {
                mobileMenu.classList.remove('open');
                overlay.classList.add('hidden');
                document.body.classList.remove('overflow-hidden');
            } else {
                mobileMenu.classList.add('open');
                overlay.classList.remove('hidden');
                document.body.classList.add('overflow-hidden');
            }
        }

        document.getElementById('mobile-menu-button').addEventListener('click', toggleMobileMenu);

        if (userButton && userMenu) {
            userButton.addEventListener('click', (e) => {
                e.stopPropagation();
                document.getElementById('admin-menu')?.classList.add('hidden');
                document.getElementById('databank-menu')?.classList.add('hidden');
                userMenu.classList.toggle('hidden');
                userButton.classList.toggle('bg-white/10');
            });
        }

        // إغلاق القوائم عند النقر خارجها
        document.addEventListener('click', (e) => {
            // User Menu
            if (userButton && userMenu && !userButton.contains(e.target) && !userMenu.contains(e.target)) {
                userMenu.classList.add('hidden');
                userButton.classList.remove('bg-white/10');
            }

            // Admin Menu
            const adminMenu = document.getElementById('admin-menu');
            const adminBtn = document.getElementById('admin-menu-btn');
            const adminArrow = document.getElementById('admin-menu-arrow');
            if (adminMenu && !adminMenu.contains(e.target) && !adminBtn.contains(e.target)) {
                adminMenu.classList.add('hidden');
                if(adminArrow) adminArrow.classList.remove('rotate-180');
                if(adminBtn) adminBtn.classList.remove('bg-yellow-400/10', 'border-yellow-400/20');
            }

            // DataBank Menu
            const dbMenu = document.getElementById('databank-menu');
            const dbBtn = document.getElementById('databank-menu-btn');
            const dbArrow = document.getElementById('databank-menu-arrow');
            if (dbMenu && !dbMenu.contains(e.target) && !dbBtn.contains(e.target)) {
                dbMenu.classList.add('hidden');
                if(dbArrow) dbArrow.classList.remove('rotate-180');
                if(dbBtn) dbBtn.classList.remove('bg-cyan-400/10', 'border-cyan-400/20');
            }
        });
    </script>
</body>
</html>