@extends('components.layout')

@section('title', 'تعديل المستخدم')

@section('content')

    <div class="flex justify-center fade-in">
        <div class="w-full max-w-2xl">
            
            <div class="relative bg-slate-900/80 backdrop-blur-xl border border-white/10 rounded-[2.5rem] p-8 md:p-12 shadow-2xl">
                
                <div class="absolute -top-10 -right-10 w-32 h-32 bg-blue-600/20 rounded-full blur-3xl pointer-events-none"></div>

                <h1 class="text-2xl font-black text-white mb-8 flex items-center gap-3 relative z-10">
                    <span class="w-10 h-10 rounded-xl bg-blue-600 flex items-center justify-center text-sm shadow-lg">
                        <i class="fa-solid fa-user-pen"></i>
                    </span>
                    تعديل بيانات: {{ $user->name }}
                </h1>

                @if(session('success'))
                    <div class="bg-green-500/10 text-green-400 p-4 rounded-xl mb-6 text-sm font-bold border border-green-500/20">{{ session('success') }}</div>
                @endif

                <form method="POST" action="{{ route('users.update', $user->id) }}" class="space-y-6 relative z-10">
                    @csrf
                    @method('PUT')

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div class="space-y-2">
                            <label class="block text-slate-400 text-xs font-bold uppercase tracking-wider">الاسم</label>
                            <input type="text" name="name" value="{{ $user->name }}" class="w-full bg-slate-950/50 border border-slate-700 rounded-xl px-4 py-3 text-white focus:border-blue-500 focus:ring-1 focus:ring-blue-500 transition">
                        </div>

                        <div class="space-y-2">
                            <label class="block text-slate-400 text-xs font-bold uppercase tracking-wider">البريد الإلكتروني</label>
                            <input type="email" name="email" value="{{ $user->email }}" class="w-full bg-slate-950/50 border border-slate-700 rounded-xl px-4 py-3 text-white focus:border-blue-500 focus:ring-1 focus:ring-blue-500 transition">
                        </div>

                        <div class="space-y-2">
                            <label class="block text-slate-400 text-xs font-bold uppercase tracking-wider">رقم الهاتف</label>
                            <input type="text" name="MobileNumber" value="{{ $user->MobileNumber }}" class="w-full bg-slate-950/50 border border-slate-700 rounded-xl px-4 py-3 text-white focus:border-blue-500 focus:ring-1 focus:ring-blue-500 transition text-right" dir="ltr">
                        </div>

                        <div class="space-y-2">
                            <label class="block text-slate-400 text-xs font-bold uppercase tracking-wider">الدور</label>
                            <div class="relative">
                                <select name="RoleID" class="w-full bg-slate-950/50 border border-slate-700 rounded-xl px-4 py-3 text-white focus:border-blue-500 focus:ring-1 focus:ring-blue-500 appearance-none cursor-pointer transition">
                                    <option value="">-- اختر الدور --</option>
                                    @foreach($roles as $role)
                                        <option value="{{ $role->RoleID }}" {{ $user->RoleID == $role->RoleID ? 'selected' : '' }}>{{ $role->RoleName }}</option>
                                    @endforeach
                                </select>
                                <div class="absolute left-4 top-1/2 -translate-y-1/2 pointer-events-none text-slate-500"><i class="fa-solid fa-chevron-down text-xs"></i></div>
                            </div>
                        </div>
                    </div>

                    <div class="pt-6 flex justify-end gap-3 border-t border-white/10 mt-6">
                        <a href="{{ route('users.index') }}" class="px-6 py-3 rounded-xl text-slate-300 hover:bg-white/5 font-bold transition">إلغاء</a>
                        <button type="submit" class="px-8 py-3 rounded-xl bg-gradient-to-r from-blue-600 to-indigo-600 hover:from-blue-500 hover:to-indigo-500 text-white font-bold shadow-lg shadow-blue-900/30 transition transform hover:-translate-y-1">
                            حفظ التغييرات
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

@endsection